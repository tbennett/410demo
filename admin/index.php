<?php
	require_once('../includes/config.php');
	require_once('PasswordHash.php');
	
	if($_POST['submitted'])
	{
		//format user input
		$user = trim($_POST['user']);
		$pass = trim($_POST['pass']);
		
		if(empty($user) || empty($pass))
		{
			echo 'please fill in the username and password fields';
		}
		else
		{
			$hasher = new PasswordHash(8, false);
			$stored_hash = '*';
			
			$sql = "SELECT * FROM admins WHERE username='$user'";
			$myData = $db->query($sql)
			OR exit('DB query failed');
			
			$row = $myData->fetch_assoc();
			$db->close();
			
			
			$stored_hash = $row['password'];
			$check = $hasher->CheckPassword($pass, $stored_hash);
			if ($check && $row['username'] == $user) 
			{
				session_start();
				$_SESSION['login'] = 'y';
				header('Location: update.php');
			} 
			else 
			{
				echo 'Sorry, login info incorrect';	
			}
		}
	}

?>



<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Login Form</title>
</head>

<body>
<h1>Login</h1>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<fieldset>
    	<legend>Please login</legend>
        <ul>
        	<li>
            	<label for="user">Username: </label>
                <input name="user" type="text" placeholder="username or email" />
            </li>
            <li>
            	<label for="pass">Password: </label>
                <input name="pass" type="password" placeholder="password" />
            </li>
            <li>
                <input name="submitted" type="submit" value="login now" />
            </li>
        </ul>
    </fieldset>
</form>
</body>
</html>