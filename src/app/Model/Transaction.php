<?php

namespace App\Model;

class Transaction extends Model
{

    public function insert(array $transactions)
    {
        $data = "";
        foreach ($transactions as $transaction) {
            $data .= "('".$_SESSION['AUTH_USER']['id']."','".implode("','", $transaction)."'),";
        }
        $data = str_replace("''", 'null', trim($data, ','));

        $sttm = $this->pdo->prepare(
            "INSERT INTO `transactions` (`user_id`, `check`, `description`, `amount`, `date`)
               VALUES ".$data
        );

        var_dump($sttm);
        $sttm->execute();

        return $this->pdo->query('Select * from `transactions`')->fetchAll();
    }


    public function get(): array
    {
        $sttm = $this->pdo->prepare('select * from transactions where user_id = ?');
        $sttm->execute([$_SESSION['AUTH_USER']['id']]);

        $items = $sttm->fetchAll();
        return $items ? $items : [];
    }
}