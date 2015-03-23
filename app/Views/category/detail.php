<?php
Cls::checkLogin();
HTML::adminHeader("Article");

if ($data['id']) {
	$article = new Article();
	$show = $article->detail($data['id'])->first();
?>
<section>
	<h1>Home of Article - Detail</h1>
	<article>
		<h3><?php echo $show->title; ?></h3>
		<small>on <?php echo $show->addOn; ?> by <?php echo $show->byUser; ?></small>
		<p><?php echo $show->content; ?></p>
	</article>
</section>

<?php
	HTML::adminFooter(); 
	} else {
		Redirect::to(Config::get('web/dir') . 'articles/index');
	}
?>