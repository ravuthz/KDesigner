var selects = [];
var categoryId;
var input = { "list":"", "sort":"", "order":"", "rows":"", "cpage":"" };
var Events = {};

$(document).ready(function(){

/*==================== Start Top Control Action ====================*/
    /* For three tabs of the table Pub1, Pub2, Pub3 */
    $(document).on("click", ".tab", function(){
        $(".tab").removeClass("on");
        $(this).addClass("on");
        //topControllEvents();
        Events.topControl();
    });

    /* This will execute when one of select tag has class select change action */
    /* such as Sort By, Order By, Max Rows select ... */
    $(document).on("change", ".select", function(){
        //topControllEvents();
        Events.topControl();
    });

    $(document).on("keyup","#txt-search", function(){
        //topControllEvents();
        Events.topControl();
    });
/*==================== Stop Top Control Action ====================*/

    //input['rows'] = $("#cbo-records").val();
	//rows = $("#cbo-records").val();

	//$("#article").click(function(){
	//	$("#hide").show();
	//});

	// articleTable(arts, "#bottom", flds, 1);



	/* multiple select */
	$(document).on('change', '#selectAll', function(){
		if ($(this).is(':checked')){
			selects = [];
			$(':checkbox').prop('checked', true);
			$(":checkbox:checked:not(#selectAll)").each(function(){
				$(".article tr").addClass("selected");
				selects.push($(this).attr("id"));
			});
			
		} else {
			$(':checkbox').prop('checked', false);
			$(".article tr").removeClass("selected");
			selects = [];
		}
		console.log(selects);
	}); 

	$(document).on('change', ':checkbox:not(#selectAll)', function(){
		selects = [];
		$(":checkbox:checked:not(#selectAll)").each(function(){
			$(":checkbox:checked:not(#selectAll)").parent().parent().addClass("selected");	
			selects.push($(this).attr("id"));
		});

		$(":checkbox:not(:checked)").parent().parent().removeClass("selected");
		console.log(selects);
	});
	/* multiple select */

	/* start article/insert */
	$(document).on('click', '#btn-highligh', function(){
		var status=$(this).text();
		if(status.toLowerCase()=="highlight"){
			$(this).html("HIGHLIGHTED");
			$("input[name='myhighlight']").val("1");
		}else{
			$(this).html("HIGHLIGHT");
			$("input[name='myhighlight']").val("0");
		}
	});

	$(document).on('click', '.on-off-btn', function(){
		$(this).toggleClass("on");
		$('.status').toggleClass("on");
		
		if ($('.status').html().toLowerCase() === "disable") {	
			$('.status').html("Enable");
			$("#status").val('1');
		}else{
			$('.status').html("Disable");
			$("#status").val('0');
		}
	});

	$(document).on('click', '.upload-panel', function(){
        $("input[type='file']").click();
	});

	// $(document).on('change', "input[name='myfile']", function(){
	// 	$(this).val();
	// });
	/* stop article/insert */

    /* create video */
    $(document).on("click", "#btnCreateVideo", function(){
        var video = {
            "title" : $("#title").val(),
            "duration" : $("#duration").val(),
            "embed" : $("#embed").val(),
            "thumbnail" : $("#thumbnail").val(),
            "status" : $("#status").val(),
            "content" : $("#content").val()
        };
        $("#load").load("videos/insert.php div#load", {"video":video});
    });

    /* create article */
    $(document).on("click", "#btnCreateArticle", function(){
        var article = {
            "title" : $("#title").val(),
            "category" : categoryId,
            "status" : $("#status").val(),
            "thumbnail" : $("#thumbnail").val(),
            "content" : $("#content").val()
        };
        //$("#load").load("articles/insert div#load", {"article":article});
        $("#load").load("insert #load", {"article":article});
        console.log(article);
    })


    Events.topControl = function(page, action) {
        input = {
            "list" : $(".tab.on").attr("id").substr(3),
            "order" : $('#cbo-order').val(),
            "sort" : $('#cbo-sort').val(),
            "rows" : $('#cbo-records').val(),
            "key" : $("#txt-search").val(),
            "cpage" : page ? page : "1"
        };

        console.log(input);
        $("#bottom").load("index #bottom > div", {"input":input, "action":action});
        $("#left").load("index #left");
    }

}); /* End of Document Ready */

/* Table's Rows Events */
function deleteId(id) {
    if (confirm("Are you really want to delete this record ?")) {
        Events.topControl("", {
            "name":"delete", "id":id
        });
    }
}

function changeStatus(id,st) {
    Events.topControl("", {
        "name":"update", "id": id, "status":st
    });
}
/* End Table's Rows Events */

/* Pagination Event */
function page(p){
    Events.topControl(p);
}
/* End Pagination Events*/


function addRow(){
	var tag = "<tr><td></td><td><input type='text' class='social'></td></tr>";
	$(".frm.acc").append(tag);
}

function save(){
	socials = [];
	$(".social").each(function(){
		socials.push($(this).val());
	});
	console.log(socials);
}





function jsCboChange(page){
	sort = $('#cbo-sort').val();
	order = $('#cbo-order').val();
	rows = $('#cbo-records').val();
	key = $("#txt-search").val();

	fields = {
		"list": list,
		"rows": rows,
		"page": page
	};

	articleTable(sortBy(arts, sort, order), "#bottom", fields);
}

function closeButton(x){
	$("#alertbar").load("articles/index.php div#alertbar", {deleteSession:x});
	$("#alertbar").remove();
}

function submitForm(){
	$("form").submit();
}



$(function(){
    $('.user-wrap > ul').toggleClass('no-js js');
    $('.user-wrap .js ul').hide();
    $('.user-wrap .js').click(function(e) {
        $('.user-wrap .js ul').slideToggle(100);
        $('.user').toggleClass('active');
        e.stopPropagation();
    });

    $(document).click(function() {
        if ($('.user-wrap .js ul').is(':visible')){
            $('.user-wrap .js ul', this).slideUp();
            $('.user').removeClass('active');
        }
    });

    $(document).on('click', '.listbox', function(e){
        $('.listbox-item').slideToggle(500);
        e.stopPropagation();
    });

    $(document).on("click", ".listbox-item li", function(){
        categoryId = $(this).attr("id");
        var name = $(this).text();
        $(".listbox").html(name + '<span class="lb-arr">arr</span>');
    });

    $(document).click(function() {
        if ($('.listbox-item').is(':visible')) {
            $('.listbox-item', this).slideUp(20);
        }
    });

});