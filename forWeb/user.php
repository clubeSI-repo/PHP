<?php

/*Json example for user and usermanagement class
{
    "5bfada9f10b23": {
        "id": "5bfada9f10b23",
        "name": "test test",
        "email": "tes23t@test",
        "gender": "M",
        "accountCreationDate": "25:11:2018",
        "userLevel": 0,
        "": null
    },
    "5dsadasd12321312": {
        "id": "5dsadasd12321312",
        "name": "test321231321",
        "email": "test@test",
        "gender": "M",
        "accountCreationDate": "25:11:2018",
        "userLevel": 0,
        "": null
    }
}


*/


class user
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

  /** 
  * @param string $json
  */
  function saveuser($json)
  {
    /*The function expects a object and query if exists one user with this ID
    if not, save new user with this id
      */
    $info = array();
    $array = (array) $this;
    $true = TRUE;
    if($users = file_get_contents($json) == NULL)
    {
      $users =  array( );
    }else{
      $users = file_get_contents($json);
      $users = json_decode($users, $true);
    }
    $info = $array;

    foreach ($users as $key => $value) 
    {
      if($value['email'] == $array['email'])
      {
        return false;
      }
    }


    $users[$this->id] = $info;
    $contentEncoded = json_encode($users, JSON_PRETTY_PRINT);
    file_put_contents($json, $contentEncoded);
    return true;

    }
}



class usermanagement
{
  public $users;
  public $json;
  function __construct($json)
  {
    if($json != null)
    {
      $true = TRUE;
      $content = file_get_contents($json);
      $this->users = (array) json_decode($content,$true);
      $this->json = $json;
  }
  }
  /** 
  * @param string $search
  * @param string $string
  * @param bool $string
  */
  function getusersby($search=null, $info=null, $specific=false)
  {
      /*the function expects an string to query the json for verify
      if one user exists with such information
      */
      $arrayUser = $this->users;

      foreach($arrayUser as $id => $conteudo) 
      {
        foreach ($conteudo as $nomeDados => $dados) 
        {
          if($specific == true)
          {
            if ($dados == $search AND $nomeDados == $info) 
            {
              $return[] = $conteudo;
            }
          }else{
            if ($dados == $search) 
            {
              $return[] = $conteudo;
            }
          }
        }
      }
  return $return;
  }

  function searchuser($info, $parameter)
  {
    foreach ($this->users as $key => $value) 
    {
      if ($value[$info] == $parameter) 
      {
        $return[] = $value;
      }
    }

    if ($return == null or $return == false)
    {
      return false;
    }else{
      return $return;
    }
  }

  function userverify($parameter)
  {
    if (is_null($this->searchuser('email', $parameter)== true)) 
    {
      $return = false;
    }else{
      $return = true;
    }
    return $return;
  }

  function getuserbyid($id)
  {
    /*Query JSON behind one user with this id,
    if it does not happen the function return false
    if this happen return the user array*/

    foreach ($this->users as $key => $value) {
        if ($key == $id) {
            $return = $value;
        }
    }
    if ($return == null or $return == false){
      return false;
    }else{
      return $return;
    }
  }


  function edituser($id, $user)
  {
    /*Get user by id and confer if not equals arrays in two variables,
    if not, the function update the user in json*/
    $user = (array) $user;
    $forEditUser = getuserbyid($id, 'id');
    if($user != $forEditUser){
      $this->users[$id] = $user;
      $contentEncoded = json_encode($this->$users, JSON_PRETTY_PRINT);
      file_put_contents($this->json, $contentEncoded);
    }else{
      return false;
    }
  }

}


/*
Json example for hash, require users.json for query

{
    "5bfada9f10b23": "098f6bcd4621d373cade4e832627b4f6",
    "5bfada9f10b23": "098f6bcd4621d373cade4e832627b4f6"
}

*/



class hash
{
  public $id;
  private $hashFile;
  private $password;
  function __construct($id, $hashFile, $password)
  {
    /*this object was created to facilitate the hashing and saving of system passwords*/ 
    $this->hashFile = $hashFile;
    $this->password = $password;
    $this->id = $id;
  }


  function hashing()
  {
    /*Verify if this user(the same as the object) has a password with link of your id, if false, save a new password for this id */ 
    $catch = file_get_contents($this->hashFile);
    $decoded = json_decode($catch, true);
    foreach ($decoded as $key => $value){
      if($this->$id == $key)
      {
        $exists = true;
        return $exists;
      }else{
        $exists = false;
      }
    }
    if($exists == false)
    {
      $hash = md5($this->$password);
      $decoded[$this->id] = $hash;
      $contenthash = json_encode($decoded, JSON_PRETTY_PRINT);
      file_put_contents($this->hashFile, $contenthash);
      return $exists;
    }
  }

  function verifyhash()
  {
    /*verify with hash in data if typed password is same of json, if true return true*/
    $catch = file_get_contents($this->hashFile);
    $decoded = json_decode($catch, true);
    foreach ($decoded as $key => $value) 
    {
      if ($key == $this->id AND $value === md5($this->password))
      {
        return true;
      }
    }
    return false;
  }
}
?>