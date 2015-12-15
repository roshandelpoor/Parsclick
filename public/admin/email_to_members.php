<?php
require_once("../../includes/initialize.php");
$filename = basename(__FILE__);
$session->confirm_admin_logged_in();
$title   = "پارس کلیک - ایمیل به اعضا";
$errors  = '';
$message = '';
if(isset($_POST['submit'])) {
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->IsHTML(TRUE);
	$mail->CharSet    = 'UTF-8';
	$mail->Host       = SMTP;
	$mail->SMTPSecure = TLS;
	$mail->Port       = PORT;
	$mail->SMTPAuth   = TRUE;
	$mail->Username   = EMAILUSER;
	$mail->Password   = EMAILPASS;
	$mail->FromName   = DOMAIN;
	$mail->From       = EMAILUSER;
	$mail->Subject    = $_POST['subject'];
	$mail->AddAddress("do-not-reply@parsclick.net", "Parsclick Members");
	foreach(Member::find_all() as $members) {
		$mail->AddBCC($members->email, $members->full_name());
	}
	$mail->Body =
			"<body style='direction:rtl;background-color:#F5F5DC;font-family:Tahoma;'>
			" . nl2br($_POST['message']) . "
			<hr>
			<a href='http://www.parsclick.net' target='_blank'>پارس کلیک</a><br/>
			<small>لطفا جواب این ایمیل را ندهید.</small>
			</body>";
	$result     = $mail->Send();
	if($result) {
		$message = "پیام به همه اعضا فرستاده شد.";
	} else {
		$errors = "خطا در فرستادن پیام!";
	}
} else {
}
?>
<?php include_layout_template("admin_header.php"); ?>
<?php include "../_/components/php/admin_nav.php"; ?>
<?php echo output_message($message, $errors); ?>
	<section class="main col-sm-12 col-md-8 col-lg-8">
		<article>
			<h2>تماس با اعضا</h2>
			<form action="email_to_members.php" method="POST" role="form">
				<fieldset>
					<legend>لطفا از فرم زیر برای تماس با اعضا استفاده کنید</legend>
					<div class="form-group">
						<label for="name">موضوع</label>
						<input type="text" name="subject" class="form-control" id="name" placeholder="موضوع ایمیل" required value=""/>
					</div>
					<div class="form-group">
						<label for="message">پیغام</label>
						<textarea class="form-control" name="message" id="message" rows="9" placeholder="پیغام" required></textarea>
					</div>
					<br/>
					<div class="form-group">
						<button type="submit" name="submit" class="btn btn-primary">بفرست</button>
					</div>
				</fieldset>
			</form>
		</article>
	</section>
	<section class="sidebar col-sm-12 col-md-4 col-lg-4">
		<aside>
			<h2><i class="fa fa-info-circle"></i> اطلاعات</h2>
			<div class="form-group">
				<label for="emails">ایمیل ها</label>
						<textarea class="form-control edit" name="emails" id="emails" rows="15" placeholder="ایمیل ها" disabled><?php
							foreach(Member::find_all() as $members) echo $members->email, ", ";
							?></textarea>
			</div>
		</aside>
	</section>
<?php include_layout_template("admin_footer.php"); ?>