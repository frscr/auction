<?php


namespace App\Controller\User;

use App\Model\ModelUser;
use App\Component\RandomString;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class RecoveryPassword
{
    function sendKeyForPass(string $email)
    {
        $user = new ModelUser();
        $user->setEmail($email);
        $string = new RandomString();
        $user->setTokenRepass($string->random_string()) ;
        $user->setKeyPass();

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;

        $mail->Host = 'ssl://smtp.yandex.ru';
        $mail->Port = 465;
        $mail->Username = 'frscr@yandex.ru';
        $mail->Password = '_!Gjxnf934855@_';
        $mail->setFrom('frscr@yandex.ru','auction');
        $mail->addAddress($user->getEmail(),'Auct');
        $body = "<a href=http://127.0.0.1/auction?newpass={$user->getTokenRepass()}> Сбросить пароль</a>";
        $mail->msgHTML($body);

        $mail->send();
        return $user->getEmail();

    }

    function rePassword(string $email, string $psw, string $key)
    {
        $user = new ModelUser();
        $user->setEmail($email);
        $user->setPsw($psw);
        $user->setTokenRepass($key);
        $count = $user->checkKeyPass();
        if($count == 1) {
            $user->newPassword();
        }
    }
}