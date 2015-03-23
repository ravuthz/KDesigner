<?php
Cls::checkLogin();
HTML::adminHeader();

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'firstname' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			),
			'lastname' => array(
				'required' => true,
				'min' => 2,
				'max' => 50
			)		
		));


		if($validation->passed()) {
			try{
				$user->update(array(
					'password' => Input::get('password'),
					'firstname' => Input::get('firstname'),
					'lastname' => Input::get('lastname')
				));

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

	<form action="" method="post">
		<div class="box">
			<div class="field">
				<label for="username">Username : </label>
				<input type="text" name="usernmae" value="<?php echo Cls::escape($user->data()->username); ?>" readonly>
			</div>

			<div class="field">
				<label for="firstname">First name : </label>
				<input type="text" name="firstname" value="<?php echo Cls::escape($user->data()->firstname); ?>">
			</div>
			
			<div class="field">
				<label for="lastname">Last name : </label>
				<input type="text" name="lastname" value="<?php echo Cls::escape($user->data()->lastname); ?>">
			</div>

			<div class="field">
				<input class="mybtn" type="submit" value="Update">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<!-- <a class="mybtn" href="<?php echo Config::get('web/dir') . 'admin/index.php' ?>">Back</a> -->
			</div>
		</div>
	</form>

<?php HTML::adminFooter(); ?>