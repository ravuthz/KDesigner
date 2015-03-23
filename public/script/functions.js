function getUrl(){
    
    host = window.location.href;
    //=> http://localhost/kdesigner/articles/index
    path =  window.location.pathname;
    //=> /kdesigner/articles/index
    dir = path.split("/")[1];
    //=> kdesigner
    url = "";

    // find [kdesigner] in [http://localhost/kdesigner/articles/index]
    // if exist select [http://localhost/kdesigner]
    if (x = host.lastIndexOf(dir)) {
        url = host.substring(0, x+dir.length);
    }
    return url + "/";
}

function articleTable(posts, selector, fields){

    if (fields == null){
    	fields = {
    		"list":"2",
    		"sort":"id",
    		"order":"asc",
    		"rows": "5",
            "page": "1"
    	};
    }

    currentPage = fields['page'];
    rowsPerPage = fields['rows'];
    totalRows = posts.length;

    rowsPerPage = rowsPerPage > totalRows ? totalRows : rowsPerPage;

    start = rowsPerPage * (currentPage-1);
    stop = rowsPerPage * currentPage;

    stop = stop > totalRows ? totalRows : stop;

    tag = "\
    <div class='table-wrapper'> \
        <table class='article'> \
            <tr> \
                <th><input type='checkbox' id='selectAll'></th> \
                <th>No</th> \
                <th>Article</th> \
                <th>Added By</th> \
                <th>Added On</th> \
                <th>Status</th> \
                <th>Option</th> \
            </tr>";

    for(i = start; i <stop; i++){
    // for(i = 0; i < parseInt(fields['rows'][0]); i++){
        tag += "<tr><td><input type='checkbox' id='" + posts[i]['id'] + "'></td><td>" 
            + posts[i]['id'] + "</td><td>"
            + "<a href='" + getUrl() + "articles/detail/" + posts[i]['id'] + "'>"
            + posts[i]['title'] +"</a></td><td>" 
            + posts[i]['addBy'] + "</td><td>" 
            + posts[i]['addOn'] + "</td><td>" 
            + posts[i]['status'] + "</td><td>"
            + "<ul class='edit-delete-btn'>"
            + "<li><a id='edit-opr' href='" + getUrl() + "articles/update/" + posts[i]['id'] + "'>Edit</a></li>"
            +  "<li><a id='del-opr' href='javascript: deleteId(" + posts[i]['id'] + ")'>Delete</a></li></td></tr>";
    }

    tag += "</table>";
    tag += pagination(currentPage, rowsPerPage, totalRows);
    $(selector).empty();
    $(selector).append(tag);
}

function pagination(currentPage, rowsPerPage, totalRows){
	totalPages = Math.ceil(totalRows / rowsPerPage);

    firstPage = 1;
	lastPage = totalPages;
	nextPage = currentPage + 1;
	previousPage = currentPage - 1;

	tag = "\
		<div class='pagination-wrap'> \
            <ul class='pagination'> \
                <li><a class='pfirst " + (currentPage == 1 ? 'dis' : '') + "' href='javascript:page(" + firstPage + ")'>First</a></li> \
                <li><a class='pprev " + (currentPage == 1 ? 'dis' : 'ena') + "' href='javascript:page(" + previousPage + ")'>&lt;&lt;</a></li> \
                "; 

                for(i=1; i<=totalPages; i++) { 
                    if (currentPage == i) {
                        tag += "<li><a class='p-focus' href='javascript:page(" + i + ")'>" + i + "</a></li>";
                    } else {
                        tag += "<li><a  href='javascript:page(" + i + ")'>" + i + "</a></li>";
                    }
                } 
                
                tag += "\
                <li><a class='pnext ena' href='javascript:page(" + nextPage + ")'>&gt;&gt;</a></li> \
                <li><a class='plast ena' href='javascript:page(" + lastPage + ")'>Last</a></li> \
            </ul> \
        </div> \
	";
	return tag;
}

function sortBy(arts, prop, asc) {
    console.log(arts);
    return arts.sort(function(a, b) {
        if (asc=="asc") return (a[prop] > b[prop]) ? 1 : ((a[prop] < b[prop]) ? -1 : 0);
        else return (b[prop] > a[prop]) ? 1 : ((b[prop] < a[prop]) ? -1 : 0);
    });
}

function searchBy(arts, key) {
    keyword = key.toLowerCase();
    found = [];
    if (key){
        $.each(arts, function(i, val) {
            if (val.title.indexOf(keyword) != -1 || val.content.indexOf(keyword) != -1) {
                found.push(val);
            }
        });
        return found;
    }
    return arts;
}



