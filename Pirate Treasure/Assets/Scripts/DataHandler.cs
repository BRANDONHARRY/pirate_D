using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public static class DataHandler
{
    private static int score, kills = 0, treasure = 0, shots = 0, id = -1;
    private static float time = 0;



    public static int getScore()
    {
        return score;
    }
    public static void setScore(int inScore)
    {
        score = inScore;
    }

    public static int getKills()
    {
        return kills;
    }
    public static void setKills(int inKills)
    {
        kills = inKills;
    }
    public static void addKill()
    {
        kills = kills + 1;
    }

    public static int getTreasure()
    {
        return treasure;
    }
    public static void setTreasure(int inTreasure)
    {
        treasure = inTreasure;
    }
    public static void addTreasure()
    {
        treasure = treasure + 1;
    }

    public static float getTime()
    {
        return time;
    }
    public static void setTime(float inTime)
    {
        time = inTime;
    }

    public static int getShots()
    {
        return shots;
    }
    public static void setShots(int inShots)
    {
        shots = inShots;
    }
    public static void addShot()
    {
        shots = shots + 1;
    }

    public static int getID()
    {
        return id;
    }
    public static void setID(int inID)
    {
        id = inID;
    }
    

}
