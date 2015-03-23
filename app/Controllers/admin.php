<?php

class Admin extends Controller {

	public function __construct() {
		$user = $this->model('UserObj');
		$article = $this->model('ArticleObj');
		$category = $this->model('CategoryObj');
	}

	public function index($id = ''){
		$this->view('admin/index', array('id'=> ''));
	}

	public function login($id = '') {
		$this->view('admin/login', array('id'=> ''));
	}

	public function logout($id = '') {
		$this->view('admin/logout', array('id'=> ''));
	}

	public function update_profile($id = '') {
		$this->view('admin/update_profile', array('id'=> ''));
	}

	public function view_profile($id = '') {
		$this->view('admin/view_profile', array('id'=> ''));
	}

	public function register() {
		$this->view('admin/register', array('id'=> ''));
	}

	public function change_password() {
		$this->view('admin/change_password', array('id'=> ''));
	}
}

?>