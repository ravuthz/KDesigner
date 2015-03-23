<?php
Cls::checkLogin();
HTML::adminHeader();
$user = new UserObj();
?>

	<form action="" method="post">
		<div class="box">
			<div class="field">
				<label for="username">Username : </label>
				<input type="text" name="usernmae" value="<?php echo Cls::escape($user->data()->username); ?>" readonly>
			</div>

			<div class="field">
				<label for="firstname">First name : </label>
				<input type="text" name="firstname" value="<?php echo Cls::escape($user->data()->firstname); ?>" readonly>
			</div>
			
			<div class="field">
				<label for="lastname">Last name : </label>
				<input type="text" name="lastname" value="<?php echo Cls::escape($user->data()->lastname); ?>" readonly>
			</div>

			<div class="field">
				<label for="joined">Create On : </label>
				<input type="text" name="joined" value="<?php echo Cls::escape($user->data()->joined); ?>" readonly>
			</div>

			<div class="field">
				<!-- <input type="submit" value="Update"> -->
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<a href="<?php echo Config::get('web/dir') . 'admin/index.php' ?>">Back</a>
			</div>
		</div>
	</form>

<?php HTML::adminFooter(); ?>