<?php

include "management.php";
class User 
{
  public $id;
  public $name;
  public $email;
  public $gender;
  public $accountCreationDate;
  public $userLevel;
  function __construct($parameters)
  {
      /*the object expects an array to be passed with the following items
          $id,$name,$email,$birthDate,$gender,$accountCreationDate,$userLevel
        */
    (string) $this->id = uniqid();
    (string) $this->name = $parameters['name'];
    (string) $this->email = $parameters['email'];
    (string) $this->gender = $parameters['gender'];
    (string) $this->$birthDate = $parameters['$birthDate'];
    (string) $this->accountCreationDate = $parameters['accountCreationDate'];
    $this->userLevel = $parameters['userLevel'];
    if (is_null($this->userLevel) == TRUE) 
    {
      $this->userLevel = null;
      $this->userLevel = 0;
    }
    if (is_null($parameters['accountCreationDate']) == TRUE or $this->accountCreationDate == "") 
    {
      $this->accountCreationDate = date("d:m:Y");
    }
  }


 
}




class Hash
{
  public $id;
  private $password;
  protected $hash;

  abstract function __construct($id, $password, $hash=NULL);


  function hashing()
  {
    $this->$hash = md5($this->$password);
    return $this->$hash;
  }

  function verifyhash()
  {
    if (md5($this->password == $hash)){
      return true;
    }
    else
    {
      return false;
    }
  }
}


?>