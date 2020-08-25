<?php
/* for menu
     #navbar {
        margin: 0;
        padding: 0;
        list-style-type: none;
        width: 100px;
      }
      #navbar li {
        border-left: 10px solid #666;
        border-bottom: 1px solid #666;
      }
      #navbar a {
        background-color: #949494;
        color: #fff;
        padding: 5px;
        text-decoration: none;
        font-weight: bold;
        border-left: 5px solid #33ADFF;
        display: block;
      }
*/
session_start();
spl_autoload_register(function($model){
	require_once("modelUser/$model.php");
});
require_once("conn.php");
if(!isset($_SESSION['auth'])){
	require_once("login.php");
	
}
 else{
 	//echo "Hello,". $_SESSION['auth'].'<br />';

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div>
		<?php
		//меню
		require_once("forms/form_menu.php");
		?>	
	</div>
	<div>
		<?php
		require_once("lots.php");
		?>
	</div>
</body>
</html>
<?php
	
 }
 ?>