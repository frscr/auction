<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;

class DropLot
{
    function index(int $id, int $user_id)
    {
        $lot = new ModelLot();
        $lot->setId($id);
        $lot->setUserId($user_id);
        $lot->drop_lot();
        $lot = null;
    }

}