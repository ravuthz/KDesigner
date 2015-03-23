<?php
	Cls::checkLogin();
    HTML::adminHeader();
	$user = new UserObj();
	$article = new ArticleObj();

    $category = new CategoryObj();
    $cates = $category->listAll(1)->datas();

//	if (Input::exists()){
//		if(Token::check(Input::get('token'))) {
//		}
//	}

?>
    <h2>
        <a href="<?= Config::get('web/dir'); ?>">Home</a> of Article
    </h2>
    <div id="load">
    <?php
    $art = Input::get("article");
    HTML::show($art);
//    if ($art){
//        try {
//            $article->insert(array(
//                "title" => $art['title'],
//                "content" => $art['content'],
//                "addOn" => date('Y-m-d H:i:s'),
//                "addBy" => $user->data()->id,
//                "thumbnail" => $art['thumbnail'],
//                "status" => $art['status']
//            ));
//            HTML::setAlert("create", "This video was created successfully");
//        }catch (Exception $ex){
//            HTML::setAlert("create", $ex->getMessage());
//        }
//    }

//    HTML::getAlert("create");

    ?>
    </div>

<div class='form-container'>
    <table class='frm new-art'>
        <tr>
            <td>Title</td>
            <td><input type='text' id="title"></td>
        </tr>
        <tr>
            <td>Category</td>
            <td colspan='2'>

                <a href='javascript:' class='listbox'>Category<span class='lb-arr'>arr</span></a>
                <ul class='listbox-item'>
                    <?php foreach($cates as $cate){ ?>

                    <li id="<?= $cate->id ?>">
                        <?=$cate->name ?>
                    </li>

                    <?php } ?>
                </ul>

                <a href='javascript:' id='btn-highligh' class='btn highlight'>Highlight</a>
                <input type='hidden' id="highlight" value='0'>
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <a class='on-off-btn post'></a><span class='status'>Disable</span>
                <input type="hidden" id="status" value="0">
            </td>
            <td></td>
        </tr>
        <tr>
            <td>Thumbnail</td>
            <td>
                <a href="javascript:" class="upload-panel">
                    <span class='upload-ico'>Icon</span>
                </a>
                <input type="file" id="thumbnail">
            </td>
        </tr>
        <tr>
            <td>Content</td>
            <td>
                <textarea id="content"></textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <a id="btnCreateArticle" href="javascript:" class='btn pub'>Add</a>
                <a href="<?= Config::get('web/dir') . 'articles/index' ?>" class='btn can'>Cancel</a>
            </td>
        </tr>
        <input type='hidden' name='token' value='" . Token::generate() . "' />
    </table>
</div>

<?= HTML::adminFooter(); ?>