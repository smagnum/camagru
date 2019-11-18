<?php

function checkLogin()
{
        if (is_null($_SESSION["uid"]))
        {
            header("Location: login.php");
        }
}

function isLogged()
{
        if (is_null($_SESSION["uid"]))
        {
           return (0);
        }
        return (1);
}


?>