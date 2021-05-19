using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class WebsiteLink : MonoBehaviour
{
    // Start is called before the first frame update
    void Start()
    {
        
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    public void goToSite()
    {
        Application.OpenURL("http://web.socem.plymouth.ac.uk/COMP2003/COMP2003_D/website/public/index.php");
    }
}
