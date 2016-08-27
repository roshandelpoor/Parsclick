<?php require_once('../includes/initialize.php');
$title = 'پارس کلیک - قسمت اعضا';
$session->confirm_logged_in();
$member = Member::find_by_id($session->id);
$member->check_status();
$newest_course  = Course::find_newest_course();
$newest_article = Article::find_newest_article();
?>
<?php include_layout_template('header.php'); ?>
<?php include_layout_template('member_nav.php'); ?>
<?php echo output_message($message); ?>

<div class="jumbotron hidden-sm wow fadeIn member-jumbotron">
	<img class="pull-left img-circle" width="150" height="150"
	     src="http://gravatar.com/avatar/<?php echo md5($member->email); ?>?s=150&d=<?php echo '//' . DOMAIN . '/images/misc/default-gravatar-pic.png'; ?>">
	<a class="bright pull-left" href="#" id="notification" title="اعلانات" data-toggle="tooltip">
		<i class="fa fa-bell fa-lg"></i>
	</a>

	<h1><?php echo $member->full_name(); ?></h1>
	<div class="clearfix"></div>
	<?php if ($newest_course): ?>
		<p>جدیدترین درس:&nbsp;
			<a class="bright" title='کلیک کنید' data-toggle="tooltip" data-placement="left"
			   href="member-courses?category=<?php echo $newest_course->category_id; ?>&course=<?php echo $newest_course->id; ?>">
				<?php echo $newest_course->name; ?> </a>&nbsp;</p>
	<?php endif; ?>
	<?php if ($newest_article): ?>
		<p>جدیدترین مقاله:&nbsp;
			<a class="bright" title='کلیک کنید' data-toggle="tooltip" data-placement="left"
			   href="member-articles?subject=<?php echo $newest_article->subject_id; ?>&article=<?php echo $newest_article->id; ?>">
				<?php echo $newest_article->name; ?> </a>&nbsp;</p>
	<?php endif; ?>
	<p>درس های داخل لیست پخش:&nbsp;
		<?php if (Playlist::find_playlist_for_member($member->id)): ?>
			<a class="bright" title='کلیک کنید' data-toggle="tooltip" data-placement="left"
			   href="member-playlist">
				<?php echo convert(Playlist::count_playlist_for_member($member->id)); ?> درس
			</a>
		<?php else: ?>
			هیچی !
		<?php endif; ?>
	</p>
	<p class="edit bright"> GMT امروز <?php echo datetime_to_shamsi(time()); ?></p>
	<div class="clearfix"></div>
	<p class="edit bright">Today is <?php echo datetime_to_text(date('Y-m-d H:i:s')); ?></p>
</div><!--.jumbotron-->
<section class="main col-sm-12 col-md-8 col-lg-8">
	<article>
		<h3>
			<span
					class="label label-info visible-sm"><?php echo 'خوش آمدید  ' . ucwords(strtolower($member->full_name())); ?></span>
		</h3>
	</article>
	<?php include_layout_template('recent-article.php'); ?>
</section>
<section class="sidebar col-sm-12 col-md-4 col-lg-4">
	<aside>
		<h2><i class="fa fa-book"></i> محتوای کتابخانه</h2>
		<i class="pull-right fa fa-film fa-5x text-danger"></i>
		<p>با دنبال کردن درس ها شما به ویدیو ها دسترسی پیدا خواهید کرد. ویدیوهایی که در رابطه با دروس کامپیوتر هستند.
		   این دروس درون دسته ها یا مقوله هایی برای دسترسی آسانتر طبقه بندی شده اند.در اولین صفحه شما قادر به جستجو کردن
		   درس ها هستید اگر دنبال درس خاصی می گردید. هر درسی شامل یک فایل تمرینی می باشد که با دانلود کردن این فایل زیپ
		   تمامی فایل هایی تمرینی بعد از خارج کردن فایل فشرده قابل مشاهده خواهند بود. در ضمن نظر نویسی برای هر درس
		   جداگانه امکان پذیر است.</p>
		<p><a class="btn btn-small btn-danger" href="member-courses">دیدن درس ها</a></p>
		<hr/>
		<i class="pull-right fa fa-newspaper-o fa-5x text-danger"></i>
		<p>با دنبال کردن مقالات ها شما به مقاله ها دسترسی پیدا خواهید کرد. مقاله هایی که در رابطه با کامپیوتر هستند. این
		   مقاله ها درون موضوعات برای دسترسی آسانتر طبقه بندی شده اند.در اولین صفحه شما قادر به جستجو کردن مقاله ها
		   هستید اگر دنبال مقاله ی خاصی می گردید.</p>
		<p><a class="btn btn-small btn-danger" href="member-articles">دیدن مقالات</a></p>
		<?php include_layout_template('weblog.php'); ?>
		<p><?php include_layout_template('aside-ad.php'); ?></p>
	</aside>
</section>

<?php include_layout_template('notification.php'); ?>
<?php include_layout_template('footer.php'); ?>
