<?php
session_start();
session_destroy();
header("Location: ../index.php");  // ke root/index.php
exit();
?>