<?php

class Log {
	private static $filename = "Check.txt";

	public static function set($txt){
		$time = time();
		$file = fopen(self::$filename, 'a');
		fwrite($file, $time . " - " . $txt . "\n");
		fclose($file);
		// file_put_contents(self::$filename, $txt . "\n", FILE_APPEND);
	}

	public static function get(){
		$file = fopen(self::$filename, 'r');
		$txt = fwrite($file, $txt);
		fclose($file);
		return $txt;
		// return file_get_contents(self::$filename);
	}

	public static function size(){
		return filesize(self::$filename);
	}
}

?>