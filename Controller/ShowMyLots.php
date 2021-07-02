<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;
use App\Component\Render;

class ShowMyLots extends Render
{
    function index(int $user_id)
    {
        $lots = new ModelLot();
        $lots->setUserId($user_id);
        $list = $lots->show_my_lots();
        $this->insert(['list'=>$list]);
        $result = $this->render('list_my_lots');
        return $result;
    }
}