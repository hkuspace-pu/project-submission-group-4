<?php
// Start the session
session_start();
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

				<!-- Features -->
				<section id="features" class="features_top_view">
					<div class="container">
						<header>
							<h2><strong>Bird Dictionary</strong></h2>
						</header>
						<div class="row aln-center photo-today">

						</div>
					</div>
				</section>


				<section id="main" class="main_top_view">
					<div class="container post photo">
						
					</div>
				</section>


				<?php include "footer.php"; ?>
				<script>
var infoJsonData = <?php include "php/select_info.php"; ?>;


$(document).ready(function() {
	listsBird();
});

</script>
	</body>
</html>