<?php 
    global $stylesheet_dir, $stylesheet_url;

    get_header();

    $firstname = $lastname = $message = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$firstname = test_input($_POST["firstname"]);
		$lastname = test_input($_POST["lastname"]);
		$message = test_input($_POST["message"]);
		$mailSent = mail(get_option('admin_email'), 'Mail from '.$firstname.' '.$lastname, $message);
	}

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>

				<div class="container" style="background-image: url('<?php echoPicture($stylesheet_dir,'images/bg4.png');?>');background-size: 100%;background-repeat: no-repeat;background-color: #040205; min-height: 500px;" role="main">
				
					<div style="width:100%">
						<br><br>
						<p style="font-size: 340%; color:#fff;">
							<strong>Contact Me</strong>
						</p>
					</div>
					<br><br><br><br><br><br><br><br><br><br><br>

					<div style="float:left;overflow: hidden;vertical-align: bottom;">
						<form method="POST" action="">
							<p style="float:left;">
								First name:
							</p>

							<input type="text" name="firstname" style="float:right;">
							<br>
							<p style="float:left;">
								Last name:
							</p>

							<input type="text" name="lastname" style="float:right;">

							<br>
							<textarea type="text" name="message" rows="7" cols="65" >	</textarea>
							<br>
							<button type="submit" style="background-color:#fafafa; color:#000;padding-left:5px;padding-right:5px;">
								Submit
							</button>
						</form>
					</div>
					<br>

					<div class="ctransbox">
						<div class="full">
							<strong style="float:left;">Email</strong><strong style="float:right;">larajade@larajade.co.uk</strong>
							<br>
							<strong style="float:left;">Fax</strong><strong style="float:right;"> +44 (0) 1234 567891</strong>
							<br>
							<strong style="float:left;">Address: </strong><strong style="float:right;"> New Chrichton Cottage, Arradoul, Buckie, AB43 AP
							Scotland UK</strong>
							<?php
							/*
								if ($mailSent) {
									echo "Mail Sent";
								} else if (isset($mailSent)) {
									echo "Mail not sent";
								}
							*/
							?>
						</div>
					</div>
					
				</div>
<?php get_footer();?>