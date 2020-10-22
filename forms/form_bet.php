<form method="POST">
	Наименование лота: <?=$lot['name']?><br />
	Стартовая цена: <?=$lot['start_price']?><br />
	Выкуп: <?=$lot['buyout']?><br />
	Текущая цена: <?=$lot['real_price']?><br />
	Шаг: <?=$lot['step']?><br />
	Ваша ставка <input type = "text" name="step" /><br />
	<input type="submit" name="btn_bet" value="Сделать ставку" /><br />
	<input type="submit" name="buyout" value="Выкупить" />
	<input type="hidden" name="bet_id" value="<?=$lot['id_bet']?>">
</form>