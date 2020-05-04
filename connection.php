<?php

    $link = mysqli_connect("localhost", "root", "", "alfaleusdb");
        
        if (mysqli_connect_error()) {
            
            die ("Database Connection Error");
            
        }

?>