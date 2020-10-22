<?php
use too\Auction as Auction;

$auction = new Auction($list_link, $_SESSION['auth_id']);
if(isset($_POST['create_lot'])) {
	$auction->create_lot($_POST['descr_lot'], $_POST['name_lot'], $_POST['start_price'],
	$_POST['step_money'], $_POST['buyout']);
}
if(isset($_POST['del_lot'])) {
	$auction->delete_lot($_POST['num_lot']);
}
if(isset($_POST['do_bet'])) {
	$lot = $auction->select_lot($_POST['lot_id']);
	require_once("forms/form_bet.php");
}

if(isset($_POST['btn_bet'])) {//////////////
	$auction->bet($_POST['bet_id'], $_POST['step']);

}

if(isset($_GET['menu']) && $_GET['menu'] == 1) {
	foreach ($auction->my_lots() as $val) {
		echo $val;
	}
} 
	elseif (isset($_GET['menu']) && $_GET['menu'] == 2) {
			require_once("forms/form_add_lot.php");
	}
		elseif(isset($_GET['menu']) && $_GET['menu'] == 3 && !isset($_POST['do_bet'])) {
			foreach ($auction->other_lots() as $val) {
				echo $val;
			}
		}
?>