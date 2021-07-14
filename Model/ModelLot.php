<?php
namespace App\Model;

use App\Entity\Lot;


class ModelLot extends Lot
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

    function create_lot()
    {
        $today = strtotime(date("Y-m-d H:i:s"));
        $deadline = strtotime($this->getDeadline());
        if($today >= $deadline) {
            die("Дата и время завершения лота должны быть позднее текущих.");
        }
        $pdo = $this->connect();
        $sql = $pdo->prepare("INSERT INTO lots(title, user_id, price, step, deadline) VALUES (:title, :user_id, :price, :step, :deadline)");
        $sql->bindValue(':title', $this->getTitle());
        $sql->bindValue(':user_id', $this->getUserId());
        $sql->bindValue(':price', $this->getPrice());
        $sql->bindValue(':step', $this->getStep());
        $sql->bindValue(':deadline', $this->getDeadline());
        $sql->execute();
        $sql = null;
        $pdo = null;

    }

    function show_lots(): array
    {
        $lots = [];
        $pdo = $this->connect();
        $sql = $pdo->query("SELECT * FROM lots");
        $sql->execute();
        $pdo = null;
        while($row = $sql->fetch()) {
            $lots[] = ['id'=>$row['id'],'title'=>$row['title'],'price'=>$row['price'],'step'=>$row['step'], 'deadline'=>$row['deadline']];
        }
        return $lots;
    }

    function show_my_lots(): array
    {
        $lots = [];
        $pdo = $this->connect();
        $sql = $pdo->prepare("SELECT * FROM lots WHERE user_id = :user_id");
        $sql->execute(array('user_id'=>$this->getUserId()));
        $pdo = null;
        foreach ($sql as $row) {
            $lots[] = ['id'=>$row['id'],'title'=>$row['title'], 'price'=>$row['price'], 'step'=>$row['step']];
        }
        return $lots;
    }

    function drop_lot()
    {
        $pdo = $this->connect();
        $sql = $pdo->prepare("DELETE FROM lots WHERE id = :id AND user_id = :user_id LIMIT 1");
        $sql->execute(array('id'=>$this->getId(), 'user_id'=>$this->getUserId()));
        $pdo = null;
    }
}