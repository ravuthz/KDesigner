<?php

class Home extends Controller {

	public function __construct() {
		$user = $this->model('UserObj');
		$video = $this->model('VideoObj');
		$article = $this->model('ArticleObj');
		$category = $this->model('CategoryObj');
		$view = $this->model('ViewObj');
	}

	public function index($ln = null, $id = null){
		$this->view('home/index', array('ln'=>$ln, 'id'=> $id));
	}

//	public function article($ln = null, $id = null) {
//		$this->view('home/article', array('ln'=>$ln, 'id'=> $id));
//	}

    public function article($id = null){
        $this->view('home/article', array('id'=> $id));
    }
}

?>

