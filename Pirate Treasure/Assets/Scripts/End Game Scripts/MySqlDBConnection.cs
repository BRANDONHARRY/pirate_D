using UnityEngine;
using UnityEngine.UI;
using MySql.Data;
using MySql.Data.MySqlClient;
using System;
using System.Data;
using System.Collections;
using System.Collections.Generic;
using System.Text;

public class MySqlDBConnection : MonoBehaviour
{
    public Text emailText;
    public Text passwordText;
    //Table column names
    //string ID, Name, Score, EnemiesDefeated, TreasureCollected, TimeSurvived, CannonballsFired;
    string emailInput, passwordInput, userIDVal;
    public Text currentScore, currentKills, currentChests, currentTime, currentShots, infoText, invalidLoginText;
    public InputField emailIn, passwordIn;
    public Button loginButton, submitNewButton, keepOldButton;

    bool saving;
    bool loading;

    //Connection String
    string constr = "Server=Proj-mysql.uopnet.plymouth.ac.uk;Database=COMP2003_D;User ID=COMP2003_D;Password=VitW270*;Pooling=true";

    // connection object
    MySqlConnection con = null;
    // command object
    MySqlCommand cmd = null;
    // reader object
    MySqlDataReader rdr = null;

    void Awake()
    {
        try
        {
            // setup the connection element
            con = new MySqlConnection(constr);

            // lets see if we can open the connection
            con.Open();
            Debug.Log("Connection State: " + con.State);
        }
        catch (Exception ex)
        {
            Debug.Log(ex.ToString());
        }

    }

    void OnApplicationQuit()
    {
        Debug.Log("killing con");
        if (con != null)
        {
            if (con.State.ToString() != "Closed")
                con.Close();
            con.Dispose();
        }
    }
    // Start is called before the first frame update
    void Start()
    {

    }

    // Update is called once per frame
    void Update()
    {

    }

    public void LoginCheck()
    {
        Debug.Log("Running Login Check");
        bool valid = false;
        emailInput = emailText.text;
        passwordInput = passwordText.text;

        string query = string.Empty;

        try
        {
            query = "SELECT userID, email, password FROM usertbl WHERE email = '" + emailInput + "' AND password = '" + passwordInput+"'";
            if(con.State.ToString() != "Open")
            {
                con.Open();
            }
            using (con)
            {
                using(cmd = new MySqlCommand(query, con))
                {
                    rdr = cmd.ExecuteReader();
                    if (rdr.HasRows)
                    {
                        valid = true;
                        Debug.Log("Login Valid!");

                        userIDVal = rdr["userID"].ToString();

                        GetCurrentStats();
                        
                    }
                    else
                    {
                        Debug.Log(query);
                        Debug.Log(rdr.HasRows);
                        Debug.Log("Invalid Login with credentials " +emailInput+ " and " + passwordInput);
                        
                    }
                }
            }
        }
        catch (Exception ex)
        {
            Debug.Log(ex.ToString());
        }
    }
    public void LoginCheckProcedure()
    {
        Debug.Log("Running Login Check");
        bool valid = false;
        emailInput = emailText.text;
        passwordInput = passwordText.text;

        string query = string.Empty;

        try
        {
            query = "login";
            if (con.State.ToString() != "Open")
            {
                con.Open();
            }
            using (con)
            {
                using (cmd = new MySqlCommand(query, con))
                {
                    cmd.CommandType = CommandType.StoredProcedure;
                    cmd.Parameters.AddWithValue("@emailVar", emailInput);
                    cmd.Parameters.AddWithValue("@passwordVar", passwordInput);

                    if (Convert.ToInt32(cmd.ExecuteScalar()) > 0)
                    {
                        valid = true;
                        Debug.Log("Login Valid!");
                        invalidLoginText.gameObject.SetActive(false);
                        query = "SELECT userID FROM usertbl WHERE email = @emailVar";
                        using (cmd = new MySqlCommand(query, con))
                        {
                            cmd.Parameters.AddWithValue("@emailVar", emailInput);
                            rdr = cmd.ExecuteReader();
                            if (rdr.HasRows)
                            {
                                if (rdr.Read())
                                {
                                    userIDVal = rdr["userID"].ToString();
                                    userIDVal = Convert.ToString(rdr.GetInt32(0));
                                    DataHandler.setID(Convert.ToInt32(userIDVal));
                                }

                            }
                            else
                            {
                                Debug.Log("No Data Found");

                            }
                        }
                        rdr.Close();
                        Debug.Log("Getting Stats");
                        //GetCurrentStats();
                        DisplayChange();

                    }
                    else
                    {
                        Debug.Log("Invalid Login with credentials " + emailInput + " and " + passwordInput);
                        invalidLoginText.gameObject.SetActive(true);

                    }
                }
            }
            
        }
        catch (Exception ex)
        {
            Debug.Log(ex.ToString());
            invalidLoginText.gameObject.SetActive(true);
            invalidLoginText.text = ex.ToString();
        }
    }

    public void InsertNewEntries()
    {
        string query = string.Empty;
        try
        {
            query = "INSERT INTO statstbl (userID, highScore, kills, chestsCollected, time, ballsFired) VALUES (?ID, ?Score, ?Kills, ?Chests, ?Time, ?Fired)";
            if (con.State.ToString() != "Open")
            {
                con.Open();
            }
            using (con)
            {
                using (cmd = new MySqlCommand(query, con))
                {
                    MySqlParameter uIDParam = cmd.Parameters.Add("?ID", MySqlDbType.VarChar);
                    uIDParam.Value = userIDVal;
                    MySqlParameter scoreParam = cmd.Parameters.Add("?Score", MySqlDbType.VarChar);
                    scoreParam.Value = DataHandler.getScore();
                    MySqlParameter killsParam = cmd.Parameters.Add("?Kills", MySqlDbType.VarChar);
                    killsParam.Value = DataHandler.getKills();
                    MySqlParameter chestsParam = cmd.Parameters.Add("?Chests", MySqlDbType.VarChar);
                    chestsParam.Value = DataHandler.getTreasure();
                    MySqlParameter timeParam = cmd.Parameters.Add("?Time", MySqlDbType.VarChar);
                    timeParam.Value = DataHandler.getTime();
                    MySqlParameter firedParam = cmd.Parameters.Add("?Fired", MySqlDbType.VarChar);
                    firedParam.Value = DataHandler.getShots();

                    Debug.Log("Submitted New Stats");

                }

            }
        }
        catch (Exception ex)
        {
            Debug.Log(ex.ToString());
        }
    }

    public void UpdateEntries()
    {
        string query = string.Empty;
        try
        {
            query = "insertStats";
            if (con.State.ToString() != "Open")
                con.Open();
            using (con)
            {
                
                using (cmd = new MySqlCommand(query, con))
                {
                    cmd.CommandType = CommandType.StoredProcedure;
                    cmd.Parameters.AddWithValue("@ID", DataHandler.getID());

                    cmd.Parameters.AddWithValue("@highScore", DataHandler.getScore());
                    cmd.Parameters.AddWithValue("@kills", DataHandler.getKills());
                    cmd.Parameters.AddWithValue("@timeSurvived", DataHandler.getTime());
                    cmd.Parameters.AddWithValue("@ballsFired", DataHandler.getShots());
                    cmd.Parameters.AddWithValue("@chestsCollected", DataHandler.getTreasure());

                    //MySqlParameter scoreParam = cmd.Parameters.Add("?Score", MySqlDbType.VarChar);
                    //scoreParam.Value = DataHandler.getScore();
                    //MySqlParameter killsParam = cmd.Parameters.Add("?Kills", MySqlDbType.VarChar);
                    //killsParam.Value = DataHandler.getKills();
                    //MySqlParameter chestsParam = cmd.Parameters.Add("?Chests", MySqlDbType.VarChar);
                    //chestsParam.Value = DataHandler.getTreasure();
                    //MySqlParameter timeParam = cmd.Parameters.Add("?Time", MySqlDbType.VarChar);
                    //timeParam.Value = DataHandler.getTime();
                    //MySqlParameter firedParam = cmd.Parameters.Add("?Fired", MySqlDbType.VarChar);
                    //firedParam.Value = DataHandler.getShots();

                    Debug.Log(userIDVal);

                    cmd.ExecuteNonQuery();

                    Debug.Log("Finished Update Code");

                }

            }
        }
        catch (Exception ex)
        {
            Debug.Log(ex.ToString());
        }
    }

    void GetCurrentStats()
    {
        string query = string.Empty;
        try
        {
            query = "SELECT highScore, kills, chestsCollected, time, ballsFired FROM statstbl WHERE userID = " + userIDVal;
            if (con.State.ToString() != "Open")
                con.Open();
            using (con)
            {
                using (cmd = new MySqlCommand(query, con))
                {
                    rdr = cmd.ExecuteReader();
                    if (rdr.HasRows)
                    {
                        while (rdr.Read())
                        { 
                            currentScore.gameObject.SetActive(true);
                            currentScore.text = "Score: " + rdr["highScore"].ToString();
                            currentKills.gameObject.SetActive(true);
                            currentKills.text = "Enemies Defeated: "+ rdr["kills"].ToString();
                            currentChests.gameObject.SetActive(true);
                            currentChests.text = "Treasure Chests Collected: " + rdr["chestsCollected"].ToString();
                            currentTime.gameObject.SetActive(true);
                            currentTime.text = "Time Survived: " + rdr["time"].ToString() + " Seconds";
                            currentShots.gameObject.SetActive(true);
                            currentShots.text = "Cannonballs Fired: " + rdr["ballsFired"].ToString();



                            infoText.enabled = false;
                            emailIn.gameObject.SetActive(false);
                            passwordIn.gameObject.SetActive(false);
                            loginButton.gameObject.SetActive(false);

                            
                            keepOldButton.gameObject.SetActive(true);
                            submitNewButton.gameObject.SetActive(true);
                        }
                    }
                }
                rdr.Close();   
            }
        }
        catch(Exception ex)
        {
            Debug.Log(ex.ToString());
        }
    }

    void DisplayChange()
    {
        infoText.enabled = false;
        emailIn.gameObject.SetActive(false);
        passwordIn.gameObject.SetActive(false);
        loginButton.gameObject.SetActive(false);
        submitNewButton.gameObject.SetActive(true);
    }

    //public void getHashes()
    //{
    //    string query = string.Empty;
    //    try
    //    {
    //        query = "SELECT password FROM usertbl";
    //        if (con.State.ToString() != "Open")
    //            con.Open();
    //        using (con)
    //        {
    //            using (cmd = new MySqlCommand(query, con))
    //            {
    //                rdr = cmd.ExecuteReader();
    //                if (rdr.HasRows)
    //                {
    //                    while (rdr.Read())
    //                    {
    //                        Debug.Log(rdr["password"].ToString());
    //                    }
    //                }
    //            }

    //        }
    //    }
    //    catch (Exception ex)
    //    {
    //        Debug.Log(ex.ToString());
    //    }
    //}

}

