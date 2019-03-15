<?php

/*
Object for comments in review site, this comments require for query: reviewId, userId
comment and date of comment commit. 
*/
class comments{
	
	public $path;
	public $userID;
	public $reviewID;
	public $comment;
	public $date;
	
	function __construct($path, $userId, $reviewId, $comment, $date=null){
		/*
			Define the vars in object for manipulation in others functions
		*/
		$formdate = DateTime::createFromFormat('d/m/Y');
		$this->path = $path;
		$this->userId = $userId;
		$this->reviewId = $reviewId;
		$this->comment = $comment;
		if($formdate && $formdate->format('d/m/Y') === $date){
		   $this->date = $date;
		}else{
			$this->date = $formdate;
		}
	}

	function save(){
		$forsave[$this->reviewId]['userId'] = $this->userId;
		$forsave[$this->reviewId]['comment'] = $this->comment;
		$json = file_get_contents($path);
		$json = json_decode($json, true);
		$json = array_merge($json, $forsave);
		$json = json_encode($json, JSON_PRETTY_PRINT);
		file_put_contents($json, $path);
	}
}


?>