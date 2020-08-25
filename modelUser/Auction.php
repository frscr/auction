<?php
class Auction{
	protected $host;
	protected $dbname;
	protected $user;
	protected $password;
	protected $user_id;

	function __construct($link, $user_id){
		$this->host = $link['host'];
		$this->dbname = $link['db_name'];
		$this->user = $link['user'];
		$this->password = $link['password'];
		$this->user_id = $user_id;
	}

	function create_lot($descr, $title, $start_price, $step, $max_price){
		$descr = htmlspecialchars($descr);
		$title = htmlspecialchars($title);
		if(!preg_match("/^\d+$/", $start_price)){
			echo "Введите корректную стартовую цену.";
			exit;
		}
		if(!preg_match("/^\d+$/", $step)){
			echo "Введите корректный шаг.";
			exit;
		}	
		if(!preg_match("/^\d+$/", $max_price)){
			echo "Введите корректную сумму выкупа.";
			exit;
		}
		if($start_price >= $max_price || ($start_price+$step) >= $max_price){
			echo "Стартовая цена не может быть больше или ровняться выкупу.<br />";
			echo "Стартовая цена и шаг не должны быть больше или ровняться выкупу.";
			exit;
		}
		$connect = mysqli_connect($this->host, $this->user, $this->password, $this->dbname)
			or die("Ошибка".mysqli_error($connect));
		$sql_bet = "INSERT INTO tbl_bets(`start_price`, `step`, `max_price`) 
					VALUES('$start_price', '$step', '$max_price')";
		
		if(mysqli_query($connect, $sql_bet) === TRUE){
			printf("Ставка сделана");
		}
		$last_id = mysqli_insert_id($connect);
		//При создании лота сначала создается ставка, а после добавляется лот
		//и в поле id_bet таблицы присваивается значение созданной ставки
		$sql_lot = "INSERT INTO tbl_lots(`id_user`, `description`,`title`, `id_bet`)
					VALUES('$this->user_id', '$descr', '$title', '$last_id')";
		if(mysqli_query($connect, $sql_lot) === TRUE){
			printf("Лот добавлен");
		}
		mysqli_close($connect);
	}

	function delete_lot($lot_id){
		if(!preg_match("/^\d+$/", $lot_id)){
			echo "Error";
			exit;
		}
		$sql = "DELETE tbl_lots, tbl_bets FROM tbl_lots INNER JOIN tbl_bets WHERE tbl_lots.id_bet = tbl_bets.id 
		AND tbl_lots.id = '$lot_id' AND tbl_lots.id_user = '$this->user_id'";
		$connect = mysqli_connect($this->host, $this->user, $this->password, $this->dbname) 
			or die("Ошибка".mysqli_error($connect));
		if(mysqli_query($connect, $sql) === TRUE){
			printf("Запись удалена");
		}
		mysqli_close($connect);

	}

	//Функция выбора лота. Создает массив для заполнения полей ставки.
	function select_lot($lot_id){
		if(!preg_match("/^\d+$/", $lot_id))
		{
			echo "Error";
			exit;
		}
		$sql = "SELECT tbl_lots.title AS name, tbl_bets.start_price AS start FROM tbl_lots INNER JOIN tbl_bets ON tbl_lots.id_bet = tbl_bets.id WHERE tbl_lots.id = '$lot_id'";
		$connect = mysqli_connect($this->host, $this->user, $this->password, $this->dbname) 
			or die("Error". mysqli_error($connect));
		if($result = mysqli_query($connect, $sql)){
			while ($data = mysqli_fetch_assoc($result)) {
				return $data;				
			}
		}
	}

	function other_lots(){
		$list_lots = "";
		$sql = "SELECT tbl_lots.description AS lot_descr, tbl_lots.id AS lot_id, tbl_lots.title AS lot_titl, tbl_bets.start_price AS bet_start,
		tbl_bets.step AS bet_step, tbl_bets.real_price AS bet_price FROM tbl_lots
		INNER JOIN tbl_bets ON tbl_bets.id = tbl_lots.id_bet  WHERE id_user != '$this->user_id'";
		$connect = mysqli_connect($this->host, $this->user, $this->password, $this->dbname)
			or die("Ошибка".mysqli_error($connect));
		if($result = mysqli_query($connect, $sql)){
			while ($data = mysqli_fetch_assoc($result)) {
				$list_lots = '<form method="POST">'.$data['lot_titl'].'<input type="submit" name="do_bet"
				 value="Сделать ставку"><input type="hidden" name="lot_id" value="'.$data['lot_id'].'"></form>';
				yield $list_lots;
			}
		}
		mysqli_close($connect);
	}

	function my_lots(){
		$list_lots = "";
		$sql = "SELECT tbl_lots.description AS descr, tbl_lots.title AS title, tbl_lots.id AS lot_id, tbl_bets.max_price AS max FROM tbl_lots
				INNER JOIN tbl_bets ON tbl_lots.id_bet = tbl_bets.id WHERE id_user = '$this->user_id'";
		$connect = mysqli_connect($this->host, $this->user, $this->password, $this->dbname)
			or die("Ошибка".mysqli_error($connect));
		if($result = mysqli_query($connect, $sql)){
			while ($data = mysqli_fetch_assoc($result)) {
				 $list_lots = '<form method="POST">'.$data['descr'].'  '.$data['title'].' 
				 '.$data['max'].'<input type="hidden" name="num_lot" value="'.$data['lot_id'].'">
				 <input type="submit" name="del_lot" value="Удалить">'.'</form>';
				 yield $list_lots;
			}
		}
		mysqli_close($connect);
	}
}
?>