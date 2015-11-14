</div><!-- content row -->
<section class="container">
	<footer class="row">
		<nav class="col-lg-12">
			<ul class="breadcrumb">
				<li><a href="/">خانه</a></li>
				<li><a href="about.php">درباره ما</a></li>
				<li><a href="privacypolicy.php">شرایط و ضوابط</a></li>
				<li><a href="courses.php">درس ها</a></li>
				<li><a href="faq.php">سوالات شما</a></li>
				<li><a href="help.php">کمک به سایت</a></li>
				<li><a href="contact.php">تماس با ما</a></li>
				<li><a href="login.php">ورود</a></li>
				<li><a href="register.php">ثبت نام</a></li>
				<li class="pull-left hidden-sm arial">Copyright &copy; <?php echo strftime("%Y", time()); ?> Parsclick&nbsp;&nbsp;&nbsp;</li>
			</ul><!-- breadcrumb -->
			<ul class="breadcrumb">
				<a target="_blank" href="https://www.facebook.com/persiantc"><i title="Facebook" class="fa fa-facebook-square fa-3x"></i></a>&nbsp;&nbsp;
				<a target="_blank" href="https://twitter.com/AmirHassanAzimi"><i title="Twitter" class="fa fa-twitter-square fa-3x"></i></a>&nbsp;&nbsp;
				<a target="_blank" href="https://www.youtube.com/user/PersianComputers"><i title="YouTube" class="fa fa-youtube-square fa-3x"></i></a>&nbsp;&nbsp;
				<a target="_blank" href="https://instagram.com/amirhazz/"><i title="Instagram" class="fa fa-instagram fa-3x"></i></a>&nbsp;&nbsp;
				<a target="_blank" href="https://plus.google.com/+PersianComputers/posts"><i title="Google+" class="fa fa-google-plus-square fa-3x"></i></a>&nbsp;&nbsp;
				<a target="_blank" href="https://www.linkedin.com/in/hass0azimi"><i title="LinkedIn" class="fa fa-linkedin-square fa-3x"></i></a>&nbsp;&nbsp;
				<a target="_blank" href="https://github.com/hassanazimi"><i title="GitHub" class="fa fa-github-square fa-3x"></i></a>&nbsp;&nbsp;
				<a target="_blank" href="http://feeds.feedburner.com/parsclick/HGms"><i title="RSS" class="fa fa-rss-square fa-3x"></i></a>&nbsp;&nbsp;
				<i title="American Express" class="pull-left fa fa-cc-amex fa-3x hidden-sm"></i>
				<i title="Visa" class="pull-left fa fa-cc-visa fa-3x hidden-sm"></i>
				<i title="Master Card" class="pull-left fa fa-cc-mastercard fa-3x hidden-sm"></i>
				<i title="Stripe" class="pull-left fa fa-cc-stripe fa-3x hidden-sm"></i>
			</ul>
		</nav><!-- nav -->
	</footer><!-- footer -->
</section><!-- footer container -->
</section><!-- container -->
<script src="_/js/all.js"></script>
<?php active(); ?>
<?php include_once("_/components/php/google_analytic.php"); ?>
</body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>