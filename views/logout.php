<?php
require_once '../config/bootstrap.php';


$auth->logout();

// Login sahifasiga qaytish
header("Location: login.php");
exit();
?>
