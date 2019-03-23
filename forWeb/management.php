<?php


interface Management
{
  
  function getby($search=null, $info=null, $specific=false);
  function save($database, $object);
  function search($info, $parameter);
  function edit($id, $object);
}



?>
