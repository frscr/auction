<?php
class RegUser{
	protected $name;
	protected $login;
	protected $psw;
	protected $repsw;
	protected $email;
	protected $remail;
	protected $host;
	protected $dbname;
	protected $user;
	protected $password;

	function __construct($link){
		$this->host = $link['host'];
		$this->dbname = $link['db_name'];
		$this->user = $link['user'];
		$this->password = $link['password'];
	}

	function check_data($name=0, $login=0, $psw=0, $repsw=0, $email=0, $remail=0){
		$err = array('','','','');
		$check = 0;
		$pattern = '/^(\W)+$/i';
		$pattern_em = '/^(\W|@)+$/i';
	
			if(preg_match($pattern, $name)) {
				$err[0] = 'Не корректное имя';
				$check = 1;
			}
				else $this->name = $name;

			if(preg_match($pattern, $login)){
				$err[1] = 'Не корректный логин';
				$check = 1;
			}
				else $this->login = $login;

			if(preg_match($pattern, $psw)){
				$err[2] = 'Недопустимый символ';
				$check = 1;
			}
				else {
					if($psw == $repsw)
						$this->psw = $psw;	
					
					else {
						$err[2] = 'Пароли не совпадают';
						$check = 1;
					}
				} 

			
			if($check === 1)return $err;
				else {
					$this->registration();
				}
			
	}

	private function registration(){
		$connect = mysqli_connect($this->host, $this->user, $this->password, $this->dbname)
			or die("Ошибка". mysqli_error($connect));

			$this->psw = password_hash($this->psw, PASSWORD_DEFAULT);
			if(mysqli_query($connect, "INSERT INTO tbl_users(`name`, `login`, `passw`, `email`) VALUES('$this->name',
				'$this->login', '$this->psw', '$this->email')") === TRUE){printf("Запись добалена-->".$this->psw."<--");}

			mysqli_close($connect);
	}
}

?>