<?php
HTML::homeHeader();

$article = new ArticleObj();
$post = $article->detail($data['id'])->data();

?>
	<section>
        <header>
            <h3><?= $post->title; ?></h3><br/>
            <span>
                On <small><?= Cls::printDate($post->addOn); ?></small>
                By <small><?= $post->byUser; ?></small>
            </span>
        </header>

		<article class="post-content">
			<p>
				<?= $post->content; ?>
			</p>
		</article>
        <div class="clearfix"></div>
	</section>

<?= HTML::homeFooter(); ?>