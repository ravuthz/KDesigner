<?php
	Cls::checkLogin();
	$language = new Language();
    $lang =  $language->getLang();
    HTML::adminHeader($lang);
?>

    <p class="opr-title">Setting</p>
    <div class="form-container">
        <h1 class="setting-sec-title">General Setting</h1>
        <table class="frm">
           <tr>
               <td>Site Logo</td>
               <td>
                   <img class="site-pic" src="../images/site-logo.png">
                   <a href="#" class="btn upd site">Update</a>
               </td>
            </tr>
            <tr>
                <td>Video Theme</td>
                <td>
                    <ul class="v-theme-select">
                        <li><a href="#" id="color1">1</a></li>
                        <li><a href="#" id="color2">2</a></li>
                        <li><a href="#" id="color3">3</a></li>
                        <li><a href="#" id="color4">4</a></li>
                        <li><a href="#" id="color5">5</a></li>
                        <li><a href="#" id="color6">6</a></li>
                        <li><a href="#" id="color7">7</a></li>
                    </ul>
                </td>
            </tr>
        </table>
        
        <h1 class="setting-sec-title">Account Setting</h1>
        
        <table class="frm acc">
            <tr>
                <td>Email</td>
                <td><input type="text" name="email"></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username"></td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td>
                    <input type="text" name="phone1" placeholder="Line 1" class="phone"> / 
                    <input type="text" name="phone2" placeholder="Line 2" class="phone">
                </td>
            </tr>
            <tr>
                <td>Profile Picture</td>
                <td>
                    <img class="profile-pic" src="../images/user-profile.png">
                    <a href="#" class="btn upd">Update</a>
                </td>
            </tr>

            <tr>
                <td>Bio</td>
                <td>
                    <textarea name="bio">
                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
                    </textarea>
                </td>
            </tr>
            <tr>
                <td>Social</td>
                <td><input type="text" name="social1" class="social"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="text" name="social2" class="social"></td>
            </tr>
            
        </table><!--end of Operation Wrap Table-->
        <table class="frm">
            <tr>
                <td></td>
                <td><a href="javascript:addRow()" class="btn pls">+</a></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href="javascript:save()" class="btn pub">Save</a>
                    <a href="#" class="btn can">Cancel</a>
                </td>
            </tr>
        </table>
        
    </div><!--end of form container-->

<?php HTML::adminFooter(); ?>