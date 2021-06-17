<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;

class ShowLots
{
    function index()
    {
        $div_number = 0;
        $div_style = '';
        $lots = new ModelLot();
        $list = $lots->show_lots();
        yield '<div class="list_lots">';
        foreach ($list as $value)
        {
            $div_number++;
            if($div_number % 2 == 0){
                $div_style = '<div class="even">';
            }
            else{
                $div_style = '<div class="not_even">';
            }
            yield $div_style.'<a href="?lot_id='.$value['id'].'">Сделать ставку</a> '.$value['title'].' Ставка:'.$value['price'].' Шаг:'.$value['step'].'<br></div>';
        }
        yield '</div>';
        $list = null;
        $lots = null;
    }
}