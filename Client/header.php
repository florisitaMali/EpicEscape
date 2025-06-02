  <?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="site-mobile-menu site-navbar-target">
		<div class="site-mobile-menu-header">
			<div class="site-mobile-menu-close">
				<span class="icofont-close js-menu-toggle"></span>
			</div>
		</div>
		<div class="site-mobile-menu-body"></div>
	</div>

	<nav class="site-nav">
		<div class="container">
			<div class="site-navigation">
				<a href="index.php" class="logo m-0">EpicEscape <span class="text-primary">.</span></a>

				<ul class="js-clone-nav d-none d-lg-inline-block text-left site-menu float-right">
    <li class="active"><a href="index.php">Home</a></li>
    <li class="has-children">
        
             <li><a href="services.php">Services</a></l>
              <li><a href="about.php">About</a></li>
              <li><a href="contact.php">Contact Us</a></li>
          
              <?php if (isset($_SESSION['ID'])): ?>
                  <li class="has-children">
                  <a href="#">👤 <?php echo htmlspecialchars($_SESSION['Username']); ?></a>
                  <ul class="dropdown">
                  <li><a href="profile.php">Profile</a></li>
                 <li><a href="logout.php">Log Out</a></li>
                </ul>
               </li>
              <?php else: ?>
                <li class="has-children">
                  <a href="#">Account</a>
                 <ul class="dropdown">
                  <li><a href="../html/index.php">Log In</a></li>
                   <li><a href="../html/signUp.php">Sign Up</a></li>
                   </ul>
                  </li>
                  <?php endif; ?>

                 </ul>


				<a href="#" class="burger ml-auto float-right site-menu-toggle js-menu-toggle d-inline-block d-lg-none light" data-toggle="collapse" data-target="#main-navbar">
					<span></span>
				</a>

			</div>
		</div>
	</nav>