<?php
/*
 * Данный контроллер возвращает в массиве данные по лоту для которого надо сделать ставку
 * */

namespace App\Controller\Bet;

use App\Model\ModelBet;
use App\Component\Render;

class SelectLot
{
    function index(int $id)
    {
        $bet = new ModelBet();
        $bet->setId($id);
        $render = new Render();
        $vars =  $bet->select_lot();
        $render->insert(['id'=>$vars['id'], 'title'=>$vars['title']]);
        return $render->render('do_bet');
    }
}