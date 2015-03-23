<?php
    HTML::homeHeader();
//    $view = new ViewObj();
//
//    $totalViews = 0;
//    $currentViews = 0;
//
//    $current = $view->exists(Cls::macAddress());
//     HTML::show($current->data());
//    if ($current){
//
//        $view->update(array(
//            "view" => ($current->data()->view + 1),
//            "date" => date('Y-m-d H:i:s')
//        ), $current->data()->id);
//        $currentViews += 1;
//    } else {
//        $view->insert(array(
//            "view" => 1,
//            "ip_address" => Cls::ipAddress(),
//            "mac_address" => Cls::macAddress(),
//            "date" => date('Y-m-d H:i:s')
//        ));
//        $currentViews += 1;
//    }
//
//    $views = $view->listAll();
//    foreach ($views->datas() as $value) {
//        $totalViews += $value->view;
//    }
//    echo "<br/>Current IP : ", Cls::ipAddress();
//    echo "<br/>Total Visitor : ", $totalViews;
//    echo "<br/>Online Visitor : ", $currentViews;
$vid = new VideoObj();
$art = new ArticleObj();
?>

    <div id="late-post-left">
    <?php
        HTML::highlightPost($art->listBy(0,1)->data());
    ?>
    </div>

    <?php
        HTML::latePost($art->listBy(0,3)->datas());
        HTML::clear();
    ?>

    <section id="latest-videos">
        <header>
            <h3>Videos</h3>
            <a href="#" class="view-more">View More</a>
        </header>

        <div>
            <article>
                <img src="images/Post-Image.png">
                <div class="post-desc">
                    <div class="gen-post-title">
                        Lorem Ipsum is simply dummy text of the printing
                        <span class="vid-duration">(3:12)</span>
                    </div><!--end of General Post Title-->
                    <div class="gen-post-author">
                        by <span class="author">Nhim Chanborey</span>
                    </div><!--end of General Post Author-->
                </div><!--end of post description-->
            </article><!--end of post item wrap-->

            <article>
                <img src="images/Post-Image.png">
                <div class="post-desc">
                    <div class="gen-post-title">
                        Lorem Ipsum is simply dummy text of the printing
                        <span class="vid-duration">(3:12)</span>
                    </div><!--end of General Post Title-->
                    <div class="gen-post-author">
                        by <span class="author">Nhim Chanborey</span>
                    </div><!--end of General Post Author-->
                </div><!--end of post description-->
            </article><!--end of post item wrap-->

            <article>
                <img src="images/Post-Image.png">
                <div class="post-desc">
                    <div class="gen-post-title">
                        Lorem Ipsum is simply dummy text of the printing
                        <span class="vid-duration">(3:12)</span>
                    </div><!--end of General Post Title-->
                    <div class="gen-post-author">
                        by <span class="author">Nhim Chanborey</span>
                    </div><!--end of General Post Author-->
                </div><!--end of post description-->
            </article><!--end of post item wrap-->

            <article>
                <img src="images/Post-Image.png">
                <div class="post-desc">
                    <div class="gen-post-title">
                        Lorem Ipsum is simply dummy text of the printing
                        <span class="vid-duration">(3:12)</span>
                    </div><!--end of General Post Title-->
                    <div class="gen-post-author">
                        by <span class="author">Nhim Chanborey</span>
                    </div><!--end of General Post Author-->
                </div><!--end of post description-->
            </article><!--end of post item wrap-->
        </div>

        <div class="clear"></div>
    </section><!--end of latest videos section -->

    <section id="pop-post-btn">
        <header>
            <a href="#pop-post"><h3>Popular Posts (Click Here)</h3></a>
        </header>
    </section>

    <?php

        HTML::category("design-news" ,$art->listBy(0,8)->datas());
        HTML::category("inspiration" ,$art->listBy(1,4)->datas());
        HTML::category("freebies" ,$art->listBy(2,4)->datas());
        HTML::category("how-to" ,$art->listBy(3,4)->datas());

    ?>

    <section id="pop-post">
    <?php
        HTML::popPost($art->listAll(0), 10);
    ?>
    </section>

<?php
    HTML::homeFooter();
?>