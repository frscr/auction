<?php


namespace App\Model;

use App\Entity\Lot;


class ModelLot extends Lot
{
    function create_lot()
    {

        $constant = 'constant';
        $charset = 'utf8';
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";

        try
        {
            $pdo = new \PDO($dsn, USER, PASSU);
        }
        catch (\PDOException $e)
        {
            die("Подключение не удалось" . $e->getMessage());
        }


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
        $constant = 'constant';
        $charset = 'utf8';
        $lots = [];
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";

        try
        {
            $pdo = new \PDO($dsn, USER, PASSU);
        }
        catch (\PDOException $e)
        {
            die("Подключение не удалось" . $e->getMessage());
        }

        $sql = $pdo->query("SELECT * FROM lots");
        while($row = $sql->fetch())
        {
            $lots[] = ['id'=>$row['id'],'title'=>$row['title'],'price'=>$row['price'],'step'=>$row['step']];
        }
        return $lots;
    }

    function show_my_lots(): array
    {
        $constant = 'constant';
        $charset = 'utf8';
        $lots = [];
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";
        try
        {
            $pdo = new \PDO($dsn, USER,PASSU);
        }
        catch (\PDOException $e)
        {
            die("Подключение не удалось". $e ->getMessage());
        }
        $sql = $pdo->prepare("SELECT * FROM lots WHERE user_id = :user_id");
        $sql->execute(array('user_id'=>$this->getUserId()));
        foreach ($sql as $row)
        {
            $lots[] = ['title'=>$row['title'], 'price'=>$row['price'], 'step'=>$row['step']];
        }
        return $lots;
    }

    function drop_lot()
    {

    }
}