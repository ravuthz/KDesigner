<?php
class Cookie {
	public static function exists($name) {
		return (isset($_COOKIE[$name])) ? true : false;
	}

	public static function get($name) {
		return $_COOKIE[$name];
	}

	public static function set($name, $value, $expiry) {
		// $expiry is section 
		// (3600s * 24) = 86400 = 1day

		if(setcookie($name, $value, time() + $expiry, '/')) {
			return true;
		}
		return false;
	}

	public static function delete($name) {
		self::set($name, '', time() - 1);
	}
}
?>