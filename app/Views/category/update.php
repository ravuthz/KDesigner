<?php
	Cls::checkLogin();
	HTML::adminHeader("Article");
?>

<section>
	<h1>Home of Article - Update</h1>
	<div class="alertbar"><!-- alertbar -->

<?php
	if ($data['id']) {
		$article = new Article();
		$art = $article->detail($data['id'])->first();
		$btnName = ($art->status) ? "Unpublish" : "Publish";
	}
	


	$status = 0;
	if(Input::exists()) {
		if (Input::get('status')) {
			$status = 1;
		}

		if(Token::check(Input::get('token'))) {
			$validate = new validate();
			$user = new User();
			$validation = $validate->check($_POST, array(
				'title' => array(
					'required' => true,
					'min' => 5,
					'max' => 50
				),
				'content' => array(
					'required' => true,
					'min' => 5,
				)		
			));

			if($validation->passed()) {
				try{
					$article->update(array(
						'title' => Input::get('title'),
						'content' => Input::get('content'),
						'file' => '', /* Input::get('file'), */
						'addOn' => date('Y-m-d H:i:s'),
						'addBy' => $user->data()->id,
						'status' => $status
					), $data['id']);

					Session::flash('home', 'Your details have been updated.');
					Redirect::to(Config::get('web/dir') . 'admin/index.php');
				} catch (Exception $e) {
					die($e->getMessage());
				}
			} else {
				foreach ($validation->errors() as $error) {
					echo "<p class='alert'>" . $error . "</p>";
				}
			}
		}
	}
?>

	</div><!-- alertbar -->
	<form action="" method="post">
		<div class="box">
			<div class="field">
				<input class="txt-title" type="text" name="title" value="<?php echo $art->title; ?>"/>
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
				<input class="mybtn" type="submit" value="Update" />
				<input class="mybtn" name="publish" type="button" value="<?php echo $btnName; ?>" onclick="publishArticle();" />
				<input type="hidden" name="status" value="0">
			</div>

			<div class="field">
				<textarea class="txt-content" name="content" /><?php echo $art->content; ?></textarea>
			</div>
		</div>
	</form>
</section>
<?php HTML::adminFooter(); ?>