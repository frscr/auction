<!DOCTYPE html>
<html>
<head>
	<title>Регистрация</title>
</head>
<body>
	<form action = "registration.php" method="POST">
		<input type="text" name="name_user" value="<?php if(isset($st)) echo $st[0]?>" />Введите ваше имя<br />
		<input type="text" name="login_user" value="<?php if(isset($st)) echo $st[1]?>" />Введите ваш логин<br />
		<input type="text" name="email_user" value = "<?php if(isset($st)) echo $st[2]?>" />Введите ваш Email<br />
		<input type="text" name="remail_user" valur = "" />Повторите ваш Email<br />
		<input type="password" name="psw_user" />Пароль<br />
		<input type="password" name="rpsw_user" />Повторите пароль<br />
		<input type="submit" name="send_reg" value="Зарегистрироваться" />
	</form>
</body>
</html>