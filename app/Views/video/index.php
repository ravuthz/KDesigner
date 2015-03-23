<?php
    Cls::checkLogin();
    HTML::adminHeader();

    $video = new VideoObj();
    $videos = $video->listAll();
?>

    <h2>
        <a href="<?= Config::get('web/dir'); ?>">Home</a> of
        <a href="<?= Config::get('web/dir'); ?>videos/insert">Video +</a>
    </h2>

    <div class="container top">
    <div id="left">
        <a class="tab on" id="pub2" href="javascript:">All Posts ( <?= $video->listAll(2)->count(); ?> )</a>
        <a class="tab" id="pub1" href="javascript:">Published ( <?= $video->listAll(1)->count(); ?> )</a>
        <a class="tab" id="pub0" href="javascript:">Unpublish ( <?= $video->listAll(0)->count(); ?> )</a>
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
                "title" => "Video",
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
    <?php

//        $pagination = new Pagination($rows, $video->listAll()->count());
//
//        $video->listAll(
//            $list,
//            $keyword,
//            [($rows*($pagination->currentPage()-1)), $rows],
//            [$sort, $order]
//        )->datas();

        $max = $video->count();
    ?>
    <div id="bottom" class="container bottom" >
        <?php
            HTML::categoryTable();
        ?>
    </div>
<?= HTML::adminFooter(); ?>