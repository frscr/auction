<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;
use App\Component\Render;

class ShowLots
{
    function index()
    {

        $lots = new ModelLot();
        $list = $lots->show_lots();
        return $list;

    }
}