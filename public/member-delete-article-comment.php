<?php
require_once("../includes/initialize.php");
$session->confirm_logged_in();
if(empty($_GET["id"])) {
	$session->message("شناسه نظر پیدا نشد!");
	redirect_to("member-articles");
}
$comment = ArticleComment::find_by_id($_GET["id"]);
$article  = Article::find_by_id($comment->article_id);
if(!$comment || !$article) {
	$session->message("مقاله یا نظر موجود نیست!");
	redirect_to("member-articles");
}
if($comment->delete()) {
	$session->message("نظر حذف شد.");
	redirect_to($_SERVER['HTTP_REFERER'] . '#comments');
} else {
	$session->message("نظر حذف نشد!");
	redirect_to($_SERVER['HTTP_REFERER'] . '#comments');
}
if(isset($database)) { $database->close_connection(); }