<?php

class review{
  protected $idReviews;
  public $title;
  public $author;
  protected $idAuthor;
  public $text;
  public $date;
  public $rating;
  public $noLoginVote;
  public $loginVote;
  public $views;
  public $images;

  function __construct($review=NULL)
  {
    if($review!= NULL)
    {
      $this->idReviews=uniqid();
      $this->$title = $review['title'];
      $this->$author = $review['author'];
      $this->$idAuthor = $review['idAuthor'];
      $this->$text = $review['text'];
      $this->$date = $review['date'];
      $this->$rating = $review['rating'];
      $this->$noLoginVote = $review['noLoginVote'];
      $this->$loginVote = $review['loginVote'];
      $this->$views = $review['views'];
      $this->$images = $review['images'];
      if (is_null($this->date) == TRUE) {
          $this->date = date("d:m:Y");
      }
    }
  }




  function gettext()
  {
    $text = file_get_contents($this->$text);
    return $text;
  }





}


class reviewmanagement extends review{
  protected $contentEncoded;

  function __construct($json){
    $review = file_get_contents($json);
    $this->$contentEncoded = json_decode($review, true);
  }
  


  function savereview($json)
  {
    /*The function expects a object and query if exists one user with this ID
    if not, save new user with this id
    */
    $review[$this->idReviews] = (array) $this;
    $contentEncoded = json_encode($review);
    file_put_contents($json, $contentEncoded);
    }
  }

  function getreview($searchID, $json)
  {
    $return = NULL;
    $true = TRUE;
    $review = file_get_contents($json);
    $review = json_decode($review, $true);

    foreach ($review as $key => $value) 
    {
        if ($key == $searchID) {
            $return = $value;
        }
    }
    if ($return == null or $return == false)
    {
      return false;
    }else{
      return $return;
    }
    }

    
    function getreviewby($json, $search=1, $info='all')
    {
      $true = TRUE;
      $review = file_get_contents($json);
      $reviewArray = json_decode($review, $true);
      foreach($reviewArray as $id => $conteudo){
        foreach ($conteudo as $nome => $dados){

        if ($dados == $search AND $nome == $info) 
        {
          $return[] = $conteudo;
        }
      }
    }
    return $return;
    }




  function editreview($id,$json,$review)
  {
    $review = (array) $review;
    $reviews = file_get_contents($json);
    $reviews = json_decode($reviews, $true);
    $forEditeReview = getreviewby($json, $id, 'id');
    if($review!=$forEditeReview)
    {
      $review[$this->idReviews] = $info;
      $contentEncoded = json_encode($reviews);
      file_put_contents($json, $contentEncoded);
    }
  }
?>
