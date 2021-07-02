<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;
use App\Component\Render;

class ShowLots extends Render
{
    function index()
    {

        $lots = new ModelLot();
        $list = $lots->show_lots();
        $this->insert(['list'=>$list]);
        $result = $this->render('list_lots');
        return $result;

    }
}