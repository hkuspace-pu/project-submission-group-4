<?php
// Start the session
session_start();

if (isset($_SESSION['username'])) {
	echo '<script>window.location.href = "index.php";</script>';
}
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>Bird Survey - By Group 4</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="no-sidebar is-preload">

		<div id="page-wrapper">

			<!-- Header -->
				<section id="header">
					<div class="container">
						<!-- Logo -->
						<span class="image featured"><img src="images/banner01.png" alt="" /></span>
						<!-- Nav -->
						<?php include "menu.php"; ?>

					</div>
				</section>

				<section id="main">
					<div class="container">
						<header>
							<h2><strong>Register</strong></h2>
						</header>
						<div class="row">
							<div class="col-12">
								<section>
									<form name="loginForm" action="#" method="post">
										<div class="row gtr-50">

											<div class="col-12">
											FirstName:
											</div>
											<div class="col-12">
												<input name="register_firstname" id="register_firstname" placeholder="Firstname" type="text" maxlength="100" autocomplete="off" required/>
											</div>

											<div class="col-12">
											LastName:
											</div>
											<div class="col-12">
												<input name="register_lastname" id="register_lastname" placeholder="Lastname" type="text" maxlength="100" autocomplete="off" required/>
											</div>

											<div class="col-12">
											Email:
											</div>
											<div class="col-12">
												<input name="register_email" id="register_email" placeholder="Email" type="text" maxlength="100" autocomplete="off" required/>
											</div>

											<div class="col-12">
											Confirm Email:
											</div>
											<div class="col-12">
												<input name="register_confirm_email" id="register_confirm_email" placeholder="Confirm Email" type="text" maxlength="100" autocomplete="off" required/>
											</div>

											<div class="col-12">
											Username:
											</div>
											<div class="col-12">
												<input name="register_username" id="register_username" placeholder="Username" type="text" maxlength="16" autocomplete="off" required/>
											</div>

											<div class="col-12">
												Password:
											</div>
											<div class="col-12">
												<input name="register_password" id="register_password" type="password" maxlength="24" autocomplete="off" required/>
											</div>

											<div class="col-12">
												Confirm Password:
											</div>
											<div class="col-12">
												<input name="register_confirm_password" id="register_confirm_password" type="password" maxlength="24" autocomplete="off" required/>
											</div>
											<div class="col-12 errorTxt" id="registerFail">
											</div>
											<div class="col-12" style="text-align: center;">
												<a href="#" class="form-button-submit button icon solid" id="register_submit">Submit</a>
											</div>
											<div class="col-12" style="text-align: center;">
												<a href="login.php" id="login">Login</a>
											</div>
										</div>
									</form>
								</section>
							</div>
							
						</div>
					</div>
				</section>

				<?php include "footer.php"; ?>
	</body>
</html>