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
							<h2><strong class="mainTitle"></strong></h2>
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
<?php
$pid = 0;
if (isset($_GET['pid'])){
    $pid = $_GET['pid'];
}
if (!is_numeric($pid)){
    $pid = 0;
}
$birdid = 0;
if (isset($_GET['birdid'])){
    $birdid = $_GET['birdid'];
}
if (!is_numeric($birdid)){
    $birdid = 0;
}
$locationcode = 0;
if (isset($_GET['locationcode'])){
    $locationcode = $_GET['locationcode'];
}
if (!is_numeric($locationcode)){
    $locationcode = 0;
}
?>
$(document).ready(function() {
	loadJson("https://birdsurveybygroup4.000webhostapp.com/php/loadphoto.php?pid=<?php echo($pid); ?>&birdid=<?php echo($birdid); ?>&locationcode=<?php echo($locationcode); ?>");
});

</script>
	</body>
</html>