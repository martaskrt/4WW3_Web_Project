<header> 	<!-- header for page when screen size is 1024 px-->
			<img id="theLibLogo" src="/assets/theLibSmallLogo.svg" alt="theLibLogo"> 	<!-- logo image -->
			<ul class="menu-left"> 	<!-- unordered list for left half of header; navigates to search or review pages -->
				<li><a href="/">Search</a></li>
				<li><a href="/submission/">Write a Review</a></li>
			</ul>
			<ul class="menu-right" style="display:flex"> <!-- unordered list for right half of header; navigates to log in or sign up pages -->
				<li><div class="button1"><a href="/login/">Log In</a></div></li>
				<li><div class="button1"><a href="/registration/">Sign Up</a></div></li>
				<?php
				if (!empty($_SESSION['user'])){
					echo '<p>Logged in as: '. $_SESSION['user'] .'<p>';
				}
				?>
			</ul>
			<div class="dropdown"> <!-- header for page when screen size < 1024 px-->
				<button class="button1">Menu &#x25BC;</button> <!-- Menu button that drops down to list of all pages-->
				<div class="dropdown_content">
					<div class="item"><a href="/">Search</a></div>
					<div class="item"><a href="/submission/">Write a Review</a></div>
					<div class="item"><a href="/login/">Log In</a></div>
					<div class="item"><a href="/registration/">Sign Up</a></div>
				</div>
			</div> 
</header>
