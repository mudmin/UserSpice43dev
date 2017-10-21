<?php
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::://
//::
//:: UserSpice 4.3.0 'updates' Patch
//::
//:: This will patch your database for the built in updates system
//:: and add the new required settings to avoid errors
//::
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::://
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
$errors = $successes = [];
//:: Add "updates" table
bold ("If you see any errors or warnings, these should go away after the process is complete");
$drop = $db->query("DROP TABLE IF EXISTS `updates`");
$create = $db->query("CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(15) NOT NULL,
  `applied_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))");
  $successes[] = "Created updates table.";
$count = $db->query("SELECT id FROM pages WHERE page = ?",array("users/update.php"))->count();
if($count==0) {
$pages_update = array('page' => "users/update.php",'private' => 0);
$pages_update_db = $db->insert("pages",$pages_update);
$successes[] = "Inserted to pages table.";
}
if($count>0) {
  $pages_update = $db->query("UPDATE pages SET private = ? WHERE page = ?",array(0,"users/update.php"));
  $successes[] = "Updated pages table.";
}
resultBlock($errors,$successes);
bold ("<br><br>First step complete. Please <a href='users/update.php' class='nounderline'>click here</a> to proceed to the main patch.");
?>
