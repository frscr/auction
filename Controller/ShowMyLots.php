<?php

namespace App\Controller\Lot;

use App\Model\ModelLot;

class ShowMyLots
{
    function index(int $user_id)
    {
        $div_number = 0;
        $div_style = '';
        $lots = new ModelLot();
        $lots->setUserId($user_id);
        $list = $lots->show_my_lots();
        yield '<div class="list_lots">';
        foreach ($list as $row)
        {
            $div_number++;
            if($div_number % 2 == 0){
                $div_style = '<div class="even">';
            }
            else{
                $div_style = '<div class="not_even">';
            }
            yield $div_style.$row['title'].'</div>';
        }
        yield '</div>';
    }
}