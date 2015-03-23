<?php
if(Input::exists()) {
	// Start to check token (Prevent when user refreh page)
	if(Token::check(Input::get('token'))) {

		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'
			),
			'password' => array(
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'required' => true,
				'matches' => 'password' 
			),
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
			
			$user = new User();
			$salt = Hash::salt(32);

			try {
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'firstname' => Input::get('firstname'),
					'lastname' => Input::get('lastname'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1
				));

				Session::flash('home', 'You have been registered and can now login!');
				// header('Location: index.php'); =
				Redirect::to(Config::get('web/dir') . 'admin/index.php');

			} catch (Exception $e) {
				die($e->getMessage());
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo '<span class="error">' . $error, '</span><br>';
			}

		}

	} // End the checking token
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register form</title>
</head>
<body>
	<form action="" method="post">

	<div class="box">
		<div class="field">
			<label for="username">Username : </label>
			<input type="text" name="username" autocomplete="off">
		</div>

		<div class="field">
			<label for="password">Choose a password</label>
			<input id="password" type="password" name="password" autocomplete="off">
		</div>

		<div class="field">
			<label for="password">Confirm password</label>
			<input id="password_again" type="password" name="password_again" autocomplete="off">
		</div>

		<div class="field">
			<label for="firstname">First name : </label>
			<input type="text" name="firstname">
		</div>
		
		<div class="field">
			<label for="lastname">Last name : </label>
			<input type="text" name="lastname">
		</div>

		<div class="field">
			<!-- This will create a token when the page load or reload -->
			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" value="Register">
			<a href="<?php echo Config::get('web/dir') . 'admin/index.php' ?>">Back</a>
		</div>
	</div>

</form>
</body>
</html>