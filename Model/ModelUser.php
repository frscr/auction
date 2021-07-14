<?php
namespace App\Model;


use App\Entity\User;

class ModelUser extends User
{

    function connect()
    {
        $constant = 'constant';
        $charset = 'utf8';
        $dsn = "mysql:host={$constant('HOST')};dbname={$constant('DBNAME')};charset=$charset";
        try {
            $pdo = new \PDO($dsn, USER, PASSU);
        }
        catch (\PDOException $e) {
            die("Подключение не удалось" . $e->getMessage());
        }
        return $pdo;
    }
    function add_user()
    {
        $pdo = $this->connect();
        $password = password_hash($this->getPsw(), PASSWORD_DEFAULT);
        $sql = $pdo->prepare("INSERT INTO users(login, role, passw, email) VALUES(:login, :role, :passw, :email)");
        $sql->bindValue(':login', $this->getLogin());
        $sql->bindValue(':role', $this->getRole());
        $sql->bindValue(':passw', $password);
        $sql->bindValue(':email', $this->getEmail());
        $result = $sql->execute();
        if(!$result) {
            die("Error332");
        }
        $sql = null;
        $pdo = null;
    }
    ///Аутентификация пользователя
    function authen_user()
    {
        $hash_list = ['id'=>0, 'login'=>'', 'password'=>'', 'role'=>''];
        $pdo = $this->connect();
        $sql = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $sql->bindValue(':login', $this->getLogin());
        $sql->execute();
        foreach ($sql as $row) {
            $hash_list['id'] = $row['id'];
            $hash_list['login'] = $row['login'];
            $hash_list['password'] = $row['passw'];
            $hash_list['role'] = $row['role'];
        }
        if(password_verify($this->getPsw(), $hash_list['password'])) {
            $hash_list['password'] = '';
            return $hash_list;
        }
        else die("Неправильная пара логин/пароль.");
    }

    function setKeyPass()
    {
        $pdo = $this->connect();
        $sql = $pdo->prepare("UPDATE users SET token_repass = :token_repass WHERE email = :email");
        $sql->execute(['token_repass'=>$this->getTokenRepass(), 'email'=>$this->getEmail()]);
        $pdo = null;
    }

    function checkKeyPass()
    {
        $pdo = $this->connect();
        $sql = $pdo->prepare("SELECT * FROM users WHERE email = :email AND token_repass = :token_repass");
        $sql->execute(['email'=>$this->getEmail(), 'token_repass'=>$this->getTokenRepass()]);
        $count = $sql->rowCount();
        if($count == 1) {
            $sql = $pdo->prepare("UPDATE users SET token_repass = null WHERE email = :email");
            $sql->execute(['email'=>$this->getEmail()]);
            $pdo = null;
            return $count;
        }

    }

    function newPassword()
    {
        $pdo = $this->connect();
        $password = password_hash($this->getPsw(), PASSWORD_DEFAULT);
        $sql = $pdo->prepare("UPDATE users SET passw = :passw WHERE email = :email");
        $sql->execute(['passw'=>$password, 'email'=>$this->getEmail()]);
    }

}