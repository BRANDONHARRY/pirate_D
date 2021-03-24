using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Tilemaps;

public class TreasureSpawner : MonoBehaviour
{
    [SerializeField]
    private GameObject ChestPrefab;

    public int maxChests = 10;

    public Tilemap tileMap = null;

    public List<Vector3> availablePlaces;

    public List<GameObject> Chests = new List<GameObject>();
    GameObject[] ChestTags;

    public int pauseVal = 120;
    int pause;

    // Start is called before the first frame update
    void Start()
    {
        pause = pauseVal;
        tileMap = transform.parent.GetComponent<Tilemap>();
        availablePlaces = new List<Vector3>();

        for (int count = tileMap.cellBounds.xMin; count < tileMap.cellBounds.xMax;)
        {
            for(int ycount = tileMap.cellBounds.yMin; ycount < tileMap.cellBounds.yMax;)
            {
                Vector3Int localPlace = new Vector3Int(count, ycount, (int)tileMap.transform.position.y);
                Vector3 place = tileMap.CellToWorld(localPlace);
                if (tileMap.HasTile(localPlace))
                {
                    availablePlaces.Add(place);
                }
                ycount++;
            }
            count++;
        }
    }

    // Update is called once per frame
    void Update()
    {
        pause--;

        ChestTags = GameObject.FindGameObjectsWithTag("Chests");
        Chests.Clear();

        for (int i = 0; i < ChestTags.Length; i++)
        {
            Chests.Add(ChestTags[i]);
        }

        if(pause <= 0)
        {
            SpawnChest();
            pause = pauseVal;
        }
    }

    void SpawnChest()
    {
        System.Random rand = new System.Random();
        int random;
        if (Chests.Count < maxChests)
        {
            int replaceCount = maxChests - Chests.Count;
            for(int count = 0; count < replaceCount;)
            {
                random = rand.Next(0, availablePlaces.Count);
                Instantiate(ChestPrefab, new Vector3 (availablePlaces[random].x +0.32f, availablePlaces[random].y +0.32f), Quaternion.identity);
                count++;
            }
        }
    }
}
