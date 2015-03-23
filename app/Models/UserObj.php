<?php
class UserObj {
	private $_db, $_data, $_sessionName, $_cookieName, $_isLoggedIn;

	public function __construct($user = null) {
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie_name');

		if(!$user) {
			if(Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				
				if($this->find($user)) {
					$this->_isLoggedIn = true;
				} 
			}

		// if user does not have session define it.
		} else {
			$this->find($user);
		}
	}

	// Register User
	public function create($field = array()) {
		if(!$this->_db->insert('users', $field)) {
			throw new Exception('There was a problem creating an account.');
		}
		$sql = "INSERT INTO articles ()";
//		$this->_db->query();
	}

	public function update($fields = array(), $id = null) {
		
		// Check is update has no id, it will get current user logged in id,
		// Chech is update has an id, it will update with specific id
		if(!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if(!$this->_db->update('users', $id, $fields)) {
			throw new Exception('There was a problem updating an account information.');
		}
	}

	public function find($user = null) {
		if($user) {
			$field = (is_numeric($user)) ? 'id' : 'username';
			$data = $this->_db->get('users', array($field, '=', $user));

			if($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function login($username = null, $password = null, $remember = false) {
		// if login has no username and password this will set the session for user
		if(!$username && !$password && $this->exists()) {
			Session::set($this->_sessionName, $this->data()->id);
		} else {
			$user = $this->find($username);
			if($user) {
				if($this->data()->password === Hash::make($password, $this->data()->salt)) {
				// if($this->data()->password == $password){
					Session::set($this->_sessionName, $this->data()->id);

					if($remember) {

						$hash = Hash::unique();
						$hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));

						if(!$hashCheck->count()) {
							$this->_db->insert('users_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						} else {
							$hash = $hashCheck->first()->hash;
						}

						Cookie::set($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
					} 

					return true;
				}
			}
		}

		return false;
	}

	public function hasPermission($key) {
		$group = $this->_db->get('groups', array('id', '=', $this->data()->group));

		if($group->count()) {
			// Convert this json object to array object
			$permission = json_decode($group->first()->permission, true);
			if($permission[$key] == true) {
				return true;
			}
			return false;
		}
	}

	public function listAll($status = null, $keyword = null, $limits = null, $orders = null){
		$sql = "SELECT * FROM `users`";
		$key = "%{$keyword}%";

		if (count($status)){

			if ($status == 0){
				$sql .= " WHERE status = '0' AND (username LIKE ? OR firstname LIKE ? OR lastname LIKE ?)";
			} else if ($status == 1){
				$sql .= " WHERE status = '1' AND (username LIKE ? OR firstname LIKE ? OR lastname LIKE ?)";
			} else {
				$sql .= " WHERE (username LIKE ? OR firstname LIKE ? OR lastname LIKE ?)";
			}

			$val = array($key, $key, $key);
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

		// echo $sql, "<br/>";
		return $this->_db->doQuery($sql, $val);
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}

	// public function data() {
	// 	return $this->_data;
	// }

	public function datas(){
		return $this->datas();
	}

	public function data($index = 0){
		if (is_numeric($index)) {
			return $this->_db->datas()[$index];
		} else {
			return $this->_db->datas()[0];
		}
	}

	public function count() {
		return $this->_db->count();
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}

	public function logout() {
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}
}
?>