<?php 
ob_start();
$page = "admin";

require_once('../includes/config.php');
	
	//query the database and store the results
	//in the $myData variable
	$sql = "SELECT * 
	FROM site_content
	WHERE page_name='home'";
	
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
	WHERE page_name='home'
	AND section_name='intro'";
	$myData = $db->query($sql1);
	
	$sql2 = "UPDATE site_content
	SET content='$user_blurb'
	WHERE page_name='home'
	AND section_name='blurb'";
	$myData = $db->query($sql2);
	
	mysqli_close($db);
	header('Location: ../');
}

?>

<body>
	<form action="<?php echo $SERVER_['PHP_SELF'];?>" method="post">
    	<fieldset>
            <legend>Update Site Content</legend>
            
            <select id="page" name="page">
                <option value="6">select a page</option>
                <option value="">option 1</option>
                <option value="">option 2</option>
                <option value="">option 3</option>
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
</body>
</html>