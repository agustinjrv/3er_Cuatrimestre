<?php
session_start();
session_unset();			
header("Location: ../Frontend/login.html");
