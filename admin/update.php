<?php 
session_start();
ob_start();


//checks if logging out and kills off our session.
if(@$_REQUEST['log_out'])
{
	//delete session cookie
	session_destroy(); 
	
	//force a reload so cookie is found absent
	$loc =  $_SERVER['PHP_SELF'];
	header("Location: $loc");
}


if($_SESSION['login'] == 'y')
{
	require_once('../includes/config.php');
	
		//catch user selection from dropdown and sanitize
		$tmp = $_GET['p'];
		if($tmp === 'home' || $tmp === 'about' || $tmp === 'contact')
		{
			$page = $tmp;
		}
		else
		{
			$page = 'home';
		}

		//query the database and store the results
		//in the $myData variable
		$sql = "SELECT * 
		FROM site_content
		WHERE page_name='$page'";

		$myData = $db->query($sql);

		while($row = $myData->fetch_assoc())
		{
			if($row['section_name'] === 'intro')
			{
				$intro = $row['content'];
			}

			if($row['section_name'] === 'blurb')
			{
				$blurb = $row['content'];
			}
		}

	require_once('../includes/admin_top.inc.php'); 

	if($_POST['submitted'])
	{
		//store cleaned POST data into vars
		$user_intro = mysqli_real_escape_string($db, $_POST['intro']);
		$user_blurb = mysqli_real_escape_string($db, $_POST['blurb']);
		$current_page = mysqli_real_escape_string($db, $_POST['page']);

		$sql1 = "UPDATE site_content
		SET content='$user_intro'
		WHERE page_name='$page'
		AND section_name='intro'";
		$myData = $db->query($sql1);

		$sql2 = "UPDATE site_content
		SET content='$user_blurb'
		WHERE page_name='$page'
		AND section_name='blurb'";
		$myData = $db->query($sql2);

		mysqli_close($db);
		header('Location: ../');
	}
	
}
else
{
	header('Location: index.php');
}


?>

<body>
	<a href="<?php $_SERVER['PHP_SELF'] ?>?log_out=1">Logout Now</a>
	<form action="<?php echo $SERVER_['PHP_SELF'];?>" method="post">
    	<fieldset>
            <legend>Update Site Content</legend>
            <input type="hidden" id="tmp" name="tmp" value="<?php echo $page ?>" />
            <select id="page" name="page" onchange="set_page(this)">
                <option value="">select a page</option>
                <option value="home" id="home">home</option>
                <option value="about" id="about">about</option>
                <option value="contact" id="contact">contact</option>
            </select>
            
            <label for="intro">Intro</label>
            <textarea id="intro" name="intro" rows="10" cols="30"><?php echo $intro; ?>
            </textarea>
            
            <label for="blurb">Blurb</label>
            <textarea id="blurb" name="blurb" rows="10" cols="30"><?php echo $blurb; ?>
            </textarea>
            
            <input type="submit" name="submitted" />
        </fieldset>
    </form>
    
    <script>
    	window.onload =  function(){
			document.getElementById(<?php echo $page; ?>).selected = 'selected';	
		}
		
		function set_page(obj)
		{
			window.location = './update.php?p=' + obj.value;		
		}
    </script>
</body>
</html>

















