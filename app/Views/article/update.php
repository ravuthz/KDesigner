<?php
	Cls::checkLogin();
	$language = new Language();
    $lang =  $language->getLang();
    HTML::adminHeader($lang);

	if ($data['id']) {
		$user = new UserObj();
		$article = new ArticleObj();
		$art = $article->detail($data['id'])->data();
	}

	if (Input::exists()){
		if(Token::check(Input::get('token'))) {
			
			$article->update(array(
				'title' => Input::get('mytitle'),
				'content' => Input::get('mycontent'),
				'catId' => Input::get('mycategory'),
				'file' => Input::get('myfile'), 
				'addOn' => date('Y-m-d H:i:s'),
				'addBy' => $user->data()->id, 
				'addByUser' => $user->data()->username,
				'catName' => Input::get('mycategory'),
				'status' => Input::get('mystatus'),
				'highlight' => Input::get('myhighlight')
			), $data['id']);
			HTML::setAlert("update", "This article was updated successfully");
			Redirect::to(Config::get('web/dir') . 'articles/index');
		}
	}

	Form::update($data);
?>

<?php HTML::adminFooter($lang); ?>