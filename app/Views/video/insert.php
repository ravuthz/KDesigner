<?php
    Cls::checkLogin();
    HTML::adminHeader();
    $user = new UserObj();
    $video = new VideoObj();
?>
    <h2>New Video</h2>
    <div id="load">
    <?php
        $vid = Input::get("video");
        if ($vid){
            try {
                $video->insert(array(
                    "title" => $vid['title'],
                    "content" => $vid['content'],
                    "embed" => $vid['embed'],
                    "addOn" => date('Y-m-d H:i:s'),
                    "addBy" => $user->data()->id,
                    "thumbnail" => $vid['thumbnail'],
                    "status" => $vid['status']
                ));
                HTML::setAlert("create", "This video was created successfully");
            }catch (Exception $ex){
                HTML::setAlert("create", $ex->getMessage());
            }
        }

        HTML::getAlert("create");

    ?>
    </div>

    <div class="form-container">
        <table class="frm new-vid">
            <tr>
                <td>Title</td>
                <td><input id="title" type="text"></td>
            </tr>
            <tr>
                <td>Duration</td>
                <td><input id="duration" type="text"></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <a class="on-off-btn post"></a><span class="status">Disable</span>
                    <input type="hidden" id="status" value="0">
                </td>
                <td></td>
            </tr>
            <tr>
                <td>Thumbnail</td>
                <td>
                    <a href="javascript:" class="upload-panel">
                        <span class="upload-ico">Icon</span>
                    </a>
                    <input type="file" id="thumbnail">
                </td>
            </tr>
            <tr>
                <td>Embed</td>
                <td><input id="embed" type="text"></td>
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
                        <a id="btnCreateVideo" href="javascript:" class="btn pub">Create</a>
                    <a href="<?= Config::get('web/dir') ?>videos/index" class="btn can">Cancel</a>
                </td>
            </tr>
        </table>
    </div>

<?= HTML::adminFooter(); ?>