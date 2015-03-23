<?php

class Language {

    private $_language;
    public $lang = array();

    public function __construct(){
        // $this->_language = $this->checkLang($_COOKIE['lang']);
        // $this->_language = $_COOKIE['lang'];
        $this->_language = $this->getDefault();
    }

    public function getLang(){
        switch($this->_language){
            case "kh":
                $lang = $this->readINI("kh");
                return $lang;

            default:
                $lang = $this->readINI("en");
                return $lang;
        }
    }

    public function getCurrentLang() {
    	return $this->language;
    }

    public function checkLang($language) {
        header('Cache-control: private'); // IE 6 FIX

        if ($language) {
            $_SESSION['lang'] = $language;
            setcookie('lang', $language, time() + (3600 * 24 * 30));
        } else if (isset($_SESSION['lang'])){
            $language = $_SESSION['lang'];
        } else if (isset($_COOKIE['lang'])){
            $language = $_COOKIE['lang'];
        } else {
            $language = 'en';
        }
        return $language;
    }

    public function readINI($filename) {
		$path = 'app/AppCore/language/';
		$file = $path . $filename . '.ini';
	    if(!file_exists($file)) {
	        return array(
	        	'error'=>'Can not read file ' . $filename . '.ini',
	        	'file'=>$filename,
	        	'path'=>$path
	        );
	    }
	    return parse_ini_file($file, true);
	}

    public function getDefault() {
        if (isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]))
            return $this->parseDefault($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        else
            return $this->parseDefault(NULL);
    }


    public function parseDefault($http_accept, $deflang = "en") {
        if(isset($http_accept) && strlen($http_accept) > 1)  {
            # Split possible languages into array
            $x = explode(",",$http_accept);
            foreach ($x as $val) {
                #check for q-value and create associative array. No q-value means 1 by rule
                if(preg_match("/(.*);q=([0-1]{0,1}.d{0,4})/i",$val,$matches))
                    $lang[$matches[1]] = (float)$matches[2];
                else
                    $lang[$val] = 1.0;
                }

            #return default language (highest q-value)
            $qval = 0.0;
            foreach ($lang as $key => $value) {
                if ($value > $qval) {
                    $qval = (float)$value;
                    $deflang = $key;
                }
            }
        }
        return strtolower($deflang);
    }
}