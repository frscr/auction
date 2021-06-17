<?php
/*
 * $_SESSION['user'] содержит данные для авторизации пользователей
 * */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
require ("config.php");
require ("Entity/Lot.php");
require ("Entity/Bet.php");
require ("Entity/User.php");
require ("Model/ModelLot.php");
require ("Model/ModelBet.php");
require ("Model/ModelUser.php");
require ("Controller/AddLot.php");
require ("Controller/ShowLots.php");
require ("Controller/ShowMyLots.php");
require ("Controller/SelectLot.php");
require ("Controller/DoBet.php");
require ("Controller/RegistrationUser.php");
require ("Controller/LoginUser.php");

use App\Controller\Lot\AddLot;
use App\Controller\Lot\ShowLots;
use App\Controller\Lot\ShowMyLots;
use App\Controller\Bet\SelectLot;
use App\Controller\Bet\DoBet;
use App\Controller\User\RegistrationUser;
use App\Controller\User\LoginUser;

if(isset($_POST['create_lot']) && isset($_SESSION['user']))
{
    $add_lot = new AddLot();
    $add_lot->index($_POST['title'], 1, $_POST['price'], $_POST['step'], $_POST['deadline_date'], $_POST['deadline_time']);
    $add_lot = null;
}

require_once ("Template/head.html");
require_once ("Template/menu.html");

if(isset($_POST['btn_login']))
{
    $login = new LoginUser();
    $_SESSION['user'] = $login->index($_POST['login'], $_POST['password']);
    $login = null;
}
//Если пользователь не залогинен, то подключаем нужные файлы для аутентификации или регистрации
if(!isset($_SESSION['user']))
{
    if(!isset($_GET['reg'])) {
        require_once("Template/login.html");
    }
    else{
        if($_GET['reg'] == 1)
        {
            require_once ("Template/reg.html");
        }
    }

    if(isset($_POST['btn_reg']))
    {
        $registration = new RegistrationUser();
        $registration->index($_POST['login'], $_POST['psw'], 'reg_user', $_POST['email']);
        $registration = null;
    }

}

if(isset($_SESSION['user']))
{
    if(isset($_GET['logout']) && $_GET['logout'] == 1)
    {
        unset($_SESSION['user']);
    }
    require ("Template/user_panel.html");
}

if(isset($_GET['menu']) )
{
    if(isset($_SESSION['user'])) {
        if ($_GET['menu'] == 1) {
            require_once("Template/add_lot.html");
        }
    }
    if($_GET['menu'] == 2) {
        $show_lots = new ShowLots();
        $list_lots = $show_lots->index();
        foreach ($list_lots as $value) {
            echo $value;
        }
        $list_lots = null;
        $show_lots = null;
    }

    if(isset($_SESSION['user'])) {
        if ($_GET['menu'] == 3) {
            $show_my_lots = new ShowMyLots();
            $list_my_lots = $show_my_lots->index($_SESSION['user']['id']);
            foreach ($list_my_lots as $value) {
                echo $value;
            }
            $list_my_lots = null;
            $show_my_lots = null;
        }
    }
}

if(isset($_SESSION['user'])) {
    if (isset($_GET['lot_id']) && is_numeric($_GET['lot_id'])) {
        $bet = new SelectLot();
        $select_lot = $bet->index($_GET['lot_id']);//Получаем массив выбранного лота
        $bet = null;
        echo $select_lot['title'].' Шаг ставки '.$select_lot['step'];
        require("Template/do_bet.html");
    }

    if (isset($_POST['do_bet']) && isset($select_lot))//Делаем ставку на выбранный лот
    {
        $bet = new DoBet();
        $bet->index($select_lot['id'], $_POST['step']);
        $bet = null;
    }
}

//////////
require_once ("Template/footer.html");
?>