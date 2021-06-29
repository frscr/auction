<div class="list_lots">
    <?php $div_number = 0;?>
    <?php foreach ($list as $item):?>
    <?php $div_number++;?>
    <?php if($div_number % 2 == 0):?>
    <?php echo '<div class="even">'?>
    <?php else:?>
    <?php echo '<div class="not_even">';?>
    <?php endif;?>
    <?php echo '<a href="?lot_id='.$item['id'].'">Сделать ставку</a> '.$item['title'].' Ставка:'.$item['price'].' Шаг:'.$item['step'].'<br></div>'; ?>
    <?php endforeach;?>
</div>