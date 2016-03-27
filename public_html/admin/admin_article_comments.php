<?php
require_once("../../includes/initialize.php");
$session->confirm_admin_logged_in();
$filename = basename(__FILE__);
find_selected_article();
if( ! $current_article) {
	$session->message("هیچ درسی پیدا نشد!");
	redirect_to("admin_articles.php");
}
// Pagination
$page        = ! empty($_GET["page"]) ? (int)$_GET["page"] : 1;
$per_page    = 20;
$total_count = ArticleComment::count_comments_for_article($current_article->id);
$pagination  = new pagination($page, $per_page, $total_count);
$comments    = ArticleComment::find_comments($current_article->id, $per_page, $pagination->offset());
include_layout_template("admin_header.php");
include("../_/components/php/admin_nav.php");
echo output_message($message);
?>
	<section class="main col-sm-12 col-md-7 col-lg-7">
		<article>
			<h3><i class="fa fa-comments fa-lg"></i> نظرات</h3>
			<?php foreach($comments as $comment): ?>
				<section class="media">
					<?php $_member = Member::find_by_id($comment->member_id); ?>
					<img class="img-circle pull-right" style="padding-right:0;" src="http://gravatar.com/avatar/<?php echo md5($_member->email); ?>?s=50" alt="<?php echo $_member->email; ?>">
					<div class="media-body arial">
						<span class="badge">
							<span class="yekan"><?php echo htmlentities($_member->full_name()); ?></span>
							<?php echo htmlentities(datetime_to_text($comment->created)); ?></span>
						<a class="badge label-danger" href="admin_delete_article_comment.php?id=<?php echo urlencode($comment->id); ?>">
							<i class="fa fa-times"></i>
						</a>
						<p><?php echo strip_tags($comment->body, '<strong><em><p><pre>'); ?></p>
					</div>
				</section>
			<?php endforeach; ?>
			<?php if($pagination->total_page() > 1): ?>
				<nav class="clearfix center">
					<ul class="pagination">
						<?php if($pagination->has_previous_page()): ?>
							<li>
								<a href="admin_article_comments.php?article=<?php echo urlencode($current_article->id) ?>&page=<?php echo urlencode($pagination->previous_page()); ?>" aria-label="Previous">
									<span aria-hidden="true">&lt;&lt;</span>
								</a>
							</li>
						<?php endif; ?>
						<?php for($i = 1; $i < $pagination->total_page() + 1; $i++): ?>
							<?php if($i == $page): ?>
								<li class="active">
									<span><?php echo convert($i); ?></span>
								</li>
							<?php else: ?>
								<li>
									<a href="admin_article_comments.php?article=<?php echo urlencode($current_article->id); ?>&page=<?php echo urlencode($i); ?>"><?php echo convert($i); ?></a>
								</li>
							<?php endif; ?>
						<?php endfor; ?>
						<?php if($pagination->has_next_page()): ?>
							<li>
								<a href="admin_article_comments.php?article=<?php echo urlencode($current_article->id) ?>&page=<?php echo urlencode($pagination->next_page()); ?>" aria-label="Next">
									<span aria-hidden="true">&gt;&gt;</span>
								</a>
							</li>
						<?php endif; ?>
					</ul>
				</nav>
			<?php endif; // pagination ?>
			<?php if(empty($comments)): ?>
				<h3><span class="label label-default">نظری نیست</span></h3>
			<?php endif; ?>
		</article>
	</section>
	<section class="sidebar col-sm-12 col-md-5 col-lg-5">
		<aside>
			<h2><i class="fa fa-film"></i> جزئیات درس</h2>
			<dl class="well dl-horizontal">
				<dt>اسم درس:</dt>
				<dd><?php echo htmlentities($current_article->name); ?></dd>
				<dt>موضوع:</dt>
				<dd><?php echo htmlentities(Category::find_by_id($current_article->subject_id)->name); ?></dd>
				<dt>نویسنده:</dt>
				<dd><?php echo htmlentities(Author::find_by_id($current_article->author_id)->full_name()); ?></dd>
			</dl>
			<div class="alert alert-info">
				<i class="fa fa-info-circle"></i>
				نظرات بی درنگ قابل حذف شدن هستند.
			</div>
			<div class="alert alert-danger">
				<i class="fa fa-info-circle"></i>
				کلمات رکیک را حذف کنید!
			</div>
		</aside>
	</section>
<?php include_layout_template("admin_footer.php"); ?>