<?php
/*
 * Данный абстрактный класс отображает реальную таблицу по лотам в БД и содержит
 * методы set и get для установки и получения значений свойств соответсвенно. Вся работа с СУБД
 * производиться непосредственно в классе наследнике в App\Model\ModelLot .
 * Фильтрация входных данных также осуществляется в данном классе в методах set.
 * */

namespace App\Entity;


abstract class Lot
{
    private $id;
    private $title;
    private $user_id;
    private $last_id;
    private $price;
    private $step;
    private $deadline;

    function getId(): int
    {
        return $this->id;
    }

    function setTitle(string $title)
    {
        $this->title = htmlentities($title);
    }

    function getTitle(): string
    {
        return $this->title;
    }

    function setUserId(int $user_id)
    {
        if(is_int($user_id))
        {
            $this->user_id = $user_id;
        }
            else return false;

    }

    function getUserId(): int
    {
        return $this->user_id;
    }

    function getLastId(): int
    {
        return $this->last_id;
    }

    function setPrice(int $price)
    {
        if(is_int($price))
        {
            $this->price = $price;
        }
            else return false;
    }

    function getPrice(): int
    {
        return $this->price;
    }

    function setStep(int $step)
    {
        if(is_int($step))
        {
            $this->step = $step;
        }
            else return false;
    }

    function getStep(): int
    {
        return $this->step;
    }

    function setDeadline($date)
    {
        $this->deadline = $date;
    }

    function getDeadline(): string
    {
        return $this->deadline;
    }

}