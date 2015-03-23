<?php
    Cls::checkLogin();
    HTML::adminHeader();
    $article = new ArticleObj();
    $category = new CategoryObj();
?>

<?php 
	// HTML::show($article->listAll(1)->datas());

	HTML::adminFooter(); 
?>