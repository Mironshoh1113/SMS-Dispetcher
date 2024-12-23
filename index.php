<?php
require_once 'config/bootstrap.php';


if (!$auth->check()) {
    header("Location: /views/login.php");
    exit();
}else{
    header("Location: /views/main.php");
exit();
}



 
 

