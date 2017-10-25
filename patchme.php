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
$_SESSION = array();
session_destroy();
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
//require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
$errors = $successes = [];?>
<div id="page-wrapper">

  <div class="container">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-sm-12">
        <?php
//:: Add "updates" table
echo "<br /><br />";
bold ("If you see any errors or warnings, these should go away after the process is complete");
if(Input::get('revert')==1) {
  $db->query("ALTER TABLE email DROP debug_level");
  $db->query("ALTER TABLE email DROP isHTML");
  $db->query("ALTER TABLE email DROP isSMTP");
  $db->query("ALTER TABLE email DROP useSMTPauth");
  $db->query("ALTER TABLE messages DROP archive_from");
  $db->query("ALTER TABLE messages DROP archive_to");
  $db->query("ALTER TABLE messages DROP hidden_from");
  $db->query("ALTER TABLE messages DROP hidden_to");
  $db->query("ALTER TABLE pages DROP re_auth");
  $db->query("ALTER TABLE pages DROP title");
  $db->query("ALTER TABLE settings DROP auto_assign_un");
  $db->query("ALTER TABLE settings DROP msg_default_to");
  $db->query("ALTER TABLE settings DROP msg_blocked_users");
  $db->query("ALTER TABLE settings DROP msg_notification");
  $db->query("ALTER TABLE settings DROP navigation_type");
  $db->query("ALTER TABLE settings DROP notifications");
  $db->query("ALTER TABLE settings DROP notif_daylimit");
  $db->query("ALTER TABLE settings DROP page_default_private");
  $db->query("ALTER TABLE settings DROP permission_restriction");
  $db->query("ALTER TABLE settings DROP page_permission_restriction");
  $db->query("ALTER TABLE settings DROP recap_private");
  $db->query("ALTER TABLE settings DROP recap_public");
  $db->query("ALTER TABLE settings DROP copyright");
  $db->query("ALTER TABLE settings DROP custom_settings");
  $db->query("ALTER TABLE users DROP dev_user");
  $db->query("ALTER TABLE users DROP email_new");
  $db->query("ALTER TABLE users DROP force_pr");
  $db->query("ALTER TABLE users DROP last_confirm");
  $db->query("ALTER TABLE users DROP msg_exempt");
  $db->query("ALTER TABLE users DROP msg_notifications");
  $db->query("ALTER TABLE users DROP protected");
$successes[] = "Rollback completed, <a href='?' class='nounderline'>click here</a> to begin preflight checks.";
resultBlock($errors,$successes);
}
if(!Input::get('continue')==1 && !Input::get('revert')==1) {
$sql1 = $db->query("SELECT table_name FROM information_schema.tables
WHERE table_schema = ? AND table_name IN
('crons','crons_logs','groups_menus','logs','logs_exempt','menus','mqtt','notifications','updates','us_ip_blacklist','us_ip_list','us_ip_whitelist')",array(Config::get('mysql/db')));
$count1 = $sql1->count();
$results1 = $sql1->results();
$db->query("DROP TABLE IF EXISTS `us_43_tables`");
$db->query("
CREATE TABLE IF NOT EXISTS `us_43_tables` (
  `table_column` varchar(255) NOT NULL
)");
$db->query("INSERT INTO us_43_tables (table_column)
SELECT CONCAT(TABLE_NAME,'/',COLUMN_NAME) AS table_column FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ?",array(Config::get('mysql/db')));
$sql2 = $db->query("SELECT * FROM us_43_tables WHERE table_column IN ('email/debug_level','email/isHTML','email/isSMTP','email/useSMTPauth','messages/archive_from','messages/archive_to','messages/hidden_from','messages/hidden_to','pages/re_auth','pages/title','settings/auto_assign_un','settings/msg_blocked_users','settings/msg_default_to','settings/msg_notification','settings/navigation_type','settings/notif_daylimit','settings/notifications','settings/page_default_private','settings/page_permission_restriction','settings/permission_restriction','settings/recap_private','settings/recap_public','settings/copyright','settings/custom_settings','users/dev_user','users/email_new','users/force_pr','users/last_confirm','users/msg_exempt','users/msg_notifications','users/protected');");
$count2 = $sql2->count();
$results2 = $sql2->results();
$db->query("DROP TABLE us_43_tables");
$search = "require_once 'classes/class.autoloader.php';";
$lines = file('users/init.php');
$count3=0;
foreach($lines as $line)
{
  if(strpos($line, $search)!==false) { $count3=1; }
}
if(($count1+$count2)>0 || $count3==0) {?>
  <div class="alert alert-danger"><?php if($count1>0) {?><strong>The following tables exist</strong>...if you continue the flight, they will be dropped and all data will be lost!
    <ul>
      <?php foreach ($results1 as $row) {?>
      <li><?=$row->table_name?></li>
    <?php } ?>
  </ul><?php } if($count2>0) {?>
    <strong>The following tables/columns exist</strong>...you cannot continue as the migration process will break. Please remove the columns and refresh. You can also <a href="?revert=1" class="nounderline">click here</a> to run the rollback script which will remove all of these items.
      <ul>
        <?php foreach ($results2 as $row) {?>
        <li><?=$row->table_column?></li>
      <?php }?>
    </ul><?php } if($count3==0) {?>
      <strong>Your init.php file needs to be manually patched</strong>...please add the following line at the top of your users/init.php file:
        <ul>
          <li>require_once 'classes/class.autoloader.php';</li>
      </ul>
      You must also:
      <ul>
        <li>Remove all of the classes except users/helpers/helpers (approx lines 60-71)</li>
        <li>Remove the Stripe Keys if you are not actively using them in your project (approx lines 54-58)</li>
        <li>Remove the Copyright Message and Recapatcha Keys (approx lines 43-47)</li>
      </ul>
      <strong>You cannot</strong> continue with this patch until this is complete...
    <?php } ?>
  </div>
<?php } ?>
<center><a href="?" style="padding-left: 10px" class="btn btn-success nounderline"><i class="glyphicon glyphicon-refresh"></i> Refresh</a> <a href="?continue=1" class="btn btn-<?php if($count1>0) {?>danger<?php } else {?>success<?php } ?> nounderline" <?php if($count2>0 || $count3==0) {?>disabled<?php } ?>>Preflight check done...click here to continue.</a></center><br />
<?php } if(Input::get('continue')==1) {
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
//Update settings table
   $table_settings = $db->query("ALTER TABLE `settings` ADD `auto_assign_un` INT(1) NOT NULL DEFAULT '0' AFTER `backup_table`, ADD `msg_default_to` INT(1) NOT NULL DEFAULT '1' AFTER `auto_assign_un`, ADD `msg_notification` INT(1) NOT NULL DEFAULT '0' AFTER `msg_default_to`, ADD `msg_blocked_users` INT(1) NOT NULL DEFAULT '0' AFTER `msg_notification`, ADD `notifications` INT(1) NOT NULL DEFAULT '0' AFTER `msg_blocked_users`, ADD `notif_daylimit` INT(3) NOT NULL DEFAULT '7' AFTER `notifications`, ADD `page_default_private` INT(1) NOT NULL DEFAULT '1' AFTER `notif_daylimit`, ADD `permission_restriction` INT(1) NOT NULL DEFAULT '0' AFTER `page_default_private`, ADD `page_permission_restriction` INT(1) NOT NULL DEFAULT '0' AFTER `permission_restriction`, ADD `recap_public` VARCHAR(100) NOT NULL AFTER `page_permission_restriction`, ADD `recap_private` VARCHAR(100) NOT NULL AFTER `recap_public`, ADD `navigation_type` int(1) NOT NULL DEFAULT '0' AFTER `recap_private`, ADD `copyright` VARCHAR(255) NOT NULL DEFAULT 'UserSpice', ADD `custom_settings` INT(1) NOT NULL DEFAULT '1';");
   $successes[] = "Updated settings table.";
resultBlock($errors,$successes);
bold ("<br>First step complete. Please <a href='users/update.php' class='nounderline'>click here</a> to proceed to the main patch."); }
?>
</div></div></div></div>
