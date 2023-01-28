<?php

session_start();
session_destroy();
header("location: ../routes/login.php");

?>
