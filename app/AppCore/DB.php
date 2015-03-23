<?php

class DB {
	private static $_instance = null;
	private $_pdo, $_query, $_error = false, $_datas, $_count = 0;

	private function __construct() {
		try {
			$this->_pdo = new PDO(
				'mysql:host=' . Config::get('mysql/host') .
				';dbname=' . Config::get('mysql/db'),
				Config::get('mysql/username'),
				Config::get('mysql/password')
			);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query($sql, $params = array()) {
		$this->_error = false;

		if($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if(count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}

			if($this->_query->execute()) {
				$this->_datas = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		return $this;
	}

	public function action($action, $table, $where = null, $values = array()) {
		$operators = array('=', '>', '<', '>=', '<=','like');

		if(count($where) === 3) {
			$field = $where[0];
			$opeorator = $where[1];
			$value = $where[2];

			if(in_array($opeorator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$opeorator} ?";
				if(!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		} else {
			$sql = "{$action} FROM {$table} WHERE {$where}";	
			if(!$this->query($sql, $values)->error()) {
				return $this;
			}
		}

		return false;
	}

	public function doQuery($sql, $val = array()) {
		if ($sql) {
			if(!$this->query($sql, $val)->error()) {
				return $this;
			}
		}
	}

	public function get($table, $where) {
		return $this->action('SELECT *', $table, $where);
	}

    public function detail($table, $where) {
        return $this->action('SELECT *', $table, $where);
    }

	public function delete($table, $where) {
		return $this->action('DELETE', $table, $where);
	}

	public function insert($table, $fields = array()) {
		if(count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$x = 1;
			foreach ($fields as $field) {
				$values .= '?';
				if($x < count($fields)) {
					$values .= ', ';
				}
				$x++;
			}

			// $sql = "INSERT INTO users (username, password, salt)";
			$sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

			if(!$this->query($sql, $fields)->error()) {
				return true;
			}
		}
		return false;
	}

	public function update($table, $id, $fields) {
		$set = '';
		$x = 1;
		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}

		// $sql = "UPDATE users SET password = 'new123' WHERE id = 3";
		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

		if(!$this->query($sql, $fields)->error()) {
			return true;
		}
		return false;
	}

	/* this is will return array objects */
	public function datas() {
		return $this->_datas;
	}
	
	public function data($index = 0){
		if (is_numeric($index)) {
			return $this->datas()[$index];
		} else {
			return $this->datas()[0];
		}
	}

	/* this is will return array objects at first [0] index */
	public function first() {
		return $this->datas()[0];
	}

	public function error() {
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}
}

?>