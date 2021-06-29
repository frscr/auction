<?php


namespace App\Controller\User;

use App\Model\ModelUser;

class RegistrationUser
{
    function index($login, $psw, $role, $email)
    {
        $add_user = new ModelUser();
        $add_user->setLogin($login);
        $add_user->setPsw($psw);
        $add_user->setRole($role);
        $add_user->setEmail($email);
        $add_user->add_user();
        $add_user = null;
    }
}