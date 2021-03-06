<?php require_once('../includes/initialize.php');
$title  = 'پارس کلیک - حساب کاربری';
$errors = '';
if ( ! isset($_GET, $_GET['q'])) {
	redirect_to('/');
}
$search_query = trim($_GET['q']);
$member       = Member::find_by_username($search_query);
if ( ! $member) {
	redirect_to('/');
}
$count_article_comments = ArticleComment::count_comments_for_member($member->id);
$count_course_comments  = Comment::count_comments_for_member($member->id);
$count_playlist         = Playlist::count_playlist_for_member($member->id);
$experience             = ($count_article_comments + $count_course_comments + $count_playlist) * 100;
?>
<?php include_layout_template('header.php'); ?>
<?php if (isset($session->id)): ?>
	<?php include_layout_template('member_nav.php'); ?>
<?php else: ?>
	<?php include_layout_template('nav.php'); ?>
<?php endif; ?>
<?php echo output_message($message, $errors); ?>
<section class="sidebar col-sm-12 col-md-3 col-lg-3">
	<aside class="center center-block">
		<img class="img-circle center" width="200"
		     src="http://gravatar.com/avatar/<?php echo md5($member->email); ?>?s=200&d=<?php echo DOMAIN . DS .
				     'images/misc/default-gravatar-pic.png'; ?>"
		     alt="<?php echo $member->email; ?>"/>
		<p class="lead"><?php echo $member->address; ?> - <?php echo $member->city; ?></p>
	</aside>
</section>
<section class="main col-sm-12 col-md-6 col-lg-6">
	<article class="center center-block" style="min-height:300px;">
		<h1><?php echo $member->username; ?></h1>
		<h3 class="text-success"><?php echo ucwords(strtolower($member->full_name())); ?></h3>
		<p class="lead">تعداد نظرات در مورد مقالات:
			<b><?php echo $count_article_comments ? convert($count_article_comments) : 'هیچی'; ?></b>
		</p>
		<p class="lead">تعداد نظرات در مورد دروس:
			<b><?php echo $count_course_comments ? convert($count_course_comments) : 'هیچی'; ?></b>
		</p>
		<p class="lead">تعداد درس های محبوب: <b><?php echo $count_playlist ? convert($count_playlist) : 'هیچی'; ?></b>
		</p>
	</article>
</section>
<section class="sidebar col-sm-12 col-md-3 col-lg-3">
	<aside class="center center-block">
		<p class="large-text underline"><?php echo convert($experience); ?></p>
		<p class="lead">تجربه</p>
	</aside>
</section>
<?php include_layout_template('footer.php'); ?>
