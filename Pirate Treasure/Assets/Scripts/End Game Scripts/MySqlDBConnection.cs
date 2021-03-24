using UnityEngine;
using UnityEngine.UI;
using MySql.Data;
using MySql.Data.MySqlClient;
using System;
using System.Data;
using System.Collections;
using System.Collections.Generic;

public class MySqlDBConnection : MonoBehaviour
{
    public Text emailText;
    public Text passwordText;
    //Table column names
    //string ID, Name, Score, EnemiesDefeated, TreasureCollected, TimeSurvived, CannonballsFired;
    string emailInput, passwordInput, userIDVal;
    public Text currentScore, currentKills, currentChests, currentTime, currentShots;

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
            query = "SELECT userID, email, password FROM usertbl WHERE email = '" + emailInput + "' AND password = '" + passwordInput+ "'" ;
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
                        Debug.Log("Invalid Login");
                    }
                }
            }
        }
        catch (Exception ex)
        {
            Debug.Log(ex.ToString());
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
            query = "UPDATE statstbl SET highScore=?Score, kills = ?Kills, chestsCollected = ?Chests, time = ?Time, ballsFired = ?Fired WHERE userID = " + userIDVal;
            if (con.State.ToString() != "Open")
                con.Open();
            using (con)
            {
                using (cmd = new MySqlCommand(query, con))
                {
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
                            currentScore.enabled = true;
                            currentScore.text = rdr["highScore"].ToString();
                            currentKills.enabled = true;
                            currentKills.text = rdr["kills"].ToString();
                            currentChests.enabled = true;
                            currentChests.text = rdr["chestsCollected"].ToString();
                            currentTime.enabled = true;
                            currentTime.text = rdr["time"].ToString();
                            currentShots.enabled = true;
                            currentShots.text = rdr["ballsFired"].ToString();
                        }
                    }
                }
                    
            }
        }
        catch(Exception ex)
        {
            Debug.Log(ex.ToString());
        }
    }
}

