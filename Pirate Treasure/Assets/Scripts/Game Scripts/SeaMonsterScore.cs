using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class SeaMonsterScore : MonoBehaviour
{
    public int score = 1;
    public GameObject playerBoat;
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    public void KillScore()
    {
        playerBoat = GameObject.FindGameObjectWithTag("Player");
        DataHandler.addKill();
        playerBoat.transform.SendMessage("AddScore", score, SendMessageOptions.DontRequireReceiver);
    }
}
