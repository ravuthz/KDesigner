<?php

class Articles extends Controller {

	public function __construct() {
		$user = $this->model('UserObj');
		$article = $this->model('ArticleObj');
		$category = $this->model('CategoryObj');
	}

	public function index($ln = '', $p2 = '', $p3 = '', $p4 = ''){
		$this->view('article/index', array('ln' => $ln, 'p2' => $p2, 'p3' => $p3, 'p4' => $p4));
	}

	public function insert($id = '') {
		$this->view('article/insert', array('id' => ''));
	}

	public function delete($id = '', $confirm = '') {
		$this->view('article/delete', array('id' => $id, 'confirm' => $confirm));
	}

	public function update($id = '') {
		$this->view('article/update', array('id' => $id));
	}

	public function detail($id = '') {
		$this->view('article/detail', array('id' => $id));
	}

}

?>