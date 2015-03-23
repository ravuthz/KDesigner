<?php
class CategoryObj {
	private $_db, 
			$_data;

	private $_tbl = 'category',
			$_id = 'id';
	
	public function __construct($post = null) {
		$this->_db = DB::getInstance();
	}

	public function insert($field = array()) {
		if(!$this->_db->insert($this->_tbl, $field)) {
			throw new Exception('There was a problem creating an {$this->_tbl}.');
		}
	}

	public function update($fields = array(), $id = null) {
		if(!$this->_db->update($this->_tbl, $id, $fields)) {
			throw new Exception('There was a problem updating an {$this->_tbl}.');
		}
	}

	public function delete($id) {
		if(!$this->_db->delete($this->_tbl, array($this->_id,'=',$id))) {
			throw new Exception('There was a problem deleting an {$this->_tbl}.');
		}
	}

	public function detail($id) {
		$sql = "SELECT * FROM categories WHERE id = ?";
		return $this->_db->action2($sql, array($id));
	}

	public function listAll($status = null){
		if (is_numeric($status)){
			$sql = "SELECT * FROM categories WHERE status='{$status}'";
		} else {
			$sql = "SELECT * FROM categories";
		}
		return $this->_db->doQuery($sql, array());
	}
	
	public function datas() {
		return $this->_db->results();
	}

	public function data($index = 0) {
		if (is_numeric($index)) {
			return $this->_db->results()[$index];
		} else {
			return $this->_db->results()[0];
		}
	}

	public function count() {
		return $this->_db->count();
	}
}
?>