<?php


namespace App\Model;


use App\Entity\User;

class ModelUser extends User
{
    function add_user()
    {
        $password = '';
        $constant = 'constant';
        $charset = 'utf8';
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";
        try
        {
            $pdo = new \PDO($dsn, USER, PASSU);
        }
        catch (\PDOException $e)
        {
            die("Подключение не удалось" . $e->getMessage());
        }
        $password = password_hash($this->getPsw(), PASSWORD_DEFAULT);
        $sql = $pdo->prepare("INSERT INTO users(login, role, passw, email) VALUES(:login, :role, :passw, :email)");
        $sql->bindValue(':login', $this->getLogin());
        $sql->bindValue(':role', $this->getRole());
        $sql->bindValue(':passw', $password);
        $sql->bindValue(':email', $this->getEmail());
        $result = $sql->execute();
        if(!$result)
        {
            die("Error332");
        }
        $sql = null;
        $pdo = null;

    }
    ///Аутентификация пользователя
    function authen_user()
    {
        $hash_list = ['id'=>0, 'login'=>'', 'password'=>'', 'role'=>''];
        $constant = 'constant';
        $charset = 'utf8';
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";
        try
        {
            $pdo = new \PDO($dsn, USER, PASSU);
        }
        catch (\PDOException $e)
        {
            die("Подключение не удалось" . $e->getMessage());
        }

        $sql = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $sql->bindValue(':login', $this->getLogin());
        $sql->execute();

        foreach ($sql as $row)
        {
            $hash_list['id'] = $row['id'];
            $hash_list['login'] = $row['login'];
            $hash_list['password'] = $row['passw'];
            $hash_list['role'] = $row['role'];
        }
        if(password_verify($this->getPsw(), $hash_list['password']))
        {
            $hash_list['password'] = '';
            return $hash_list;
        }
        else die("Неправильная пара логин/пароль.");


    }

}