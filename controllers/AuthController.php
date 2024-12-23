<?php

class AuthController extends Database
{
    public function __construct()
    {
        parent::__construct();  // Database konstruktorini chaqirish
       
    }

    // Kirishni tekshirish
    public function login($username, $password)
    {
        $sql = "SELECT * FROM users WHERE name = :name and password = :password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'name' => $username,
            'password' => $password
        ]);;  
        if ($result = $stmt->fetch()) {
            if ($result['name'] === $username and $result['password' === $password]) {
                $_SESSION['user'] = $username;
                return true;
            }
        }
        return false;
    }

    // Avtorizatsiyani tekshirish
    public function check()
    {
        return isset($_SESSION['user']);
    }

    // Foydalanuvchi ismini olish
    public function getUser()
    {
        return $_SESSION['user'] ?? null;
    }

    // Chiqish funksiyasi
    public function logout()
    {
        session_unset();
        session_destroy();
    }
}
