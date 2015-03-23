<?php

$user = new UserObj();
$user->logout();
Redirect::to(Config::get('web/dir') . 'admin/login.php');

?>