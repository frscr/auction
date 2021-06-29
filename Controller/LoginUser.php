<?php


namespace App\Controller\User;

use App\Model\ModelUser;

class LoginUser extends ModelUser
{
    function index($login, $password)
    {
        $user = new ModelUser();
        $user->setLogin($login);
        $user->setPsw($password);
        $user_data = $user->authen_user();
        $user = null;
        return $user_data;
    }
}