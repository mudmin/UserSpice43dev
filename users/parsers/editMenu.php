<?php
//NOTE: This also serves as the reference file for how to do One Click Edit with UserSpice. See comments below.
  require_once '../init.php';
  $db = DB::getInstance();
  $resp = ['success'=>false];

  $id = Input::get('id');
  $field = Input::get('field');
  $value = Input::get('value');

//decide what table you want to update. In this case, it's mqtt.
  $db->update('menus',$id,[$field=>$value]);
    $resp['msg'] = 'Server Info Updated';

  $resp['success'] = true;

  echo json_encode($resp);
  exit;
?>
