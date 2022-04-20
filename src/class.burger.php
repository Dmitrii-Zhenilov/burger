<?php
class Burger {


    public function getUserByEmail(string $email)
    {
        $db = Db::getInstanse();
        $query = "SELECT * FROM users WHERE email =:email";
        return $db->fetchOne($query, __METHOD__, [':email' => $email]);
    }

    public function createUser(string $email, string $name)
    {
        $db = Db::getInstanse();
        $query = "INSERT INTO users(email, `name`) VALUES(:email, :name)";
        $result = $db->exec($query, __METHOD__, [':email' => $email, ':name' => $name]);
        if(!$result) {
            return false;
        }

        return $db->lastInsertId();
    }

    public function addOrder(int $userId, array $data)
    {
        $db = Db::getInstanse();
        $query = "INSERT INTO users(user_id, address, created_at) VALUES(:user_id,:address, :created_at)";
        $result = $db->exec(
            $query,
            __METHOD__,
            [
                ':user_id' => $userId,
                ':address' => $data['address'],
                ':created_at' => date('Y-m-d H:i:s'),

            ]
        );
        if (!$result) {
            return false;
        }
        return $db->lastInsertId();
    }

    public function incOrders($userId)
    {
        $db = Db::getInstance();
        $query = "UPDATE users SET orders_count = orders_count +1 WHERE id = $userId";
        return $db->exec($query, __METHOD__);
    }
}