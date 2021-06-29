<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;

class ShowMyLots
{
    function index(int $user_id)
    {
        $lots = new ModelLot();
        $lots->setUserId($user_id);
        $list = $lots->show_my_lots();
        return $list;
    }
}