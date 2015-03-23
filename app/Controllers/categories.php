<?php

class Categories extends Controller{

	public function __construct() {
		$user = $this->model('UserObj');
		$article = $this->model('ArticleObj');
		$category = $this->model('CategoryObj');
	}

	public function index($p1 = '', $p2 = '', $p3 = '', $p4 = ''){
		$this->view('category/index', array('p1' => $p1, 'p2' => $p2, 'p3' => $p3, 'p4' => $p4));
	}

	public function insert($id = '') {
		$this->view('category/insert', array('id' => ''));
	}

	public function delete($id = '', $confirm = '') {
		$this->view('category/delete', array('id' => $id, 'confirm' => $confirm));
	}

	public function update($id = '') {
		$this->view('category/update', array('id' => $id));
	}

	public function detail($id = '') {
		$this->view('category/detail', array('id' => $id));
	}

}

?>