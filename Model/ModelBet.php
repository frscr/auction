<?php
/*
 * Метод select_lot возвращает только один выбранный лот по значению id
 * */

namespace App\Model;

use App\Entity\Bet;
use http\Message;

class ModelBet extends Bet
{
    function select_lot(): array
    {
        $constant = 'constant';
        $charset = 'utf8';
        $lot = [];
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";
        try
        {
            $pdo = new \PDO($dsn, USER, PASSU);
        }
        catch (\PDOException $e)
        {
            die("Подключение не удалось" . $e->getMessage());
        }
        $sql = $pdo->prepare("SELECT * FROM lots WHERE id = :id");
        $sql->bindValue(':id', $this->getId());
        $sql->execute();
        foreach ($sql as $item)
        {
            $lot = ['id'=>$item['id'], 'title'=>$item['title'], 'price'=>$item['price'], 'step'=>$item['step']];
        }
        if(!$lot){
            die("Лот не найден.");
        }
        return $lot;
    }

    function do_bet()
    {
        $lot = [];
        $price = 0;
        $step = 0;
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
        $sql = $pdo->prepare("SELECT price, step FROM lots WHERE id = :id");
        $sql->bindValue(':id', $this->getId());
        $sql->execute();
        foreach ($sql as $row)
        {
            $price = $row['price'];
            $step = $row['step'];
        }
        $sql = null;
        if($step > $this->getStep())
        {
            die("Ставка на лот должна быть не менее чем ".$step);
        }
        $sql = $pdo->prepare("UPDATE lots SET price = price + ? WHERE id = ?");
        $sql->execute([$this->getStep(), $this->getId()]);

    }
}