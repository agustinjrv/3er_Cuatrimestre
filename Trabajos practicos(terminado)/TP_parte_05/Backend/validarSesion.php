<?php

session_start();

if(isset($_SESSION["DNIEmpleado"])==false)
{ 
    header("LOCATION: ..\Frontend\login.html");
}