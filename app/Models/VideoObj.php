<?php
class VideoObj {
	private $_db, 
			$_data, 
			$_title;

	private $_id = 'id', $_tbl = 'videos';

	public function __construct($post = null) {
		$this->_db = DB::getInstance();
		$this->_title = substr($this->_tbl, 0, -1);
	}

	public function insert($field = array()) {
		if(!$this->_db->insert($this->_tbl, $field)) {
			throw new Exception("There was a problem creating an " . $this->_title . " .");
		}
	}

	public function update($fields = array(), $id = null) {
		if(!$this->_db->update($this->_tbl, $id, $fields)) {
			throw new Exception("There was a problem updating an " . $this->_title . " .");
		}
	}

	public function delete($id) {
		if(!$this->_db->delete($this->_tbl, array($this->_id,'=',$id))) {
			throw new Exception("There was a problem deleting an " . $this->_title . " .");
		}
	}

	public function detail($id) {
        if(!$this->_db->detail($this->_tbl, $id)) {
            throw new Exception("There was a problem detailing an " . $this->_title . " .");
        }
	}

    public function listAll($status = null, $keyword = null, $limits = null, $orders = null){
        $sql = "SELECT v.*, (SELECT u.username FROM users u WHERE u.id=v.addBy) AS byUser FROM videos v WHERE wasDelete = 0";

        $val = array();

        if (count($status)){

            if ($status == 0){
                $sql .= " AND status = '0' AND title LIKE ?";
            } else if ($status == 1){
                $sql .= " AND status = '1' AND title LIKE ?";
            } else {
                $sql .= " AND title LIKE ?";
            }
            $val = array("%{$keyword}%");
        }

        if (count($orders)){
            $column = $orders[0];
            $order = $orders[1];
            $sql .= " order by " . $column . " " . $order;
        }

        if (count($limits)){
            $start = $limits[0];
            $total = $limits[1];
            $sql .= " limit " . $start . "," . $total;
        }

        return $this->_db->doQuery($sql, $val);
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