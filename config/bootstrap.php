<?php

require_once 'autoloader.php';



// Tilni o'rnatish
$_SESSION['lang'] = $_SESSION['lang'] ?? 'uz';

// Userni login bo'lganmi yo'qmi tekshiramiz
$auth = new AuthController();
// Pdo ni ulaymiz
$pdo = new Database();
// Gruppa
$contact = new ContactController();
//SmsService 
$smsService = new SmsServiceController();
