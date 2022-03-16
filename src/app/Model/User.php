<?php

namespace App\Model;

class User extends Model
{

    public function find(string|int $username)
    {
        $sttm = $this->pdo->prepare('SELECT * FROM users where username = :username');
        $sttm->bindParam(':username', $username);

        $sttm->execute();

        return $sttm->fetch();
    }

}