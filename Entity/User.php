<?php


namespace App\Entity;


class User
{
    private $id;
    private $login;
    private $role;
    private $email;
    private $psw;
    private $token_repass;

    function getId(): int
    {
        return $this->id;
    }

    function setLogin(string $login)/////Ошибка
    {
        //В логине должны быть доступны только символы a-zA-Z0-9
        if(!preg_match("/^[a-zA-Z_0-9]+$/i", $login))
        {
            die("Недопустимые символы.");
        }
        $this->login = $login;
    }

    function getLogin(): string
    {
        return $this->login;
    }

    function setRole(string $role)
    {
        $this->role = $role;
    }

    function getRole(): string
    {
        return $this->role;
    }

    function setEmail(string $email)
    {
        $this->email = $email;
    }

    function getEmail(): string
    {
        return $this->email;
    }

    function setPsw(string $psw)
    {
        $this->psw = $psw;
    }

    function getPsw(): string
    {
        return $this->psw;
    }

    function setTokenRepass(string $key)
    {
        $this->token_repass = $key;
    }

    function getTokenRepass(): string
    {
        return $this->token_repass;
    }

}