<?php
namespace App\Model;

use App\Entity\Lot;

class ModelBet extends Lot
{
    function connect()
    {
        $constant = 'constant';
        $charset = 'utf8';
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";
        try {
            $pdo = new \PDO($dsn, USER, PASSU);
        }
        catch (\PDOException $e) {
            die("Подключение не удалось" . $e->getMessage());
        }
        return $pdo;
    }

    function select_lot(): array
    {
        $lot = [];
        $pdo = $this->connect();
        $sql = $pdo->prepare("SELECT * FROM lots WHERE id = :id");
        $sql->bindValue(':id', $this->getId());
        $sql->execute();
        $pdo = null;
        foreach ($sql as $item) {
            $lot = ['id'=>$item['id'], 'title'=>$item['title'], 'price'=>$item['price'], 'step'=>$item['step']];
        }
        if(!$lot) {
            die("Лот не найден.");
        }
        return $lot;
    }

    function do_bet()
    {
        $step = 0;
        $deadline = '';
        $pdo = $this->connect();
        $sql = $pdo->prepare("SELECT price, step, user_id, deadline FROM lots WHERE id = :id");
        $sql->bindValue(':id', $this->getId());
        $sql->execute();
        foreach ($sql as $row) {
            $price = $row['price'];
            $step = $row['step'];
            $user_id = $row['user_id'];
            $deadline = $row['deadline'];
        }
        $sql = null;
        if($user_id == $this->getUserId()) {
            die("Нельзя делать ставки на свои лоты");
        }
        if($deadline < date("Y-m-d H:i:s")) {
            die("Время лота истекло");
        }
        if($step > $this->getStep()) {
            die("Ставка на лот должна быть не менее чем ".$step);
        }
        $sql = $pdo->prepare("UPDATE lots SET price = price + ? WHERE id = ?");
        $sql->execute([$this->getStep(), $this->getId()]);
        $pdo = null;
    }
}