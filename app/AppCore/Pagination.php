<?php

class Pagination {
	private $firstPage, $lastPage, $currentPage, $totalPages, $nextPage, $previousPage;

	public function __construct($rowsPerPage, $totalRows){
		$this->totalPages = ceil($totalRows / $rowsPerPage);

        if ($input = Input::get('input')){
            if ($input['cpage'] < 1){
                $this->currentPage = 1;
            } else if ($input['cpage'] > $this->totalPages) {
                $this->currentPage = $totalRows;
            } else {
                $this->currentPage = $input['cpage'];
            }
        } else {
            $this->currentPage = 1;
        }

		$this->firstPage = 1;
		$this->lastPage = $this->totalPages;

		$this->nextPage = $this->currentPage + 1;
		$this->nextPage = $this->nextPage > $this->totalPages ? $this->totalPages : $this->nextPage;

		$this->previousPage = $this->currentPage - 1;
		$this->previousPage = $this->previousPage < $this->firstPage ? $this->firstPage : $this->previousPage;
	}

	public function currentPage(){
		return $this->currentPage;
	}

	public function display(){
		echo "
			<div class='pagination-wrap'>
	            <ul class='pagination'>
	                <li><a class='pfirst ". ($this->currentPage == 1 ? 'dis' : 'ena') ."' href='javascript:page({$this->firstPage})'>First</a></li>
	                <li><a class='pprev ". ($this->currentPage == 1 ? 'dis' : 'ena') ."' href='javascript:page({$this->previousPage})'>&lt;&lt;</a></li>
	                ";

	                for($i=1; $i<=$this->totalPages; $i++) { 
	                    if ($this->currentPage == $i) {
	                        echo "<li><a class='p-focus' href='javascript:page({$i})'>{$i}</a></li>";
	                    } else {
	                        echo "<li><a  href='javascript:page({$i})'>{$i}</a></li>";
	                    }
	                } 
	                
	                echo "
	                <li><a class='pnext ".($this->currentPage == $this->lastPage ? 'dis':'ena') ."' href='javascript:page({$this->nextPage})'>&gt;&gt;</a></li>
	                <li><a class='plast ".($this->currentPage == $this->lastPage ? 'dis':'ena')."' href='javascript:page({$this->lastPage})'>Last</a></li>
	            </ul>
	        </div>
		"; 
	}
}

?>