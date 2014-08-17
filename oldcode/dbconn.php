<?php
    $vusername = "YOUR DATA BASE USER NAME";              //your username for you local system 
    $pwd ="YOUR DATA BASE PASSWORD";                  //password to accecss mySQL 
    $host = "DATA BASE SERVER NAME";               //host is localhost - even for most web hosts 
    $dbname = "YOUR DATA BASE NAME";               //db name to be accessed 

    

    if (!($conn=mysql_connect($host, $vusername, $pwd)))  { 
        printf("We couldn't connect to the database right now!"); 
        exit; 
    } 
       $db=mysql_select_db($dbname,$conn) or die("Unable to connect to database!"); 
        
?> 
