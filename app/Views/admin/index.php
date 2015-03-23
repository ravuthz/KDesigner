<?php
// if(Session::exists('home')) {
//  echo '<p>' . Session::flash('home') . '</p>';
// }
// echo Session::get(Config::get('session/session_name'));
    Cls::checkLogin();
    HTML::adminHeader();
    $user = new UserObj();
    $article = new ArticleObj();
    $category = new CategoryObj();
?>

    <div class="alertbar">
        <p class="alert">
            <?php
                if($user->hasPermission('admin')) { echo 'You are an administrator'; }
            ?>
        </p>
    </div>

    <?php

    HTML::boxes(
        array(
            array(
                "title" => "Views",
                "count" => "250",
                "link" => Config::get('web/dir') . "#",
                "class" => "vies"
            ),
            array(
                "title" => "Articles",
                "count" => $article->listAll(2)->count(),
                "link" => Config::get('web/dir') . "articles/insert",
                "class" => "arts"
            ),
            array(
                "title" => "Categories",
                "count" => $category->listAll(1)->count(),
                "link" => Config::get('web/dir') . "categories/insert",
                "class" => "cats"
            ),
            array(
                "title" => "Users",
                "count" => $user->listAll(2)->count(),
                "link" => Config::get('web/dir') . "categories/insert",
                "class" => "usrs"
            ),
            array(
                "title" => "Comments",
                "count" => "100",
                "link" => Config::get('web/dir') . "comments/insert",
                "class" => "cmts"
            )
        )
    );

    HTML::clear(); 

?>

    <h2>Recent Posts</h2>
    <div id="bottom" class="container">
        
        <?php 
            HTML::articleTable(array(
                "list" => "2",
                "sort" => "id",
                "order" => "desc",
                "rows" => 5
            ));
        ?>

    </div>
        
<?php 
    HTML::clear();  
    HTML::adminFooter(); 
?>