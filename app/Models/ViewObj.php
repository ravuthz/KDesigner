<?php
class ViewObj {
	private $_db, 
			$_data;

	private $_id = 'id', $_tbl = 'page_views', $_title = 'view count';

	public function __construct($post = null) {
		$this->_db = DB::getInstance();
	}

	public function exists($macAddress){
		return $this->_db->get($this->_tbl, array("mac_address","=", $macAddress));
	}

	public function insert($field = array()) {
		if(!$this->_db->insert($this->_tbl, $field)) {
			throw new Exception('There was a problem creating an $this->_title.');
		}
	}

	public function update($fields = array(), $id = null) {
		if(!$this->_db->update($this->_tbl, $id, $fields)) {
			throw new Exception('There was a problem updating an $this->_title.');
		}
	}

	public function delete($id) {
		if(!$this->_db->delete($this->_tbl, array($this->_id,'=',$id))) {
			throw new Exception('There was a problem deleting an $this->_title.');
		}
	}

	public function detail($id) {
		$sql = "SELECT * FROM $this->_tbl WHERE id = ?";
		return $this->_db->action2($sql, array($id));
	}

	public function listAll(){
		return $this->_db->get($this->_tbl, array("id",">", "0"));
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