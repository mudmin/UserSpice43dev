<?php  

require_once 'init.php';
$db = DB::getInstance();
if (!securePage($_SERVER['PHP_SELF'])){die();}
$name = Input::get('name');
$pk = Input::get('pk');
$value = Input::get('value');
$fields = array($name => $value);
$select = $db->query("SELECT * FROM crons WHERE id = ?",array($pk));
$results = $select->first();
$db->update('crons',$pk,$fields);
 ?>