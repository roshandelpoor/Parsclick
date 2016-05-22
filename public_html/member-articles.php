<?php require_once('../includes/initialize.php');
$filename = basename(__FILE__);
$title    = 'پارس کلیک - مقالات';
$session->confirm_logged_in();
$member = Member::find_by_id($session->id);
$member->check_status();
find_selected_article(TRUE);
$errors = '';
$body   = '';
?>
<?php include_layout_template('header.php'); ?>
<?php include_layout_template('member_nav.php'); ?>
<?php echo output_message($message, $errors); ?>
	<section class="main col-sm-12 col-md-8 col-lg-8">
		<article id="member_article">
			<?php if($current_subject && $current_article): ?>
				<?php include_layout_template('article-info.php'); ?>
			<?php else: ?>
				<h2>به قسمت مقالات خوش آمدید.</h2>
				<div class="visible-lg"><?php include_layout_template('member_article_info.php'); ?></div>
			<?php endif; ?>
		</article>
	</section>
	<section class="sidebar col-sm-12 col-md-4 col-lg-4">
		<aside class="members_menu">
			<form class="form-inline" action="member-article-search" method="GET">
				<div class="input-group">
					<span class="input-group-addon"><span class="arial glyphicon glyphicon-search"></span></span>
					<input type="text" name="q" class="form-control" size="30" maxlength="50" data-toggle="tooltip"
					       data-placement="top" title="جستجو کنید و اینتر بزنید" placeholder="جستجوی مقالات یا نام نویسنده"/>
				</div>
			</form>
			<h2>موضوعات و مقالات</h2>
			<?php echo articles($current_subject, $current_article, TRUE); ?>
			<h2>وبلاگ پارس کلیک</h2>
			<p>برای اخبار، کوپن های یودمی، خبر از درس های آینده، پادکست، صحبت از نویسندگان، صحبت از مقالات خوب، لینک دانلود
			   ویدیو و خیلی چیزهای دیگه به وبلاگ پارس کلیک سر بزنید.</p>
			<ul class="list-group">
				<li class="list-group-item">
					<a href="http://blog.parsclick.net/" target="_blank">وبلاگ پارس کلیک</a>
					<span class="label label-as-badge label-danger pull-left">اخبار</span>
				</li>
			</ul>
			<p><?php include_layout_template('aside-ad.php'); ?></p>
		</aside>
	</section>
<?php include_layout_template('footer.php'); ?>