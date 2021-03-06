<?php require_once('../../includes/initialize.php');
if ($session->is_admin_logged_in()) {
	redirect_to('admin.php');
} elseif ($session->is_author_logged_in()) {
	redirect_to('author.php');
}
$username = '';
$password = '';
$errors   = '';
if (isset($_POST['submit'])) {
	if (request_is_post() && $session->request_is_same_domain()) {
		if ($session->csrf_token_is_valid() && $session->csrf_token_is_recent()) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$type     = '';
			if (isset($_POST['type'])) {
				$type = trim($_POST['type']);
			}
			if (has_presence($username) && has_presence($password) && has_presence($type)) {
				$throttle_delay = FailedLogins::throttle_failed_logins($username);
				if ($throttle_delay > 0) {
					$errors = "حساب کابری قفل شده. باید {$throttle_delay} دقیقه صبر کنید و بعد دوباره سعی کنید.";
				} else {
					$found_admin  = Admin::authenticate($username, $password);
					$found_author = Author::authenticate($username, $password);
					// TRY TO LOGIN
					if ($found_admin && ($type === 'admin')) { // find the super admin 1st
						$session->admin_login($found_admin);
						log_action('Login:', '<span class="alert-danger">' . $found_admin->username . '</span>');
						FailedLogins::clear_failed_logins($username);
						redirect_to('admin.php');
					} elseif ($found_author && ($type === 'author')) { // find the authors 2nd
						$session->author_login($found_author);
						log_action('Login:', '<span class="alert-success">' . $found_author->username . '</span>');
						FailedLogins::clear_failed_logins($username);
						redirect_to('author.php');
					} else {
						$errors = 'اسم کاربری و یا پسورد اشتباه است!';
						$failed = new FailedLogins();
						$failed->record_failed_login($username);
					}
				}
			} else {
				$errors = 'اسم کاربری، پسورد یا نوع خالی هستند.';
			}
		} else {
			$session->die_on_csrf_token_failure();
		}
	} else {
		$errors = 'درخواست معتبر نیست!';
	}
}
include_layout_template('admin_header.php');
?>
	<header class="clearfix">
		<section id="branding">
			<a href="/admin"><img src="../images/misc/admin-area.png" alt="Logo for Admin Area"></a>
		</section>
	</header>
	<hr/>
<?php echo output_message($message, $errors); ?>
	<section class="main col-sm-12 col-md-8 col-lg-8">
		<?php include_layout_template('admin_login.php'); ?>
	</section><!-- main -->
<?php include_layout_template('admin_footer.php'); ?>