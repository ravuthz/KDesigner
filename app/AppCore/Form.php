<?php

class Form {

    public static function input($items = null){
        if ($items){
            echo "<input ";
            foreach($items as $key => $val){
                echo $key . "=" . "\"" . $val . "\" ";
            }
            echo ">";
        }
    }

	public static function insert(){

		$cat = new CategoryObj();
		$cats = $cat->listAll(1)->datas();

		$fields = array(
			"formTitle" => "Insert",
			"title" => "",
			"category" => $cats,
			"highlight" => "Highlight",
			"status" => "Disable",
			"thumbnail" => "images/posts/post-thumbnail.png",
			"content" => "",
			"btnSubmit" => "Insert"
		);

		echo "
		<h2>
			<a href='" . Config::get('web/dir') . "'>Home</a> of Article - {$fields['formTitle']}
		</h2>
		<div class='form-container'>
			<form action='' method='post'>
				<table class='frm new-art'>
					<tr>
						<td>Title</td>
						<td><input type='text' name='mytitle' value='{$fields['title']}'></td>
			     	</tr>
			     	<tr>
						<td>Category</td>
						<td colspan='2'>
							<a href='#' class='listbox'>Category<span class='lb-arr'>arr</span></a>
							<ul class='listbox-item'>
		";
							
								foreach ($fields['category'] as $value) {
									echo "<li>
											<a href='javascript: categorySelected({$value->id}, \"{$value->name}\")'>
												{$value->name}
											</a>
										</li>";
								}
							
		echo "
							</ul>
							<input type='hidden' name='mycategory' value='0'>

							<a href='javascript:' id='btn-highligh' class='btn highlight'>Highlight</a>
							<input type='hidden' name='myhighlight' value='0'>
						</td>   
					</tr>
					<tr>
						<td>Status</td>
						<td>
							<a class='on-off-btn post'></a><span class='status'>Disable</span>
							<input type='hidden' name='mystatus' value='0'>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>Thumbnail</td>
						<td>
							<a href='javascript:' class='upload-panel'>
								<span class='upload-ico'>Icon</span>
							</a>
							<input type='file' name='mythubnail'>
						</td>
					</tr>
					<tr>
						<td>Content</td>
						<td>
							<textarea name='mycontent'></textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<a href='javascript:submitForm()' class='btn pub'>Add</a>
							<a href='" . Config::get('web/dir') . "articles/index' class='btn can'>Cancel</a>
						</td>
					</tr>
					<input type='hidden' name='token' value='" . Token::generate() . "' />
				</table><!--end of Operation Wrap Table-->
			</form>
		</div><!--end of form container-->
		";
	}

	public static function update($data){

		$category = new CategoryObj();
		$cats = $category->listAll(1)->datas();

		$article = new ArticleObj();
		$art = $article->detail($data['id'])->data();

		$classStatus = $art->status == 1 ? "on":"";
		$textStatus = $art->status == 1 ? "Enable":"Disable";

		echo "
		<h2>
			<a href='" . Config::get('web/dir') . "'>Home</a> of Article - Update
		</h2>

		<div class='form-container'>
			<form action='' method='post'>
				<table class='frm new-art'>
					<tr>
						<td>Title</td>
						<td><input type='text' name='mytitle' value='" . $art->title . "'></td>
			     	</tr>
			     	<tr>
						<td>Category</td>
						<td colspan='2'>
							<a href='#' class='listbox'>" . $art->category . "<span class='lb-arr'>arr</span></a>
							<ul class='listbox-item'>
		";	
							foreach ($cats as $value) {
								echo "
								<li>
									<a href='javascript: categorySelected({$value->id}, \"{$value->name}\")'>
										{$value->name}
									</a>
								</li>";
							}
		echo "
							</ul>
							<input type='hidden' name='mycategory' value='" . $art->category . "'>

							<a href='javascript:' id='btn-highligh' class='btn highlight'>Highlight</a>
							<input type='hidden' name='myhighlight' value='" . $art->highlight . "'>
						</td>   
					</tr>
					<tr>
						<td>Status</td>
						<td>
							<a class='on-off-btn post " . $classStatus . "'></a>
							<span class='status'>" . $textStatus . "</span>

							<input type='hidden' id='change-status' name='mystatus' value='" . $art->status . "'>

							<input type='file' name='myfile' value='" . $art->file . "'>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>Thumbnail</td>
						<td>
							<a href='#' class='upload-panel'>
								<span class='upload-ico'>Icon</span>
							</a>
						</td>
					</tr>
					<tr>
						<td>Content</td>
						<td>
							<textarea name='mycontent'>" . $art->content . "</textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<a href='javascript:submitForm()' class='btn pub'>Update</a>
							<a href='" . Config::get('web/dir') . "articles/index' class='btn can'>Cancel</a>
						</td>
					</tr>
					<input type='hidden' name='token' value='" . Token::generate() . "' />
				</table><!--end of Operation Wrap Table-->
				</form>
			</div><!--end of form container-->
		";
	}

	public static function newUser(){
		echo "
		<h2>New User</h2>
	    <div class='form-container'>
	        
	        <table class='frm acc new-usr'>
	            <tr>
	                <td>Email</td>
	                <td><input type='text' class='textbox long'></td>
	            </tr>
	            <tr>
	                <td>Username</td>
	                <td><input type='text' class='textbox long'></td>
	            </tr>
	            <tr>
	                <td>Phone Number</td>
	                <td>
	                    <input type='text' placeholder='Line 1' class='textbox phone'> / 
	                    <input type='text' placeholder='Line 2' class='textbox phone'>
	                </td>
	            </tr>
	            <tr>
	                <td>Role</td>
	                <td colspan='2'>
	                    <a href='#' class='listbox'>Select<span class='lb-arr'>arr</span></a>
	                    <ul class='listbox-item'>
	                        <li><a href='#'>Administrator</a></li>
	                        <li><a href='#'>Normal User</a></li>
	                        <li><a href='#'>Editor</a></li>
	                    </ul>
	                </td>   
	            </tr>
	            <tr>
	                <td>Status</td>
	                <td><a class='on-off-btn post'></a><span class='state-val dis'>Disable</span></td>
	                <td></td>
	            </tr>
	            <tr>
	                <td>Password</td>
	                <td><input type='text' class='textbox long'></td>
	            </tr>
	            <tr>
	                <td>Repeat Password</td>
	                <td><input type='text' class='textbox long'></td>
	            </tr>
	            <tr>
	                <td valign='top'>Profile Picture</td>
	                <td>
	                    <a href='#' class='upload-panel'>
	                        <span class='upload-ico'>Icon</span>
	                    </a>
	                </td>
	            </tr>

	            <tr>
	                <td valign='top'>Bio</td>
	                <td>
	                    <textarea style='height: 70px'></textarea>
	                </td>
	            </tr>
	            <tr>
	                <td>Social</td>
	                <td><input type='text' name='social1' class='social'></td>
	            </tr>
	            <tr>
	                <td></td>
	                <td><input type='text' name='social2' class='social'></td>
	            </tr>
	          
	        </table><!--end of Operation Wrap Table-->

	        <table class='frm'>
	            <tr>
	                <td></td>
	                <td><a href='javascript:addRow()' class='btn pls'>+</a></td>
	            </tr>
	            <tr>
	                <td></td>
	                <td>
	                    <a href='javascript:submitForm()' class='btn pub'>Publish</a>
	                    <a href='" . Config::get('web/dir') . "users/index' class='btn can'>Cancel</a>
	                </td>
	            </tr>
	        </table>
	    </div><!--end of form container-->
		";
	}

}

?>