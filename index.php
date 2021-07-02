<?php
/*
 * $_SESSION['user'] содержит данные для авторизации пользователей
 * */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

require ("config.php");
require("Component/Render.php");
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
require ("Controller/DropLot.php");


use App\Controller\Lot\AddLot;
use App\Controller\Lot\ShowLots;
use App\Controller\Lot\ShowMyLots;
use App\Controller\Bet\SelectLot;
use App\Controller\Bet\DoBet;
use App\Controller\User\RegistrationUser;
use App\Controller\User\LoginUser;
use App\Controller\DropLot;
use App\Component\Render;

$render = new Render();
$form_action = '';
$user_panel = '';

if(isset($_POST['create_lot']) && isset($_SESSION['user']))
{
    $add_lot = new AddLot();
    $add_lot->index($_POST['title'], $_SESSION['user']['id'], $_POST['price'], $_POST['step'], $_POST['deadline_date'], $_POST['deadline_time']);
    $add_lot = null;
}

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
         $form_action = $render->render('login');
    }
    else{
        if($_GET['reg'] == 1)
        {
            $form_action = $render->render('registration');
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
    $render->insert(['login'=>$_SESSION['user']['login']]);
    $user_panel = $render->render('user_panel');
    if(isset($_GET['logout']) && $_GET['logout'] == 1)
    {
        unset($_SESSION['user']);
    }
}
//Вывод формы для добавления лота
if(isset($_GET['menu']) )
{
    if(isset($_SESSION['user'])) {
        if ($_GET['menu'] == 1) {
            $form_action = $render->render('form_add_lot');
        }
    }
    if($_GET['menu'] == 2) {
        $show_lots = new ShowLots();
        $form_action = $show_lots->index();
        $show_lots = null;
    }

    if(isset($_SESSION['user'])) {
        if ($_GET['menu'] == 3) {
            $show_my_lots = new ShowMyLots();
            $form_action = $show_my_lots->index($_SESSION['user']['id']);
            $show_my_lots = null;
        }
    }
}
/*Вывод окна для ставки*/
if(isset($_SESSION['user'])) {
    if (isset($_GET['lot_id']) && is_numeric($_GET['lot_id'])) {
        $bet = new SelectLot();
        $form_action = $bet->index($_GET['lot_id']);//Получаем массив выбранного лота
        $bet = null;

    }

    if (isset($_POST['do_bet']) && isset($_POST['lot_id']))//Делаем ставку на выбранный лот
    {
        $bet = new DoBet();
        $bet->index($_POST['lot_id'], $_POST['step'], $_SESSION['user']['id']);
        $bet = null;
    }
}

if(isset($_SESSION['user']) && isset($_GET['drop']))
{
    $drop_lot = new DropLot();
    $drop_lot->index($_GET['drop'], $_SESSION['user']['id']);
    $drop_lot = null;
}

$menu = $render->render('menu');
$render->insert(['menu'=>$menu, 'form_action'=>$form_action, 'user_panel'=>$user_panel,]);
echo $render->render('base');
?>