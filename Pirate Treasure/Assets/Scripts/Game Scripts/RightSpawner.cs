using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Tilemaps;

public class RightSpawner : MonoBehaviour
{
    [SerializeField]
    private GameObject MonsterPrefab;

    public int maxMonsters = 10;

    public List<GameObject> Monsters = new List<GameObject>();
    GameObject[] MonsterTags;

    public int spawnBound = 10;
    public float CheckRadius = 1f;

    public List<float> floatLog = new List<float>();

    public int pauseVal = 480;
    int pause;

    // Start is called before the first frame update
    void Start()
    {
        pause = pauseVal;
    }
    // Update is called once per frame
    void Update()
    {
        pause--;

        MonsterTags = GameObject.FindGameObjectsWithTag("Monsters");
        Monsters.Clear();

        for (int i = 0; i < MonsterTags.Length; i++)
        {
            Monsters.Add(MonsterTags[i]);
        }

        if (pause <= 0)
        {
            SpawnMonster();
            pause = pauseVal;
        }
    }

    void SpawnMonster()
    {
        System.Random rand = new System.Random();
        Vector3 position = new Vector3(1000,1000);
        bool valid = false;
        if (Monsters.Count < maxMonsters)
        {
            int replaceCount = maxMonsters - Monsters.Count;

            
            for (int count = 0; count < replaceCount;)
            {
                do
                {
                    float randX = rand.Next(-spawnBound, spawnBound);
                    float randXPoint = rand.Next(0, 9);
                    float X = Convert.ToSingle(randX.ToString() + "." + randXPoint.ToString());

                    float randY = rand.Next(-spawnBound, spawnBound);
                    float randYPoint = rand.Next(0, 9);
                    float Y = Convert.ToSingle(randY.ToString() + "." + randYPoint.ToString());

                    while (X > 0 && X < 1)
                    {
                        randX = rand.Next(-spawnBound, spawnBound);
                        randXPoint = rand.Next(0, 9);
                        X = Convert.ToSingle(randX.ToString() + "." + randXPoint.ToString());

                    }
                    while (Y > 0 && Y < 1)
                    {
                        randY = rand.Next(-spawnBound, spawnBound);
                        randYPoint = rand.Next(0, 9);
                        Y = Convert.ToSingle(randY.ToString() + "." + randYPoint.ToString());
                    }
                    floatLog.Add(X);
                    floatLog.Add(Y);
                    position = Camera.main.ViewportToWorldPoint(new Vector3(X, Y));

                } while (Physics2D.OverlapCircleAll(position, CheckRadius).Length > 0);

                Instantiate(MonsterPrefab, position, Quaternion.identity);
                count++;
            }
        }
    }
}
