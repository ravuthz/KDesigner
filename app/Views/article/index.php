<?php
    Cls::checkLogin();
    HTML::adminHeader();
    $article = new ArticleObj();
?>

    <h2>
        <a href="<?= Config::get('web/dir'); ?>">Home</a> of
        <a href="<?= Config::get('web/dir'); ?>articles/insert">Article +</a>
    </h2>

    <div class="container top">
        <div id="left">
            <a class="tab on" id="pub2" href="javascript:">All Posts ( <?= $article->listAll(2)->count(); ?> )</a>
            <a class="tab" id="pub1" href="javascript:">Published ( <?= $article->listAll(1)->count(); ?> )</a>
            <a class="tab" id="pub0" href="javascript:">Unpublish ( <?= $article->listAll(0)->count(); ?> )</a>
        </div>

		<div id="right">
            <?php

                $record = array(
                    "5" => "5",
                    "10" => "10",
                    "15" => "15",
                    "20" => "20"
                );

                $sort_by = array(
                    "id" => "No",
                    "title" => "Article",
                    "addOn" => "Added On",
                    "addBy" => "Added By"
                );

                $order_by = array(
                    "asc" => "Ascending",
                    "desc" => "Descending"
                );

                HTML::select("cbo-sort", "Sort By", $sort_by);
                HTML::select("cbo-order", "Order By", $order_by);
                HTML::select("cbo-records", "Max Rows", $record);

                HTML::input(array(
                    "id" => "txt-search",
                    "type" => "text",
                    "name" => "txt-search",
                    "placeholder" => "Search here",
                    "autocomplete" => "off"
                ));

            ?>

		</div>
	</div>

	<?php 
        HTML::clear();

        $fields = array(
            "list" => "2",
            "sort" => array_keys($sort_by)[0],
            "order" => array_keys($order_by)[0],
            "rows" => array_values($record)[0]
        );

    ?>

    <script type="text/javascript">
        // pass PHP variable declared above to JavaScript variable
        // var arts = <?php echo json_encode($article->listAll(2)->datas()) ?>;
        // var flds = <?php echo json_encode($fields) ?>;
    </script>

    <div id="bottom" class="container bottom" ><!-- bottom container -->
    
    <?php
//        HTML::articleTable(array(
//            "list" => "2",
//            "sort" => array_keys($sort_by)[0],
//            "order" => array_keys($order_by)[0],
//            "rows" => array_values($record)[0]
//        ));

    HTML::articleTable();

    ?>
    </div><!-- bottom container -->

    <a href="javascript:fullscreen();">FullScreen</a>

    <script type="text/javascript">

        // myWindow = window.open('', '', 'width=400, height=300');    // Opens a new window
        // myWindow.document.write("<p>This is 'myWindow'</p>");
        // myWindow.moveTo(500, 100);                                  // Moves the new window    
        // myWindow.moveTo(0,0);
        // myWindow.focus();       


        // window.print(); 

        function maxWindow() {
            window.moveTo(0, 0);

            if (document.all) {
                // top.window.resizeTo(screen.availWidth, screen.availHeight);
                window.top.resizeTo(screen.availWidth, screen.availHeight);
            }

            else if (document.layers || document.getElementById) {
                if (top.window.outerHeight < screen.availHeight || top.window.outerWidth < screen.availWidth) {
                    top.window.outerHeight = screen.availHeight;
                    top.window.outerWidth = screen.availWidth;
                }

            }
            alert(screen.availWidth +", "+screen.availHeight);
        }

        function requestFullScreen(element) {
            // Supports most browsers and their versions.
            var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(element);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        var elem = document.body; // Make the body go full screen.
        // requestFullScreen(elem);

        function fullscreen() {

            // window.open("http://localhost:99/kdesigner/articles/index","fs","fullscreen=yes");
            // window.close(fs);

            // requestFullScreen(elem);
            // maxWindow();

            // toggleFullScreen(document.body);

        }


        function isFullScreen(){
            return (document.fullScreenElement && document.fullScreenElement !== null)
                 || document.mozFullScreen
                 || document.webkitIsFullScreen;
        }

        function requestFullScreen(element){
            if (element.requestFullscreen)
                element.requestFullscreen();
            else if (element.msRequestFullscreen)
                element.msRequestFullscreen();
            else if (element.mozRequestFullScreen)
                element.mozRequestFullScreen();
            else if (element.webkitRequestFullscreen)
                element.webkitRequestFullscreen();
        }

        function exitFullScreen(){
            if (document.exitFullscreen)
                document.exitFullscreen();
            else if (document.msExitFullscreen)
                document.msExitFullscreen();
            else if (document.mozCancelFullScreen)
                document.mozCancelFullScreen();
            else if (document.webkitExitFullscreen)
                document.webkitExitFullscreen();
        }

        function toggleFullScreen(element){
            if (isFullScreen())
                cancelFullScreen();
            else
                requestFullScreen(element || document.documentElement);
        }

    </script>

<?php 
    HTML::adminFooter();
?>