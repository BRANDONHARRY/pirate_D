using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using System;

public class SetStats : MonoBehaviour
{
    public Text Score;
    public Text Kills;
    public Text Treasure;
    public Text Time;
    public Text Shots;
    // Start is called before the first frame update
    void Start()
    {
        Score.text = "Score: " + Convert.ToString(DataHandler.getScore());
        Kills.text = "Enemies Defeated: " + Convert.ToString(DataHandler.getKills());
        Treasure.text = "Treasure Chests Collected: " + Convert.ToString(DataHandler.getTreasure());
        Time.text = "Time Survived: " + Convert.ToString(DataHandler.getTime()) + " seconds";
        Shots.text = "Cannonballs Fired: " + Convert.ToString(DataHandler.getShots());

    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
