<?php

class Settings extends Controller {

	public function __construct() {
		$user = $this->model('UserObj');
		$article = $this->model('ArticleObj');
		$category = $this->model('CategoryObj');
	}

	public function index($ln = '', $p2 = '', $p3 = '', $p4 = ''){
		$this->view('setting/index', array('ln' => $ln, 'p2' => $p2, 'p3' => $p3, 'p4' => $p4));
	}
}

?>