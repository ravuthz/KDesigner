<?php
    Cls::checkLogin();
    HTML::adminHeader();
?>

    <h2>New Category</h2>
    <div class="form-container">
        <table class="frm new-cat">
            <tr>
                <td>Name</td>
                <td><input type="text"></td>
            </tr>
            <tr>
                <td>Description</td>
                <td>
                    <textarea></textarea>
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td><a class="on-off-btn post"></a><span class="status">Disable</span></td>
                <td></td>
            </tr>
            <tr>
                <td>Color Theme</td>
                <td><input type="text"></td>
            </tr>

            <tr>
                <td>Thumbnail</td>
                <td>
                    <a href="#" class="upload-panel">
                        <span class="upload-ico">Icon</span>
                    </a>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href="#" class="btn pub">Publish</a>
                    <a href="#" class="btn can">Cancel</a>
                </td>
            </tr>
        </table><!--end of Operation Wrap Table-->
    </div><!--end of form container-->

<?php HTML::adminFooter(); ?>