<?php
session_start();
unset($_SESSION["stud_num"]);
unset($_SESSION["admin_id"]);
unset($_SESSION["password"]);
header("Location:index.php");
?> 