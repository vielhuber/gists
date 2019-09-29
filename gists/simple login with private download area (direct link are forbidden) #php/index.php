<?php
define('PWD','foobar');
if( isset($_POST['password']) && $_POST['password'] != '' )
{
	if( $_POST['password'] == PWD )
	{
		setcookie('login_auth', md5($_POST['password']), time()+60*60*24*30, '/');
	}
	else
	{
		setcookie('login_error', $_POST['password'], time()+60*60*24*30, '/');
	}
	header('Location: '.$_SERVER['REQUEST_URI']); die();
}
if( isset($_POST['logout']) && $_POST['logout'] != '' )
{
	setcookie('login_auth', '', time()-3600, '/');
	header('Location: '.$_SERVER['REQUEST_URI']); die();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Download-Bereich</title>
</head>
<body>

	<div id="content">

		<?php
		if( !isset($_COOKIE['login_auth']) || $_COOKIE['login_auth'] != md5(PWD) )
		{
			echo '<div class="login">';
				echo '<form method="post">';
					if( isset($_COOKIE['login_error']) && $_COOKIE['login_error'] != '' )
					{
						echo '<div class="error">Falsches Passwort!</div>';
						setcookie('login_error', '', time()-3600, '/');
					}
					echo '<input type="password" name="password" value="'.(isset($_COOKIE['login_error'])?($_COOKIE['login_error']):('')).'" required="required" placeholder="Passwort" />';
					echo '<input type="submit" name="login" value="Anmelden" />';
				echo '</form>';
			echo '</div>';
		}
		else if( isset($_GET['download']) && $_GET['download'] != '' )
		{
			$_GET['download'] = strip_tags($_GET['download']);
			if(!file_exists(realpath(dirname(__FILE__)).'/files/'.$_GET['download'])) { die(); }
			if(strpos($_GET['download'],'..') !== false) { die(); }
			if(strpos($_GET['download'],'/') !== false) { die(); }
			header( 'Cache-Control: public' );
			header( 'Content-Description: File Transfer' );
			header( 'Content-Disposition: attachment; filename='.$_GET['download'] );
			header( 'Content-Type: application/pdf' );
			header( 'Content-Transfer-Encoding: binary' );
			readfile( realpath(dirname(__FILE__)).'/files/'.$_GET['download'] );
			die();
		}
		else
		{
		?>
			<h2>Download-Bereich</h2>
			<a href="index.php?download=foo.pdf">foo.pdf</a>
			<form method="post"><input type="submit" name="logout" value="Abmelden" /></form>
		<?php
		}
		?>

	</div>

</body>
</html>