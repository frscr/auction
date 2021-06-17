<?php
/*
 * Данный контроллер возвращает в массиве данные по лоту для которого надо сделать ставку
 * */

namespace App\Controller\Bet;

use App\Model\ModelBet;

class SelectLot
{
    function index(int $id)
    {
        $bet = new ModelBet();
        $bet->setId($id);
        return $bet->select_lot();
    }
}