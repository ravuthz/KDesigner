<?php
class Cls {

	public static function escape($string){
		return htmlentities($string, ENT_QUOTES, 'UTF-8');
	}

	public static function checkLogin() {
		$user = new UserObj();
		if(!$user->isLoggedIn()) {
			Redirect::to(Config::get('web/dir') . 'admin/login');
		}
	}

	public function console($data) {
	    if(is_array($data) || is_object($data)) {
			echo("<script>console.log('" . json_encode($data) . "');</script>");
		} else {
			echo("<script>console.log('" . $data . "');</script>");
		}
	}

	public function maxString($str, $len) {
		if (strlen($str) > $len) {
			return substr($str, 0, $len - 3) . "...";
		} else {
			return $str;
		}
	}

	public static function write($filename, $value, $path = null) {
		if ($path){
			$filename = $path . $filename;
		}

		file_put_contents($filename.'.json', json_encode($value));
	}

	public static function read($filename, $path = null) {
		if ($path){
			$filename = $path . $filename;
		}

		return json_decode(file_get_contents($filename.'.json'));
	}

	public static function readINI($filename, $path = null) {
		$file = $filename . '.ini';
		if ($path) {
			$file = $path . $filename . '.ini';
		}
		
	    if(!file_exists($file)) {
	        return array(
	        	'error'=>'Can not read file ' . $filename . '.ini',
	        	'file'=>$filename,
	        	'path'=>$path
	        );
	    }
	    return parse_ini_file($file, true);
	}

	/* 
		This method is convert from datetime to timestamp
		then print date with the format [Day Month Year Hour Minute Second AM/PM]
	 */
	public static function printDate($date) {
		echo date('d-m-Y h:i:s A',strtotime($date));
		// echo date('d-m-Y h:i a',strtotime($date));
	}

	public static function getDate($date){
		return date('d-m-Y h:i:s A',strtotime($date));
	}

	public static function setLog($text){
		// global $filename;
		$filename = "web_log.json";

		$error = "[" . date('d-m-Y h:i:s A') . "] : {$text}\n";

		// $error = array(date('d-m-Y h:i:s A') => $text);

		if ($f = fopen($filename, "a+")){
			fwrite($f, $text);
			fclose($f);
		}

	}

	public static function getLog(){
		$filename = "web_log";
		return Cls::write($filename);
	}

	public static function ipAddress(){
		return $_SERVER['REMOTE_ADDR'];
	}

	public static function macAddress(){
		// Turn on output buffering
	    ob_start();
	    //Get the ipconfig details using system commond
	    system('ipconfig /all');

	    // Capture the output into a variable
	    $mycom = ob_get_contents();
	    // Clean (erase) the output buffer
	    ob_clean();

	    $findme = "Physical";
	    //Search the "Physical" | Find the position of Physical text
	    $pmac = strpos($mycom, $findme);

	    // Get Physical Address
	    $macAddress=substr($mycom,($pmac+36),17);
	    //Display Mac Address
	    
	    return $macAddress;
	}

	public static function printMemory(){
		echo "<br/><b>Memory Usage : ", memory_get_usage(), " Bytes<b>";
	}

}

?>

