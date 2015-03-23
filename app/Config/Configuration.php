<?php

$filePath = __FILE__; // C:\xampp\htdocs\kdesigner\app\init.php
$webPath = dirname(dirname(__FILE__)); // C:\xampp\htdocs\kdesigner
$hostPath = dirname($webPath); // C:\xampp\htdocs
$dirName = substr($webPath, strlen($hostPath)+1); // kdesigner
$dir = 'http://' . $_SERVER['HTTP_HOST'] . "/" . $dirName . "/";

$fullPath = dirname(dirname(__DIR__));  //C:\xampp\htdocs\KDS
$parentPath = dirname($fullPath);       //C:\xampp\htdocs
$proName = substr($fullPath, strlen($parentPath)+1); //KDS

$protocol = null;
if(isset($_SERVER['HTTPS'])) {
    $protocol = "https://";
}
else {
    $protocol = "http://";
}

$dir = $protocol. $_SERVER['HTTP_HOST'] . "/" . $proName . "/";

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => '',
        'db' => 'mydata'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    ),
    'web' => array(
        'dir' => $dir,
        'pub' => $dir . 'public/',
        'title' => 'Khmer Designer',
        'tags' => 'khmer designer for cambodia',
        'icon' => $dir . 'images/profile.png'
    )
);

?>