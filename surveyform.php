<?php
// Start the session
session_start();

if (!isset($_SESSION['username'])) {
	echo '<script>window.location.href = "login.php";</script>';
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
						<span class="image featured"><img src="images/banner01.png" alt="" /></span>

						<!-- Nav -->
						<?php include "menu.php"; ?>

					</div>
				</section>

				<section id="login">
					<div class="container">
						<header>
							<h2><strong>Survey Form</strong></h2>
						</header>
						<div>
							<form name="surveyForm" enctype="multipart/form-data" action="#" method="post">
								<div class="col-12">
									<section>
										<table>
											<tr>
												<td>Date</td>
												<td><input type="date" name="survey_date" id="survey_date"></td>
											</tr>
											<tr>
												<td>Location</td>
												<td><select id="survey_location" name="survey_location">
													<option value="0" selected>---</option>
												</select></td>
											</tr>
											<tr>
												<td>Species</td>
												<td><select id="survey_bird" name="survey_bird">
													<option value="0" selected>---</option>
												</select></td>
											</tr>
											<tr>
												<td>Quantity</td>
												<td><select id="survey_numberOfBirds" name="survey_numberOfBirds">
													<option value="0" selected>---</option>
												</select></td>
											</tr>
											<tr>
												<td>Title</td>
												<td><input type="text" name="survey_title" id="survey_title"></td>
											</tr>
											<tr>
												<td>Description</td>
												<td><input type="text" name="survey_description" id="survey_description"></td>
											</tr>
											<tr>
												<td>Photo</td>
												<td>
													<div id="survey-upload-container">
														<div class="survey-upload-row" style="padding:3px;">
															<input type="file" name="photo[]" class="survey-upload-input">
														</div>
													</div>			
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td><button id="survey-add-photo-button">Add Photo</button></td>
											</tr>
											<tr>
												<td colspan=2><div class="col-12 errorTxt" id="surveyFail"></div></td>
											</tr>
											<tr>
												<td colspan=2 align="center"><a href="#" class="form-button-submit button icon solid" id="survey_submit">Submit</a></td>
											</tr>
										</table>
									</section>
								</div>
							</form>
						</div>
					</div>
				</section>


				<?php include "footer.php"; ?>
<script>
var infoJsonData = <?php include "php/select_info.php"; ?>;

$(document).ready(function() {
	generateSurveyFormInfo();
});
</script>
	</body>
</html>