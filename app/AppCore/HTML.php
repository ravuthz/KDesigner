<?php

class HTML {

	public static function adminHeader() {
		$language = new Language();
    	$lang =  $language->getLang();

		$dir = Cls::escape(Config::get('web/dir'));
        $pub = Cls::escape(Config::get('web/pub'));
		$user = new UserObj();
		$user_id = Cls::escape($user->data()->id);
		$user_name = Cls::escape($user->data()->username);
		echo "
		<!DOCTYPE html>
		<html lang='en'>
			<head>
				<meta charset='utf-8' content='text/html'>
				<title>{$lang['page_title']}</title>
				<link rel='stylesheet' href='{$pub}style/admin.css'/>
			    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
				<script type='text/javascript' src='{$pub}script/functions.js'></script>
				<script type='text/javascript' src='{$pub}script/main.js'></script>
			</head>
			<body>
				<header>
			            <a href='{$dir}admin/index'><span id='dash-logo'>Logo</span><span id='logo'>{$lang['lbl_dashboard']}</span></a>

			            <div class='user-wrap'>
			                <ul class='no-js'>
			                    <li>
			                        <a href='#' class='user'>Profile</a>
			                        <ul id='list-display'>
			                            <li>
			                            	<a href='{$dir}admin/view_profile/{$user_id}' class='username-click'>
			                            		{$user_name}
			                            	</a>
			                            </li>
			                            <li><a href='{$dir}admin/change_password'>{$lang['lbl_change_password']}</a></li>
			                            <li><a href='{$dir}admin/logout'>{$lang['lbl_logout']}</a></li>
			                        </ul>
			                    </li>
							</ul>
			            </div><!--end of user-->
			    </header>

			    <aside>
		            <div class='sec one'>
		                <ul class='nav'>
		                    <li><a href='{$dir}articles/index'><span class='nav-ico'>Logo</span>{$lang['menu_articles']}</a></li>
		                    <li><a href='{$dir}videos/index'><span class='nav-ico vid'>Logo</span>{$lang['menu_videos']}</a></li>
		                </ul>
		            </div><!--end of section one-->
		            <div class='sec two'>
		                <ul class='nav'>
		                    <li><a href='{$dir}categories/'><span class='nav-ico cate'>Logo</span>{$lang['menu_categories']}</a></li>
		                    <li><a href='{$dir}banners/'><span class='nav-ico ban'>Logo</span>{$lang['menu_banners']}</a></li>
		                </ul>
		            </div><!--end of section two-->
		            <div class='sec three'>
		                <ul class='nav'>
		                    <li><a href='{$dir}comments/'><span class='nav-ico cmt'>Logo</span>{$lang['menu_comments']}</a></li>
		                    <li><a href='{$dir}users/'><span class='nav-ico users'>Logo</span>{$lang['menu_users']}</a></li>
		                    <li><a href='{$dir}settings/'><span class='nav-ico set'>Logo</span>{$lang['menu_settings']}</a></li>
		                </ul>
		            </div><!--end of section three-->
			    </aside><!--left navigator-->

			    <section>
		";
	}

	public static function adminFooter() {
		Cls::printMemory();
		echo "	</section><!--whole body-->
				<footer></footer>
			</body>
		</html>
		";
	}

	public static function tag($tag, $str, $classes = array()) {
		if (count($classes) == 2){
			$atb = $classes[0];
			$val = $classes[1];
			echo "<{$tag} {$atb}={$val}>{$str}</{$tag}>";
		}else{
			echo "<{$tag}>{$str}</{$tag}>";
		}
	}

	public static function show($obj){
		echo "<hr/><pre>";
		print_r($obj);
		echo "</pre><hr/>";
	}

	public static function detail($obj){
		echo "<hr/><pre>";
		var_dump($obj);
		echo "</pre><hr/>";
	}

	private static function getAction($obj){
		$class = get_class($obj);
		$name = substr($class, 0, strlen($class)-3);

        if ($action = Input::get("action")){
            if($action['name'] == "delete"){
                $obj->delete($action['id']);
                HTML::setAlert("delete", "This $name " . $action[id] .  " was deleted successfully.");
            }
            if($action['name'] == "update"){
                $status = $action['status'] == 1 ? 0 : 1;
                $obj->update(array('status' => $status), $action['id']);
            }
        }

        HTML::getAlert("insert");
        HTML::getAlert("update");
        HTML::getAlert("delete");

        if (Input::get("deleteSession")){
        	Session::delete(Input::get("deleteSession"));
        }
	}

    public static function categoryTable(){
        $video = new ArticleObj();
        $page = null;

        self::getAction($video);

        if ($input = Input::get("input")){
            $page = new Pagination($input['rows'], $video->listAll($input['list'])->count());
            $video->listAll(
                $input['list'],
                $input['key'],
                [($input['rows']*($page->currentPage()-1)), $input['rows']],
                [$input['sort'], $input['order']]
            )->datas();
        } else {
            $page = new Pagination(5, $video->listAll(2)->count());
            $video->listAll("2", "", [0,5], ["id","asc"])->datas();
        }

        echo "
                    <div class='table-wrapper'>
                        <table class='video'>
                            <tr>
                                <th><input type='checkbox' id='selectAll'></th>
                                <th>No</th>
                                <th>Title</th>
                                <th>Added By</th>
                                <th>Added On</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>";

        for($i=0; $i<$video->count(); $i++) {
            $id = $video->data($i)->id;
            $title = Cls::maxString($video->data($i)->title, 50);
            $author = Cls::maxString($video->data($i)->addByUser, 18);
            $date = Cls::getDate($video->data($i)->addOn);
            $status = $video->data($i)->status;

            $detailUrl = Config::get('web/dir') . "Videos/detail/" . $id;
            $updateUrl = Config::get('web/dir') . "Videos/update/" . $id;
            $deleteUrl = "javascript: deleteId(" . $id . ")";
            $changeStUrl = "javascript: changeStatus(" . $id . ", " . $status . ")";
            $publsh = ($status == 1) ? "on-off-btn on" : "on-off-btn";

            echo "
                <tr>
                    <td>
                        <input type='checkbox' id='{$id}'>
                    </td>
                    <td>
                        {$id}
                    </td>
                    <td>
                        <a href='{$detailUrl}'>
                            {$title}
                        </a>
                    </td>
                    <td id='author-col'>
                        {$author}
                    </td>
                    <td id='pbl-date'>
                        {$date}
                    </td>
                    <td id='status-col'>
                        <a id='status' class='{$publsh}' href='{$changeStUrl}'>
                            status
                        </a>
                    </td>
                    <td>
                        <ul class='edit-delete-btn'>
                            <li><a id='edit-opr' href='{$updateUrl}'></a></li>
                            <li><a id='del-opr' href='{$deleteUrl}'></a></li>
                        </ul>
                    </td>
                </tr>";

        }
            echo "
                    </table>
                </div>";
            $page->display();

    }

	public static function articleTable($default = array()){
		$article = new ArticleObj();
        $page = null;

        self::getAction($article);

        if ($input = Input::get("input")){
            $page = new Pagination($input['rows'], $article->listAll($input['list'])->count());
            $article->listAll(
                $input['list'],
                $input['key'],
                [($input['rows']*($page->currentPage()-1)), $input['rows']],
                [$input['sort'], $input['order']]
            )->datas();
        } else {
            $page = new Pagination(5, $article->listAll(2)->count());
            $article->listAll("2", "", [0,5], ["id","asc"])->datas();
        }

		echo "
			<div class='table-wrapper'>
	            <table class='article'>
		            <tr>
		                <th><input type='checkbox' id='selectAll'></th>
		                <th>No</th>
		                <th>Article</th>
		                <th>Added By</th>
		                <th>Added On</th>
		                <th>Status</th>
		                <th>Option</th>
		            </tr>";

       	for($i=0; $i<$article->count(); $i++) {
        	$id = $article->data($i)->id;
        	$title = Cls::maxString($article->data($i)->title, 50);
        	$author = Cls::maxString($article->data($i)->addByUser, 18);
        	$date = Cls::getDate($article->data($i)->addOn);
        	$status = $article->data($i)->status;

        	$detailUrl = Config::get('web/dir') . "articles/detail/" . $id;
        	$updateUrl = Config::get('web/dir') . "articles/update/" . $id;
        	$deleteUrl = "javascript: deleteId(" . $id . ")";
        	$changeStUrl = "javascript: changeStatus(" . $id . ", " . $status . ")";
        	$publsh = ($status == 1) ? "on-off-btn on" : "on-off-btn";

        echo "
		            <tr>
		                <td>
		                	<input type='checkbox' id='{$id}'>
		                </td>
		                <td>
		                    {$id}
		                </td>
		                <td>
		                	<a href='{$detailUrl}'>
		                        {$title}
		                    </a>
		                </td>
		                <td id='author-col'>
		                    {$author}
		                </td>
		                <td id='pbl-date'>
		                    {$date}
		                </td>
		                <td id='status-col'>
		                	<a id='status' class='{$publsh}' href='{$changeStUrl}'>
		                		status
		                	</a>
		                </td>
		                <td>
		                    <ul class='edit-delete-btn'>
		                        <li><a id='edit-opr' href='{$updateUrl}'></a></li>
		                        <li><a id='del-opr' href='{$deleteUrl}'></a></li>
		                    </ul>
		                </td>
		            </tr>";
       	}

        echo "
        		</table><!--end of table-->
        	</div><!--end of table wrapper-->";
        $page->display();
	}

	public static function userTable(){
        $user = new UserObj();
        $page = null;

        self::getAction($user);

        if ($input = Input::get("input")){
            $page = new Pagination($input['rows'], $user->listAll($input['list'])->count());
            $user->listAll(
                $input['list'],
                $input['key'],
                [($input['rows']*($page->currentPage()-1)), $input['rows']],
                [$input['sort'], $input['order']]
            )->datas();
        } else {
            $page = new Pagination(5, $user->listAll(2)->count());
            $user->listAll("2", "", [0,5], ["id","asc"])->datas();
        }

		echo "
			<div class='table-wrapper'>
	            <table class='article'>
		            <tr>
		                <th><input type='checkbox' id='selectAll'></th>
		                <th>No</th>
		                <th>User</th>
		                <th>Name</th>
		                <th>Added On</th>
		                <th>Status</th>
		                <th>Option</th>
		            </tr>";

       	for($i=0; $i<$user->count(); $i++) {
        	$id = $user->data($i)->id;
        	$username = Cls::maxString($user->data($i)->username, 50);
        	$fullname = $user->data($i)->firstname . " " . $user->data($i)->lastname;
        	$date = Cls::getDate($user->data($i)->joined);
        	$status = $user->data($i)->status;

        	$detailUrl = Config::get('web/dir') . "users/detail/" . $id;
        	$updateUrl = Config::get('web/dir') . "users/update/" . $id;
        	$deleteUrl = "javascript: deleteId(" . $id . ")";
        	$changeStUrl = "javascript: changeStatus(" . $id . ", " . $status . ")";
        	$publsh = ($status == 1) ? "on-off-btn on" : "on-off-btn";

        echo "
		            <tr>
		                <td>
		                	<input type='checkbox' id='{$id}'>
		                </td>
		                <td>
		                    {$id}
		                </td>
		                <td>
		                	<a href='{$detailUrl}'>
		                        {$username}
		                    </a>
		                </td>
		                <td>
		                	{$fullname}
		                </td>
		                <td id='pbl-date'>
		                    {$date}
		                </td>
		                <td id='status-col'>
		                	<a id='status' class='{$publsh}' href='{$changeStUrl}'>
		                		status
		                	</a>
		                </td>
		                <td>
		                    <ul class='edit-delete-btn'>
		                        <li><a id='edit-opr' href='{$updateUrl}'></a></li>
		                        <li><a id='del-opr' href='{$deleteUrl}'></a></li>
		                    </ul>
		                </td>
		            </tr>";
       	}

        echo "
        		</table><!--end of table-->
        	</div><!--end of table wrapper-->";

        $page->display();
	}

	public static function table($cols, $rows, $attribute = []){

		echo "<div class='table-wrapper'>";
		if ($attribute){
			echo "<table ";
			foreach ($attribute as $key => $value) {
				echo "'{$key}'={$value}";
			}
			echo "><tr>";
		} else {
			echo "
			<div class='table-wrapper'>
			<table class='tbl'>
			<tr>";
		}

		foreach ($cols as $key => $value) {
			echo "<td>{$value}</td>";
		}

		echo "</tr>";
		for($i=0; $i<count($rows); $i++){
			echo "<tr>";
			foreach ($rows[$i] as $key => $value) {
				echo "<td>{$value}</td>";
			}
			echo "</tr>";
		}

		echo "
			</tr>
			</table><!--end of table-->
			</div><!--end of table wrapper-->";
	}

	public static function clear(){
		echo "<div class='clear'></div>";
	}

	public static function setAlert($name, $msg , $type = 's'){
		switch ($type) {
    		case 's':
    		case 'success':
    			$type = "success";
    			break;

    		case 'w':
    		case 'warning':
    			$type = "warning";
    			break;

    		case 'f':
    		case 'failure':
    			$type = "failure";
    			break;
    	}
		$str =
		"<div id='alertbar'>
			<p class='{$type}'>{$msg}<span onclick='closeButton(\"{$name}\")'>x</span></p>
		</div>
		";

    	Session::set($name, $str);
    }

    public static function getAlert($name){
		echo Session::get($name);
    }

    public static function select($id, $name, $values){
    	echo "
    	<span>
            <label>{$name}</label>
                <select id='{$id}' class='select'>";

    	foreach ($values as $key => $value) {
    		echo "<option value='{$key}'>{$value}</option>";
    	}
        echo "	</select>
        </span>
    	";
    }

    public static function input($data){
    	echo "<input ";
    	foreach ($data as $key => $value) {
    		echo " {$key}='{$value}'";
    	}
    	echo "/>";
    }

    public static function boxes($datas){
	    echo "<h2>Stats View</h2><ul class='boxes'>";
	    foreach ($datas as $key => $data) {
	    	$class = strtolower($data['title']);
	    	echo "
	    	<a href='{$data['link']}'>
	    	<li>
                <span class='title {$class}'>{$data['title']}</span>
                <div class='{$class}'>
                    <div class='notification'>{$data['count']}</div>
                    <span class='icon {$class}'>
                       $class
                    </span><!--end of {$data['title']} icon-->
                </div><!--end of allcounts {$data['title']}-->
            </li>
            </a>
	    	";
	    }
	    echo "</ul>";
    }

    /* *********************************** *
     *	From these down are for home page  *
     ************************************* */

    public static function homeHeader() {
		$language = new Language();
    	$lang =  $language->getLang();

		$dir = Cls::escape(Config::get('web/dir'));
        $pub = Cls::escape(Config::get('web/pub'));

		echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='utf-8' content='text/html'>
            <title>{$lang['page_title']}</title>
            <link rel='stylesheet' href='{$pub}style/home.css'/>
            <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
            <script type='text/javascript' src='{$pub}script/main.js'></script>
        </head>
        <body>

        <header>
            <div id='head-container'>
                <div id='logo-bar'>
                    <a href='{$dir}admin/index'>KhmerDesigner</a>
                </div>
                <div id='search-icon-bar'>
                    <a href='#'>Search</a>
                </div>
                <nav id='menu-bar'>
                    <ul id='menu'>
                        <li><a href='#'>Home</a></li>
                        <li><a href='#'>News</a></li>
                        <li><a href='#'>Inspiration</a></li>
                        <li><a href='#'>How-To</a></li>
                        <li><a href='#'>Freebies</a></li>
                        <li><a href='#'>Videos</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div id='main-container'>
		";
	}

	public static function homeFooter() {
        echo "
                    <footer>
                        <div id='foot-container'>
                            <div id='copyright'>
                                KHMERDESIGNER &copy; 2014 ALL RIGHTS RESERVED.
                            </div>
                            <div id='social'>
                                <ul>
                                    <li><a href='#' id='facebook'>Facebook</a></li>
                                    <li><a href='#' id='twitter'>Twitter</a></li>
                                </ul>
                            </div>
                        </div>
                    </footer>
        		</div>
			</body>
		</html>
		";
	}

    public static function post($post = null){
//        <img src=\"{$post->thumbnail}\">
    	if (count($post)){
    		echo "
	        <article><!--Start of Each Single Post wrap-->
	        	<img src='". Config::get('web/pub') ."images/posts/post-thumbnail.png'>
	        	<div class='post-desc'>
	                <div class='gen-post-title'>
	                    \"{$post->title}\"
	                </div><!--end of General Post Title-->
	                <div class='gen-post-author'>
	                    by <span class='author'>\"{$post->addBy}\"</span>
	                </div><!--end of General Post Author-->
	            </div><!--end of post description-->
	        </article><!--end of Each Single Post wrap-->
	    	";
    	}
    }

    public static function category($category, $posts){
    	$title = strtolower($category);
    	$cmt_tt = ucfirst($title);
    	echo "
    	<!--$cmt_tt Section-->
    	<section class='$title'>
            <header>
                <h3>$title</h3>
                <a href='#' class='view-more dark'>View More</a>
            </header><!--end of section header wrap-->
                
            <div class='post-row'>
        ";
      
        foreach ($posts as $key => $value) {
        	HTML::post($value);
        }

    	echo "
                <div class='clear'></div>
            </div>
        </section>
    	";
    }

    public static function latePost($posts){
    	
    	echo "
    	<div id='late-post-right'>
            <div id='lp-lists-wrap'>
                <ul id='lp-item'>
        ";

        foreach ($posts as $post) {
	        echo "
                    <a href='#'>
                        <li>
                            <div class='list-post-title'>
                                $post->title
                            </div>
                            <span class='post-author list'>
                            <span class='author'>by $post->addBy</span>
                            </span>
                            <span class='post-cate list'>
                                <span class='category'>$post->catId</span>
                            </span>
                        </li>
                    </a>
	    	";               
        }   

    	echo "
                </ul>
            </div>
        </div>
    	";
    }

    public static function popPost($posts, $max){
        if ($posts){
            echo "
            <table id='pop-post-table' cellspacing='0' cellpadding='0' border='0'>
                <tr>
                    <th colspan='2'>
                        <span id='pp-icon'>Icon</span>
                        <span id='pp-head-title'>Popular Posts</span>
                    </th>
                </tr>
            ";

            $max = $max > count($posts) ? count($posts) : $max;

            for($i=0; $i<$max; $i=$i+2){
                echo "
				<tr>
		            <td>
		                <a href='#'>
		                <span class='pp-rank'>" . ($i+1) . "</span>
		                <div class='pp-post-desc-wrap'>
		                    <div class='post-title pp'>
		                    	{$posts->data($i)->title}
		                    </div>
		                    <div class='pp-author-wrap'>by <span class='author pp'>{$posts->data($i)->addBy}</span></div>
		                    <div class='pp-proof'>
		                        <ul class='proof-item'>
		                            <li>
		                                <span class='pitem-ico'>View</span>
		                                <span class='p-count view'>1200</span>
		                            </li>
		                            <li>
		                                <span class='pitem-ico share'>Share</span>
		                                <span class='p-count share'>1200</span>
		                            </li>
		                            <li>
		                                <span class='pitem-ico like'>Like</span>
		                                <span class='p-count like'>1000</span>
		                            </li>
		                            <li>
		                                <span class='pitem-ico date'>Date</span>
		                                <span class='p-count date'>{$posts->data($i)->addOn}</span>
		                            </li>
		                        </ul>
		                    </div><!--end of popular post proof-->
		                </div><!--end of popular post description wrap-->
		                </div>
		                </a>
		            </td>
		            <td>
		                <a href='#'>
		                <span class='pp-rank'>" . ($i+2) . "</span>
		                <div class='pp-post-desc-wrap'>
		                    <div class='post-title pp'>
		                    	{$posts->data($i+1)->title}
		                    </div>
		                    <div class='pp-author-wrap'>by <span class='author pp'>{$posts->data($i+1)->addBy}</span></div>
		                    <div class='pp-proof'>
		                        <ul class='proof-item'>
		                            <!--pitem-ico = Proof Item Icon-->
		                            <li>
		                                <span class='pitem-ico'>View</span>
		                                <span class='p-count view'>1200</span>
		                            </li>
		                            <li>
		                                <span class='pitem-ico share'>Share</span>
		                                <span class='p-count share'>1200</span>
		                            </li>
		                            <li>
		                                <span class='pitem-ico like'>Like</span>
		                                <span class='p-count like'>1000</span>
		                            </li>
		                            <li>
		                                <span class='pitem-ico date'>Date</span>
		                                <span class='p-count date'>{$posts->data($i)->addOn}</span>
		                            </li>
		                        </ul>
		                    </div><!--end of popular post proof-->
		                </div><!--end of popular post description wrap-->
		                </div>
		                </a>
		            </td>
	        	</tr>
			";
            }
            echo "</table>";
        } else {
            echo "No PopPost";
        }
    }

    public static function highLightPost($post = null){
    	if (!empty($post)){
    		echo "
            <div id='highlight-post'>
                <a href='#'>
                <img src='images/post-highlight.png'>
                <div id='hl-post-title'>
                    \"{$post->title}\"
                </div>
                <div id='hl-post-desc'>
                    <span class='post-author'>
                        <span class='author'>by \"{$post->addBy}\"</span>
                    </span>

                    <span class='post-cate'>
                        <span class='category'>\"{$post->catId}\"</span>
                    </span>
                </div>
                </a>
            </div>
		    ";
    	}
    }
}

?>


