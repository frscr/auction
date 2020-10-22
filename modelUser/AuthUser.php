<?php
Class AuthUser
{
	protected $login;
	protected $psw;
	protected $role;
	protected $host;
	protected $dbname;
	protected $user;
	protected $password;

	function __construct($link)
	{
		$this->host = $link['host'];
		$this->dbname = $link['db_name'];
		$this->user = $link['user'];
		$this->password = $link['password'];
	}

	function check_data($login, $password)
	{
		if(preg_match('/^(\W)+$/i', $login)) {
			echo "Ошибка";
			exit;
		} else $this->login = $login;
		if(preg_match('/^(\W)+$/i', $password)) {
			echo "Ошибка";
			exit;
		} else $this->psw = $password;
		$this->authentication();
	}

	function authentication()
	{
		$sql = "SELECT id, login, passw FROM tbl_users WHERE login = '$this->login'";
		$connect = mysqli_connect($this->host, $this->user, $this->password, $this->dbname)
			or die("Ошибка". mysql_error($connect));
		if($result = mysqli_query($connect, $sql)) {
			while($row = mysqli_fetch_row($result)) {
				if(password_verify($this->psw, $row[2])) {
					$_SESSION['auth'] = $row[1];
					$_SESSION['auth_id'] = $row[0];
				}
					
			}
			mysqli_free_result($result);
		}
		mysqli_close($connect);

	}
}
?>