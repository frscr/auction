<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;

class AddLot
{
    function index($title, $user_id, $price, $step, $date, $time)
    {
        $lot = new ModelLot();
        $lot->setTitle($title);
        $lot->setUserId($user_id);
        $lot->setPrice($price);
        $lot->setStep($step);
        $lot->setDeadline($date.' '.$time);
        return $lot->create_lot();
    }
}