<?php

class ContactController extends Database
{

    public function __construct()
    {
        parent::__construct();  // Database konstruktorini chaqirish
    }

    public function getGroups()
    {
        $sql = 'SELECT * FROM groups ';
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getNumbers()
    {
        $sql = 'SELECT * FROM numbers ';
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }  
    public function getNumbersGroup($id)
    {
        $sql = "SELECT * FROM numbers WHERE group_id = $id";
        $stmt = $this->pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }
    public function addPhoneNumber($groupId, $phoneNumber, $name)
    {
        $sql = 'INSERT INTO numbers (group_id,phone_number,name) VALUES (?,?,?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$groupId, $phoneNumber,$name]);
        $result = $stmt->fetch();

        return true;
    }

    public function removePhoneNumber($number_id, $phoneNumber)
    {
        $sql = 'DELETE FROM numbers WHERE id = ? AND phone_number = ?';
        $stmt = $this->pdo->prepare($sql);
        
        // So'rovni bajarish
        $stmt->execute([$number_id, $phoneNumber]);
    
        // O'chirilgan qatorlar sonini olish
        $rowsAffected = $stmt->rowCount();
    
        // Agar hech narsa o'chirilmagan bo'lsa, false qaytarish
        if ($rowsAffected > 0) {
            return true;
        } else {
            return false;  // Agar telefon raqami mavjud bo'lmasa
        }
    }
    
}
