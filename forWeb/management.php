<?php


class Management
{
  protected $database;
  abstract function __construct($database);
  abstract function getby($search=null, $info=null, $specific=false);
  abstract function save($database, $object);
  abstract function search($info, $parameter);
  abstract function edit($id, $object);
}



?>
