<?php
Cls::checkLogin();
HTML::adminHeader();

if ($data['id']) {
	$article = new ArticleObj();
	$show = $article->detail($data['id'])->first();

	$update = Config::get('web/dir') . "articles/update/" . $show->id;
	$back = Config::get('web/dir') . "articles/index";
?>

	<h1>Home of Article - Detail</h1>
	
	<a href="<?= $update ?>">Update</a>
	<a href="<?= $back ?>">Back</a>

	<article>
		<h3><?= $show->title; ?></h3>
		<small>Posted on <?= $show->addOn; ?> by <?= $show->byUser; ?></small>
		<fieldset>
			<p><?= $show->content; ?></p>
		</fieldset>
	</article>

<?php
	HTML::adminFooter(); 
	} else {
		Redirect::to(Config::get('web/dir') . 'articles/index');
	}
?>