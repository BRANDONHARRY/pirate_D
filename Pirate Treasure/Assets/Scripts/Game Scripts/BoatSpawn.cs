using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BoatSpawn : MonoBehaviour
{
    [SerializeField]
    private GameObject BoatPrefab;
    // Start is called before the first frame update
    void Start()
    {
        Instantiate(BoatPrefab, new Vector3(191, Convert.ToSingle(0.81)), Quaternion.identity);
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
