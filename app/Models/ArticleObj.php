<?php
class ArticleObj {
	private $_db, $_data;

	private $_tbl = 'articles',
			$_id = 'id';
	
	public function __construct($post = null){
		$this->_db = DB::getInstance();
	}

	public function insert($field = array()){
		if(!$this->_db->insert($this->_tbl, $field)){
			throw new Exception('There was a problem creating an article.');
		}
	}

	public function update($fields = array(), $id = null){
		$user = new UserObj();
		$article = new ArticleObj();
		$old = $article->detail($id)->first();
	
		if (count($fields) > 1) {
			if(!$this->_db->insert('articlesupdated', array(
				'oldTitle' => $old->title,
				'oldContent' => $old->content,
				'oldFile' => $old->file,
				'updateBy' => $user->data()->id,
				'updateOn' => date('Y-m-d H:i:s'),
				'articleId' => $id
			))){
				throw new Exception('There was a problem deleting an article.');
			}
		}

		if(!$this->_db->update($this->_tbl, $id, $fields)){
			throw new Exception('There was a problem updating an article.');
		}
		
	}

	public function delete($id){		
		$user = new UserObj();
		if(!$this->_db->insert('articlesdeleted', array(
			'deleteBy' => $user->data()->id,
			'deleteOn' => date('Y-m-d H:i:s'),
			'articleId' => $id
		))){
			throw new Exception('There was a problem deleting an article.');
			// return "error delete";
		}
		$this->update(array('wasDelete' => 1), $id);
		return true;
	}

	public function detail($id){
		// return $this->_db->get($this->_tbl, array($this->_id,'=', $id));
		$sql = "SELECT a.*, (SELECT u.username FROM users u WHERE u.id=a.addBy) AS `byUser` FROM `articles` a WHERE wasDelete=0 AND id = ?";
		return $this->_db->doQuery($sql, array($id));
	}

    /***
     * @param null $status 0 1 2
     * @param null $keyword null or string
     * @param null $limits [start, total] => [0, 5]
     * @param null $orders [column, order] => ["id", "desc"]
     * @return $this
     */
	public function listAll($status = null, $keyword = null, $limits = null, $orders = null){
		$sql = "SELECT a.*, (SELECT u.username FROM users u WHERE u.id=a.addBy) AS `byUser` FROM `articles` a WHERE wasDelete=0";

		// SELECT * FROM `articles` WHERE wasDelete = '0' and status='1' and title like '%ra%' or addBy like '%ra%'
		
		$val = array();
		$key = "%{$keyword}%";

		if (count($status)){

			if ($status == 0){
				$sql .= " AND status = '0' AND (title LIKE ? OR addByUser LIKE ?)";
			} else if ($status == 1){
				$sql .= " AND status = '1' AND (title LIKE ? OR addByUser LIKE ?)";
			} else {
				$sql .= " AND (title LIKE ? OR addByUser LIKE ?)";
				// $sql .= " AND (title LIKE ? OR addBy = (SELECT u.id FROM users u WHERE u.username LIKE ?))";
			}

			$val = array($key, $key);
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

	public function listBy($category, $limit){
		$sql = "SELECT a.*, (SELECT u.username FROM users u WHERE u.id=a.addBy) AS `byUser` FROM `articles` a WHERE wasDelete=0 AND status =1";

		if ($category > 0){
			$sql .= " AND catId = {$category} order by id desc limit 0, {$limit}";
		} else {
			$sql .= " order by id desc limit 0, {$limit}";
		}
		
		// echo $sql, "<br/>";
		return $this->_db->doQuery($sql, []);
	}

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

	public function count(){
		return $this->_db->count();
	}
	

	public function advanceKey($key){
		if (stripos($key,'/date:') !== false){
			return substr($key,strlen('/date:'));

		} else if (strripos($key, '/title:') !== false){
			return substr($key,strlen('/title:'));

		} else if (strripos($key, '/author:') !== false){
			return substr($key,strlen('/author:'));
		}
		return $key;
	}

	public function advanceSearch(){

	}
}
?>