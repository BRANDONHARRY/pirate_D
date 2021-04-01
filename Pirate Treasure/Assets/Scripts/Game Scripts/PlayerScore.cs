using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class PlayerScore : MonoBehaviour
{
    public delegate void UpdateScore(int newScore);
    public static event UpdateScore OnUpdateScore;

    public int totalScore = 0;
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    public void AddScore (int Score)
    {
        //totalScore = totalScore + Score;
        Debug.Log("Recieving Score Up");
        if (OnUpdateScore != null)
        {
            OnUpdateScore(Score);
        }
    }
}
