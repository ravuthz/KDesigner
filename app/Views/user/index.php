<?php
    Cls::checkLogin();
    HTML::adminHeader();
    $user = new UserObj();
?>

	<h2>
        <a href="<?php echo Config::get('web/dir'); ?>">Home</a> of 
        <a href="<?php echo Config::get('web/dir'); ?>users/insert">User +</a>
    </h2>

	<div class="container top">
        <div id="left">
            <a class="tab on" id="pub2" href="javascript:">All Users ( <?= $user->listAll(2)->count(); ?> )</a>
            <a class="tab" id="pub1" href="javascript:">Actived ( <?= $user->listAll(1)->count(); ?> )</a>
            <a class="tab" id="pub0" href="javascript:">Deactived ( <?= $user->listAll(0)->count(); ?> )</a>
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
                    "username" => "User",
                    "firstname" => "First Name",
                    "lastname" => "Last Name",
                    "email" => "Email Address",
                    "phone" => "Phone Number",
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
    <div id="bottom" class="container bottom" ><!-- bottom container -->
    <?php 

        HTML::userTable($user, array(
            "list" => "2",
            "sort" => array_keys($sort_by)[0],
            "order" => array_keys($order_by)[0],
            "rows" => array_values($record)[0]
        ));


    ?>
    </div><!-- bottom container -->

<?php
	HTML::adminFooter(); 
?>