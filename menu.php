                            <nav id="nav" style="opacity:0;">
								<ul>
									<li><a class="icon solid fa-home" href="index.php"><span>Home</span></a></li>
									<li>
										<a href="#" class="icon solid fa-search"><span>Survey</span></a>
										<ul>
											<li><a class="icon solid fa-kiwi-bird" href="bybird.php">&nbsp;&nbsp;By bird</a></li>
											<!--<li><a class="icon solid fa-users" href="#">&nbsp;&nbsp;By user</a></li>-->
											<li><a class="icon solid fa-map" href="bylocation.php">&nbsp;&nbsp;By map</a></li>
										</ul>
									</li>
									<li>
										<a href="aboutus.php" class="icon solid fa-info"><span>About us</span></a>
										<ul>
											<li><a class="icon solid fa-file" href="tnc.php#">&nbsp;&nbsp;&nbsp;Terms and conditions</a></li>
											<li><a class="icon solid fa-user-shield" href="privacypolicy.php">&nbsp;&nbsp;Privacy Policy Statement</a></li>
											<li><a class="icon solid fa-mail-bulk" href="contactus.php">&nbsp;&nbsp;&nbsp;Contact us</a></li>
										</ul>
									</li>
									<li class="before_login_button"><a class="icon solid fa-sign-in-alt" href="login.php"><span>Login</span></a></li>
									<li class="before_login_button"><a class="icon solid fa-user-plus" href="register.php"><span>Register</span></a></li>
									<li class="after_login_button"><a class="icon solid fa-user" href="#"><span class="after_login_username">{Username}</span></a>
										<ul>
											<li><a class="icon solid fa-id-card" href="#">&nbsp;&nbsp;Profile</a></li>
											<li><a class="icon solid fa-photo-video" href="#">&nbsp;&nbsp;My posts</a></li>
											<li><a class="icon solid fa-sign-out-alt" href="php/login.php?logout">&nbsp;&nbsp;Logout</a></li>
										</ul>
									</li>
									<li class="after_login_button"><a class="icon solid fa-upload" href="surveyform.php"><span>Survey Form</span></a></li>
								</ul>
							</nav>
<script>
var member_username = "";
<?php
if (isset($_SESSION['username'])) {
    echo "member_username = \"" . $_SESSION['username'] . "\";\n";
    if($_SESSION['is_admin']){
        #echo "member_is_admin = true;\n";
        #echo "adminID = ".$_SESSION['adminID'].";\n";
    }
}
?>
</script>