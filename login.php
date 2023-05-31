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
							<h2><strong>Login</strong></h2>
						</header>
						<div class="row">
							<div class="col-12">
								<section>
									<form name="loginForm" action="#" method="post">
										<div class="row gtr-50">

											<div class="col-12">
												Username:
											</div>
											<div class="col-12">
												<input name="login_username" id="login_username" placeholder="username" maxlength="16" type="text" required/>
											</div>
											<div class="col-12">
												Password:
											</div>
											<div class="col-12">
												<input name="login_password" id="login_password" type="password" maxlength="24" required/>
											</div>
											<div class="col-12 errorTxt" id="loginFail">
											</div>
											<div class="col-12" style="text-align: center;">
												<a href="#" class="form-button-submit button icon solid" id="login_submit">Submit</a>
											</div>
											<div class="col-12" style="text-align: center;">
												<a href="#" id="forget_password">Forget Password</a> | <a href="register.php" id="register">Register</a>
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