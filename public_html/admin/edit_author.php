<?php require_once('../../includes/initialize.php');
$session->confirm_admin_logged_in();
$author = Author::find_by_id($_GET['id']);
$errors = '';
if ( ! $author) {
	$session->message('نویسنده پیدا نشد!');
	redirect_to('author_list.php');
}
if (isset($_POST['submit'])) {
	$author->id            = (int) $_GET['id'];
	$author->username      = strtolower($_POST['username']);
	$author->first_name    = ucwords(strtolower($_POST['first_name']));
	$author->last_name     = ucwords(strtolower($_POST['last_name']));
	$author->email         = strtolower($_POST['email']);
	$author->parsclickmail = strtolower($_POST['parsclickmail']);
	$author->status        = (int) $_POST['status'];
	$result                = $author->save();
	if ($result) {
		$session->message('نویسنده بروزرسانی شد.');
		redirect_to('author_list.php');
	} else {
		$errors = 'نتوانستیم نویسنده را بروزرسانی کنیم یا اینکه شما چیزی عوض نکردید.';
	}
}
include_layout_template('admin_header.php');
include_layout_template('admin_nav.php');
echo output_message($message, $errors);
?>
	<section class="main col-sm-12 col-md-9 col-lg-9">
		<article>
			<h2><i class="fa fa-pencil-square"></i> ویرایش نویسنده</h2>
			<form class="form-horizontal" action="edit_author.php?id=<?php echo urlencode($author->id); ?>" method="post"
			      role="form" data-remote>
				<fieldset>
					<legend><i class="fa fa-user"></i> <?php echo htmlentities(ucwords(strtolower($author->full_name()))); ?>
					</legend>
					<!--username-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="username">اسم کاربری</label>
						<div class="controls">
							<input class="col-xs-12 col-sm-8 col-md-8 col-lg-8 edit" type="text" name="username" id="username"
							       placeholder="Username" value="<?php echo htmlentities($author->username); ?>" required/>
						</div>
					</section>
					<!--password-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="password">پسورد</label>
						<div class="controls">
							<input disabled class="col-xs-12 col-sm-8 col-md-8 col-lg-8 edit" type="password" name="password"
							       id="password" placeholder="Password is hashed!"/>
						</div>
					</section>
					<!--first_name-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="first_name">نام</label>
						<div class="controls">
							<input class="col-xs-12 col-sm-8 col-md-8 col-lg-8" type="text" name="first_name" id="first_name"
							       placeholder="نام" value="<?php echo htmlentities($author->first_name); ?>" required/>
						</div>
					</section>
					<!--last_name-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="last_name">نام خانوادگی</label>
						<div class="controls">
							<input class="col-xs-12 col-sm-8 col-md-8 col-lg-8" type="text" name="last_name" id="last_name"
							       placeholder="نام خانوادگی" value="<?php echo htmlentities($author->last_name); ?>" required/>
						</div>
					</section>
					<!--email-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="email">ایمیل</label>
						<div class="controls">
							<input class="col-xs-12 col-sm-8 col-md-8 col-lg-8 edit" type="text" name="email" id="email"
							       placeholder="Email" value="<?php echo htmlentities($author->email); ?>" required/>
						</div>
					</section>
					<!--parsclickmail-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="parsclickmail">
							ایمیل پارس کلیک</label>
						<div class="controls">
							<input class="col-xs-12 col-sm-8 col-md-8 col-lg-8 edit" type="text" name="parsclickmail"
							       id="parsclickmail" placeholder="Parsclick Mail"
							       value="<?php echo htmlentities($author->parsclickmail); ?>"/>
						</div>
					</section>
					<!--status-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="status">فعال</label>
						<div class="controls">
							<label class="radio-inline" for="inlineRadioNo">
								<input type="radio" name="status" id="inlineRadioNo"
								       value="0" <?php echo ($author->status == 0) ? ' checked ' : ''; ?> />
								خیر
							</label>
							<label class="radio-inline" for="inlineRadioYes">
								<input type="radio" name="status" id="inlineRadioYes"
								       value="1" <?php echo ($author->status == 1) ? ' checked ' : ''; ?> />
								بله
							</label>
							<label class="radio-inline" for="inlineRadioYes">
								<input type="radio" name="status" id="inlineRadioYes"
								       value="2" <?php echo ($author->status == 2) ? ' checked ' : ''; ?> />
								مسدود
							</label>
						</div>
					</section>
					<!--buttons-->
					<section class="row">
						<label class="col-xs-12 col-sm-4 col-md-4 col-lg-4 control-label" for="submit">&nbsp;</label>
						<div class="controls">
							<a class="btn btn-danger" href="author_list.php">لغو</a>
							<a class="btn btn-info confirmation" href="delete_author.php?id=<?php echo urlencode($author->id); ?>">
								حذف
							</a>
							<button class="btn btn-success" name="submit" id="submit" type="submit"
							        data-loading-text="یک لحظه صبر کنید <i class='fa fa-spinner fa-pulse'></i>">
								ویرایش
							</button>
						</div>
					</section>
				</fieldset>
			</form>
		</article>
	</section>
	<section class="sidebar col-sm-12 col-md-3 col-lg-3">
		<aside>
			<h2>آواتار</h2>
			<?php if (empty($author->photo)): ?>
				<p class="text-muted center">عکس پروفایل موجود نیست.</p>
			<?php else: ?>
				<img class="img-thumbnail center" alt="Profile Picture"
				     src="data:image/jpeg;base64,<?php echo base64_encode($author->photo); ?>">
				<div class="center">
					<a class="btn btn-default btn-small confirmation"
					   href="remove_author_photo.php?id=<?php echo urlencode($author->id); ?>">
						حذف آواتار
					</a>
				</div>
			<?php endif; ?>
		</aside>
	</section>
<?php include_layout_template('admin_footer.php'); ?>