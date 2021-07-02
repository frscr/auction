<?php


namespace App\Controller\Bet;

use App\Model\ModelBet;

class DoBet
{
    function index(int $id, int $step, int $user_id)
    {
        $do_bet = new ModelBet();
        $do_bet->setId($id);
        $do_bet->setUserId($user_id);
        $do_bet->setStep($step);
        $do_bet->do_bet();
    }
}