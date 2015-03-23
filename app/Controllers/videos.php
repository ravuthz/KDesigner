<?php

class Videos extends Controller {

	public function __construct() {
		$user = $this->model('UserObj');
		$video = $this->model('VideoObj');
		$article = $this->model('ArticleObj');
		$category = $this->model('CategoryObj');
	}

	public function index($ln = '', $p2 = '', $p3 = '', $p4 = ''){
		$this->view('video/index', array('ln' => $ln, 'p2' => $p2, 'p3' => $p3, 'p4' => $p4));
	}

	public function insert(){
		$this->view('video/insert', array());
	}
}

?>