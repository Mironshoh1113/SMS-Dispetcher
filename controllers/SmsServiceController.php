<?php

class SmsServiceController extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function SaveSMS($groupId, $message)
    {
        $sql = "INSERT INTO messages (group_id,message)
        VALUES (?,?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$groupId, $message]);
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getGroupSMS($groupId)
    {
        $sql = "SELECT * FROM messages where group_id = ? and deleted_at is NULL  order by id desc";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$groupId]);
        $result = $stmt->fetchAll();

        return $result;
    }

    public function getStatus()
    {
        return true;
    }

    public function clearHistory($groupIdClearHistory)
    {
        $sql = ' UPDATE messages SET deleted_at = ? WHERE group_id =? ';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([date("Y-m-d H:i:s"), $groupIdClearHistory]);

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
