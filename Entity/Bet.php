<?php
/*
 * Этот абстрактный класс связан с таблицей лотов и содержит методы set и get для установки и
 * получения значений по текущей ставке конкретного лота. Вся работа с СУБД производится в классе
 * наследнике App\Model\ModelBet . Фильтрация входных данных осуществляется в методаъ set.
 * $id - номер лота
 * */

namespace App\Entity;


abstract class Bet
{
    private $id;
    private $last_id;
    private $title;
    private $price;
    private $step;

    function setId(int $id)
    {
        if(is_int($id))
        {
            $this->id = $id;
        }
            else return false;
    }

    function getId(): int
    {
        return $this->id;
    }

    function setLastId(int $last_id)
    {
        if(is_int($last_id))
        {
            $this->last_id = $last_id;
        }
            else return false;

    }

    function getLastId(): int
    {
        return $this->last_id;
    }

    function getTitle(): string
    {
        return $this->title;
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
            $this->step= $step;
        }
            else return false;
    }

    function getStep(): int
    {
        return $this->step;
    }
}