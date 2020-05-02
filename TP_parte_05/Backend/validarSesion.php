<?php

session_start();

if((isset($_SESSION["DNIEmpleado"])==false))
{ 
    header("..\Frontend\login.html");
}