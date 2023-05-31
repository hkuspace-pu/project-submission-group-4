<?php
// Start the session
session_start();

if (!isset($_SESSION['username'])) {
	echo '<script>window.location.href = "index.php";</script>';
}

if (!isset($_SESSION['is_admin'])) {
	echo '<script>window.location.href = "index.php";</script>';
}else{
	if($_SESSION['is_admin'] && $_SESSION['adminID'] != 2){
		echo '<script>window.location.href = "index.php";</script>';
	}
}

global $memberId;
global $newPositionCode;


if(isset($_POST['submit'])) {
    // Update position code in the database
    $memberId = $_POST['memberId'];
    $newPositionCode = $_POST['positionCode'];
}


include("l_server_login.php");

 $sql2 = "UPDATE Member_List SET AdminID='$newPositionCode' WHERE MemberID='$memberId'";
    
    if ($conn->query($sql2) === TRUE) {
        echo "Position code updated successfully";
    } else {
        echo "Error updating position code: " . $conn->error;
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
		<?php


		$sql = "SELECT *
				FROM Member_List, Admin_Position
				WHERE Member_List.AdminID = Admin_Position.AdminID";
		$result = mysqli_query($conn, $sql);
		$total = mysqli_num_rows($result);
		?>

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
							<h2><strong>Approval list</strong></h2>
						</header>
						<div>
							<table border="1">
							<tr bgcolor="lightblue" >

							<td><b>Number</b></td>
							<td><b>Action</b></td>
							<td><b>Member ID</b></td>
							<td><b>User Name</b></td>
							<td><b>First Name</b></td>
							<td><b>Last Name</b></td>
							<td><b>Email</b></td>
							<td><b>Admin Position</b></td>
							</tr>
							<?php
        $Count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            if($row["AdminID"] != "2") { 
                $Count++;
                echo "<tr>";
                echo "<td>" .$Count. "</td>";
                echo "<td>";
                echo "<form method='POST'>";
                echo "<input type='hidden' name='memberId' value='" . $row["MemberID"] . "'>";
                echo "<input type='text' name='positionCode' value='" . $row["PositionCode"] . "'>";
                echo "<input type='submit' name='submit' value='Update'>";
                echo "</form>";
                echo "</td>";
                echo "<td>" . $row["MemberID"] . "</td>";
                echo "<td>" . $row["Username"] . "</td>";
                echo "<td>" . $row["FirstName"] . "</td>";
                echo "<td>" . $row["LastName"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "<td>" . $row["PositionCode"]. "</td>";
                echo "</tr>";
                   }
		}
        ?>								
																					
													</div>
												</div>
											</section>
				<?php include "footer.php"; ?>
<script>
var infoJsonData = <?php include "php/select_info.php"; ?>;

$(document).ready(function() {
	initLogin();
	generateSurveyFormInfo();
});
</script>
	</body>
</html>