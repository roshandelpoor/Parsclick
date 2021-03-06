<?php require_once '../../includes/initialize.php';
$session->confirm_author_logged_in();
$author = Author::find_by_id($session->id);
$author->check_status();
$deactive_authors    = Author::find_deactive_authors();
$articles_under_edit = Article::find_articles_for_author($author->id, false);
$courses_under_edit  = Course::find_courses_for_author($author->id, false);
$articles_for_author = Article::find_articles_for_author($author->id, true);
$courses_for_author  = Course::find_courses_for_author($author->id, true);
$newest_content_date = find_newest_date([
        Article::find_newest_article_for_author($author->id) ? Article::find_newest_article_for_author($author->id)->created_at : $author->created_at,
        Course::find_newest_course_for_author($author->id) ? Course::find_newest_course_for_author($author->id)->created_at : $author->created_at,
]);
include_layout_template('admin_header.php');
include_layout_template('author_nav.php');
echo output_message($message);
?>
<div class="jumbotron hidden-sm wow fadeIn author-jumbotron">
	<?php if (! empty($author->photo)): ?>
		<img class="img-circle pull-left" height="150" width="150" alt="<?php echo $author->full_name(); ?>"
		     src="data:image/jpeg;base64,<?php echo base64_encode($author->photo); ?>">
	<?php else: ?>
		<img class="img-circle pull-left" height="150" width="150" src="../images/misc/default-gravatar-pic.png"
		     alt="No Profile Picture">
	<?php endif; ?>
	<h1> نویسنده: <?php echo $author->full_name(); ?></h1>
	<p class="bright">به عنوان نویسنده شما قادر به درست کردن مقاله و درس هستید. شما همینطور قادر به تغییر مقالات و دروس
		خود هستید.</p>
	<p class="bright">برای تماس مستقیم با مدیر از این آدرس استفاده کنید:
		<a class="lead" href="mailto:info@parsclick.net" data-toggle="tooltip" data-placement="left" title="ایمیل به ما"
		   target="_blank">
			<kbd>info@parsclick.net</kbd>
		</a>
	</p>
	<p class="bright"> گروه فیسبوکی نویسندگان پارس کلیک
		<a class="lead" href="https://www.facebook.com/groups/175905176126750/" data-toggle="tooltip" data-placement="left"
		   title="گروه نویسندگان پارس کلیک" target="_blank">
			<kbd>کلیک کنید</kbd>
		</a>
	</p>
	<p class="edit bright"> امروز <?php echo datetime_to_shamsi(time(), '*%d *%B، %Y'); ?> ساعت <span
				id="persian-timer"></span></p>
	<div class="clearfix"></div>
	<p class="edit bright">Today is <?php echo datetime_to_text(date('Y-m-d'), '*%B *%d, %Y'); ?> <span
				id="english-timer"></span></p>
</div>
<section class="main col-sm-12 col-md-8 col-lg-8">
	<article>
		<?php if ($articles_under_edit): ?>
			<h3>
				<span class="label label-danger label-as-badge"><?php echo convert(count($articles_under_edit)); ?></span>
				مقالات زیر بررسی:
			</h3>
			<ul class="fa-ul">
				<?php foreach ($articles_under_edit as $aue): ?>
					<li>
						<i class='fa fa-refresh fa-spin text-danger'></i>&nbsp;
						<a href="author_articles.php?subject=<?php echo urlencode($aue->subject_id); ?>&article=<?php echo urlencode($aue->id); ?>">
							<?php echo $aue->name; ?>
							<span
									class="label label-as-badge label-danger pull-left"><?php echo datetime_to_shamsi($aue->created_at, '*%d *%B، %Y'); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ($courses_under_edit): ?>
			<h3>
				<span class="label label-danger label-as-badge"><?php echo convert(count($courses_under_edit)); ?></span>
				درس های زیر بررسی:
			</h3>
			<ul class="fa-ul">
				<?php foreach ($courses_under_edit as $cue): ?>
					<li>
						<i class='fa fa-refresh fa-spin text-danger'></i>&nbsp;
						<a href="author_courses.php?category=<?php echo urlencode($cue->category_id); ?>&course=<?php echo urlencode($cue->id); ?>">
							<?php echo $cue->name; ?>
							<span class="label label-as-badge label-danger pull-left"><?php echo datetime_to_shamsi($cue->created_at, '*%d *%B، %Y'); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ($articles_for_author): ?>
			<h3>
				<span class="label label-success label-as-badge"><?php echo convert(count($articles_for_author)); ?></span>
				مقاله منتشر شده توسط شما:
			</h3>
			<ul class="fa-ul">
				<?php foreach ($articles_for_author as $afa): ?>
					<li>
						<i class="fa fa-check-square text-success"></i>
						<a href="author_articles.php?subject=<?php echo urlencode($afa->subject_id); ?>&article=<?php echo urlencode($afa->id); ?>">
							<?php echo $afa->name; ?>
							<span
									class="label label-as-badge label-success pull-left"><?php echo datetime_to_shamsi($afa->created_at, '*%d *%B، %Y'); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ($courses_for_author): ?>
			<h3>
				<span class="label label-success label-as-badge"><?php echo convert(count($courses_for_author)); ?></span>
				درس منتشر شده توسط شما:
			</h3>
			<ul class="fa-ul">
				<?php foreach ($courses_for_author as $cfa): ?>
					<li>
						<i class="fa fa-check-square text-success"></i>
						<a href="author_courses.php?category=<?php echo urlencode($cfa->category_id); ?>&course=<?php echo urlencode($cfa->id); ?>">
							<?php echo $cfa->name; ?>
							<span
									class="label label-as-badge label-success pull-left"><?php echo datetime_to_shamsi($cfa->created_at, '*%d *%B، %Y'); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if (! $articles_under_edit && ! $articles_for_author): ?>
			<p>تشکر ویژه ما رو پذیرا باشید چون ما رو انتخاب کردید برای منتشر کردن مقالات خودتون. امیدوارم که بتونید به راحتی
				با کاربرای خودتوی در ارتباط باشید، و اگر قابلیتی از این سیستم می خواهید با ما در میون بگذارید. اما ...</p>
			<p class="lead text-danger">توجه!</p>
			<p>شما در حال حاضر مقاله ای یا درسی ندارید. بهتر هست تا چند وقت دیگه
				<span class="underline">ماکسیمم ۱ ماه</span>
				یک فکری به حال مطلب سازی کنید قبل از اینکه مدیر سایت به خاطر غیر فعال بودن به مدت طولانی حساب شما رو مسدود کنه.
			</p>
			<p>مدیر عضویت نویسندگی نویسنده ای رو بی دلیل مسدود نمی کند و به نویسندگان خیلی احترام قائل هست. اما به عنوان
				نویسنده ای که تازه شروع به کار کردید بهتر هست که مقاله ای آماده کنید و اون رو بفرستید چون دلیلی برای نگه داشتن
				نویسنده ی غیر فعال اینجا پیدا نمی کنیم.</p>
			<p>بعد از اولین مطلب، شما می توانید هر ۶ ماه یک مطلب جدید بسازید، یعنی سالی ۲ مطلب جدید که زیاد هم نیست.</p>
			<p>لطفا قبل از فرستادن مطلب به ویدئوهای آموزش نویسندگی نگاه کنید. انتظار می رود نکاتی که در این ویدئوها مطرح می
				شوند را رعایت کنید.</p>
			<p class="lead pull-left">با تشکر از شمـا</p>
		<?php endif; ?>
	</article>
</section>
<section class="sidebar col-sm-12 col-md-4 col-lg-4">
	<aside>

		<?php if (idle($newest_content_date)): ?>
			<p class="alert alert-danger">
				<b class="lead">تذکر:‌</b>
				عضویت شما به زودی توسط سیستم مسدود خواهد شد چون مدتی است که شما محتوای جدیدی ندارید! شما تا
				<b class="text-warning"><?php echo datetime_to_shamsi(time_left($newest_content_date), '*%d *%B، %Y'); ?></b>
				برای ساخت مطلب جدید وقت داشتید.
			</p>
		<?php elseif (! $articles_under_edit && ! $courses_under_edit &&
                time() < time_left($author->created_at, '+1 month')
        ): ?>
			<p class="alert alert-info">
				<b class="lead">تذکر:‌</b>
				شما به عنوان نویسنده ی جدید فقط تا
				<b class="text-warning"><?php echo datetime_to_shamsi(time_left($author->created_at, '+1 month'), '*%d *%B، %Y'); ?></b>
				برای ساخت مطلب جدید وقت دارید.
			</p>
		<?php else: ?>
			<p class="alert alert-info">
				<b class="lead">نکته:‌</b>
				عضویت نویسندگانی که ۶ ماه محتوای جدیدی ندارند مسدود خواهد شد. شما تا
				<b class="text-warning"><?php echo datetime_to_shamsi(time_left($newest_content_date), '*%d *%B، %Y'); ?></b>
				برای ساخت مطلب جدید وقت دارید.
			</p>
		<?php endif; ?>

		<p class="alert alert-success">
			<b class="lead">راهنمایی:‌</b>
			دوستان نویسنده، چون عکس خیلی مهم هست می تونید از لینک زیر برای عکس داخل مقالاتتون استفاده کنید:
			<a href="https://www.pexels.com/search/computer/" class="btn btn-success btn-block" target="_blank">لینک عکس</a>
		</p>

		<?php if ($deactive_authors): ?>
			<div class="alert alert-danger">
				<b class="lead">نویسندگان مسدود شده:‌</b>
				<h5>حساب کاربری این دوستان نویسنده مسدود هست و بزودی حذف خواهند شد:</h5>
				<ul>
					<?php foreach ($deactive_authors as $deactive_author): ?>
						<li><?php echo $deactive_author->full_name(); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="center">
			<h4>ویدیو اول: نویسندگی</h4>
			<iframe src="https://www.youtube.com/embed/G0TY36VCODc?modestbranding=1&rel=0&showinfo=0&hl=fa-ir" width="320"
			        height="180" frameborder="0" allowfullscreen></iframe>
			<h4>ویدیو دوم: ویرایش کردن</h4>
			<iframe src="https://www.youtube.com/embed/9Wxoo2DgUYw?modestbranding=1&rel=0&showinfo=0&&hl=fa-ir" width="320"
			        height="180" frameborder="0" allowfullscreen></iframe>
			<h4>ویدیو سوم: پاراگراف، عکس ها و کدها </h4>
			<iframe src="https://www.youtube.com/embed/er470cSnl-M?modestbranding=1&rel=0&showinfo=0&&hl=fa-ir" width="320"
			        height="180" frameborder="0" allowfullscreen></iframe>
		</div>
	</aside>
</section>
<?php include_layout_template('admin_footer.php'); ?>
