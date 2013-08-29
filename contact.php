<?php
	require_once('includes/config.php');
	
	//query the database and store the results
	//in the $myData variable
	$sql = 'SELECT * FROM site_content';
	$myData = $db->query($sql);
	
	while($row = $myData->fetch_assoc())
	{
		if($row['view'] == 'n')
		{
			continue;
		}
		
		if($row['section_name'] == 'intro')
		{
			$intro = $row['content'];
		}
		
		if($row['section_name'] == 'blurb')
		{
			$blurb = $row['content'];
		}
	}

?>




<?php
 // * IMPORTANT * Set your email information here
define('DESTINATION_EMAIL','tbennett@aii.edu');
define('MESSAGE_SUBJECT','form Demo');
define('REPLY_TO', 'tbennett@aii.edu');
define('FROM_ADDRESS', 'tbennett@aii.edu');
define('REDIRECT_URL', 'index.php');

require_once('includes/validation.php');
?>


<?php $page = "contact"; ?>

<?php require_once('includes/top.inc.php'); ?>

<body>
<div class="gridContainer clearfix">
  
  <?php require_once('includes/header.inc.php'); ?>
  
  <section class="main">
  	<h2>Contact</h2>
    <p><?php echo @$intro; ?></p>
	
	<div class="errors">
	<ul>
		<?php 
		echo '<li>' . @$name_error . '</li>'; 
		echo '<li>' . @$email_error . '</li>'; 
		echo '<li>' . @$message_error . '</li>'; 
		?>
	</ul>
	</div>
	
	<form id="myform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<fieldset>
			<legend>Got a Question? Ask away!</legend>
			<ol>
				<li>
					<label for="name">Your Full Name:</label>
					<input type="text" name="name" placeholder="i.e. John Smith" size="28" 
					class="required" value="<?php echo @$name; ?>" />
				</li>
				<li>
					<label for="email">Email Address:</label>
					<input type="email" name="email" placeholder="i.e. jon@me.com" size="28" 
					class="required email" value="<?php echo @$email; ?>" />
				</li>
				<li>
					<label for="message">Comments:</label>
					<textarea name="message" placeholder="share your thoughts" 
					cols="30" rows="8"><?php echo @$message; ?></textarea>
				</li>
				<li><input type="submit" name="submitted" value="Send Now"></li>
			</ol>
		</fieldset>
	</form>
  </section>

  
  <?php include_once('includes/footer.inc.php');?>
  
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.9.0.min.js"><\/script>')</script>

<script src="js/jquery.validate.min.js"></script>
<script>
	$(document).ready(function(){
		var errors = $('.errors');
		$('#myform').validate({
			errorContainer: errors,
			errorLabelContainer: $("ul", errors),
			validClass: "success",
			wrapper: 'li',
			messages: {
				name: "Please enter your full name.",
				email:"Please enter a valid email address.",
			}
		});

	});
</script>
</body>
</html>
