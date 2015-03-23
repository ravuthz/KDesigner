<?php

class Comments extends Controller {

	public function __construct() {
		$user = $this->model('UserObj');
		$article = $this->model('ArticleObj');
		$category = $this->model('CategoryObj');
	}

	public function index($ln = '', $p2 = '', $p3 = '', $p4 = ''){
		$this->view('comment/index', array('ln' => $ln, 'p2' => $p2, 'p3' => $p3, 'p4' => $p4));
	}

	public function insert(){
		$this->view('comment/insert', array());
	}
}

?>