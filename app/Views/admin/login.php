<?php

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new validate();
		$validation = $validate->check($_POST, array(
			'username' => array('required' =>true),
			'password' => array('required' =>true)
		));

		if($validation->passed()) {

			$user = new UserObj();
			$remember = (Input::get('remember') === 'on') ? true : false;
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);

			if($login) {
				Redirect::to(Config::get('web/dir') . 'admin/index.php');
			} else {
				// Redirect::to(Config::get('web/dir') . 'admin/login.php');
				echo "<span class='error'>Login failure</span>";
			}

		} else {
			foreach ($validation->errors() as $error) {
				echo $error, '<br>';
			}
		}
	}
}

$user = new UserObj();
if($user->isLoggedIn()) {
	Redirect::to(Config::get('web/dir') . 'admin/index.php');
} else { 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' content='text/html'>
	<title>Login</title>
	<link rel='stylesheet' href='<?= Config::get('web/dir') ?>style/form.css'/>
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
	<script type='text/javascript' src='<?= Config::get('web/dir') ?>script/main.js'></script>
</head>
<body>
	<header>
		<div class="container">
			<div class="left title">
				<h1><a href="<?php echo Config::get('web/dir') . 'home/index' ?>">KhmerDesigner </a>
					<a href="<?php echo Config::get('web/dir') . 'admin/index' ?>">Admin</a>
				</h1>
				
			</div>
			<div class="right login">
				<form action="" method="post">
					<table>
						<tr>
			
							<td><input id="username" type="text" name="username" autocomplete="off"></td>
							<td><input id="password" type="password" name="password" autocomplete="off"></td>
							<td>
								<!-- This will create a token when the page load or reload -->
								<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
								<input type="submit" name="submit" value="Sign In">
							</td>
						</tr>
						<tr>
							<td>
								<input type="checkbox" name="remember" id="remember">
								<label for="remember">Remeber me</label>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="line"></div>
	</header>
	
	<section>
		<div class="container">
			<div class="left">	
				<table>
					<tr>
						<td><h3>Welcome to Khmer Design</h3></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2">
							This was develop by Nhim Chanbory, Mao Bunthorn, Yo Vannaravuth.
						</td>
					</tr>
					<tr>
						<td>
							You can contact us by :
						</td>
					</tr>
					<tr>
						<td>Phone : </td>
						<td>Mail : </td>
					</tr>
					<tr>
						<td>096 457 7770</td>
						<td>Ravuthz@gmail.com</td>
					</tr>
				</table>
			</div>
			<div class="right register">
				<form action="" method="post">
					<table>
						<tr>
							<td><b>New to Khmer Design ?</b> <i>Register now</i></td>
						</tr>
						<tr>
							<td class="two"><input type="text" name="firstname" placeholder="Frist Name" autocomplete="off"></td>
							<td class="two"><input type="text" name="lastname" placeholder="Last Name" autocomplete="off"></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="lastname" placeholder="Last Name" autocomplete="off"></td>
						</tr>
						<tr>
							<td colspan="2"><input type="text" name="email" placeholder="Email" autocomplete="off"></td>
						</tr>
						<tr>
							<td><input type="submit" name="submit" value="Sign Up"></td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</section>

	<footer>
		<!-- <p><span>Language : </span>Khmer, English</p> -->
	</footer>
</body>
</html>
<?php } ?>





