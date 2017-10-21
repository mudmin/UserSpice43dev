<?php
require_once 'init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}
$count = 0;
$updates = $db->query("SELECT * FROM updates")->results();
$existing_updates=[];
foreach($updates as $u){
  $existing_updates[] = $u->migration;
}
?>
<div id="page-wrapper">

  <div class="container">

    <!-- Page Heading -->
    <div class="row">
      <div class="col-sm-12">
<?php
//demo migration
$update = '3GJYaKcqUtw7';
if(!in_array($update,$existing_updates)){
//Create logs table
  $table_logs_drop = $db->query("DROP TABLE IF EXISTS `logs`");
  $table_logs = $db->query("CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(3) NOT NULL,
  `logdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `logtype` varchar(25) NOT NULL,
  `lognote` text NOT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","Update $update beginning deployment.");
  logger(1,"System Updates","logs Table Created.");

//Create crons table
  $table_crons_drop = $db->query("DROP TABLE IF EXISTS `crons`");
  $table_crons = $db->query("CREATE TABLE IF NOT EXISTS `crons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` int(1) NOT NULL DEFAULT '1',
  `sort` int(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","crons Table Created.");
//Insert crons table data
  $fields_crons = array(
    'active' => 0,
    'sort' => 100,
    'name' => "Auto-Backup",
    'file' => "backup.php",
    'createdby' => 1);
  $fields_cron_insert = $db->insert("crons",$fields_crons);
  logger(1,"System Updates","crons Data Inserted.");
//Insert crons_logs table
  $table_crons_logs_drop = $db->query("DROP TABLE IF EXISTS `crons_logs`");
  $table_crons_logs = $db->query("CREATE TABLE IF NOT EXISTS `crons_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cron_id` int(11) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","crons_logs Table Created.");
//Update email table
  $table_email = $db->query("ALTER TABLE `email` ADD `debug_level` INT(1) NOT NULL DEFAULT '0' AFTER `email_act`, ADD `isSMTP` INT(1) NOT NULL DEFAULT '0' AFTER `debug_level`, ADD `isHTML` VARCHAR(5) NOT NULL DEFAULT 'true' AFTER `isSMTP`, ADD `useSMTPauth` VARCHAR(6) NOT NULL DEFAULT 'true' AFTER `isHTML`;");
  logger(1,"System Updates","Added debug_level, isSMTP, isHTML, useSMTPauth to email table.");
//Insert groups_menus table
  $table_groups_menus_drop = $db->query("DROP TABLE IF EXISTS `groups_menus`");
  $table_groups_menus = $db->query("CREATE TABLE IF NOT EXISTS `groups_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(15) NOT NULL,
  `menu_id` int(15) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `menu_id` (`menu_id`))");
  logger(1,"System Updates","groups_menus Table Created.");
//Insert groups_menus table data
  $fields_groups_menus_insert = $db->query("INSERT INTO `groups_menus` (`group_id`, `menu_id`) VALUES
  (0, 4),(1, 4),(3, 4),(0, 5),(0, 3),(0, 1),(0, 2),(0, 51),(0, 52),(0, 37),(0, 38),(2, 39),(2, 40),(2, 41),(2, 42),(2, 43),(2, 44),(2, 45),(0, 46),(0, 47),(0, 49);");
  logger(1,"System Updates","groups_menus Data Inserted.");
//Insert logs_exempt table
  $table_logs_exempt_drop = $db->query("DROP TABLE IF EXISTS `logs_exempt`");
  $table_logs_exempt = $db->query("CREATE TABLE IF NOT EXISTS `logs_exempt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `createdby` int(11) NOT NULL,
  `created` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `logs_exempt_type` (`name`))");
  logger(1,"System Updates","logs_exempt Table Created.");
//Insert menus table
  $table_menus_drop = $db->query("DROP TABLE IF EXISTS `menus`");
  $table_menus = $db->query("CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_title` varchar(255) NOT NULL,
  `parent` int(10) NOT NULL,
  `dropdown` int(1) NOT NULL,
  `logged_in` int(1) NOT NULL,
  `display_order` int(10) NOT NULL,
  `label` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `icon_class` varchar(255) NOT NULL,
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","menus Table Created.");
//Insert menus table data
  $fields_menus_insert = $db->query("INSERT INTO `menus` (`menu_title`, `parent`, `dropdown`, `logged_in`, `display_order`, `label`, `link`, `icon_class`) VALUES
  ('main', 2, 0, 1, 1, 'Home', '', 'fa fa-fw fa-home'),
  ('main', -1, 1, 1, 14, '', '', 'fa fa-fw fa-cogs'),
  ('main', -1, 0, 1, 11, '{{username}}', 'users/account.php', 'fa fa-fw fa-user'),
  ('main', -1, 1, 0, 3, 'Help', '', 'fa fa-fw fa-life-ring'),
  ('main', -1, 0, 0, 2, 'Register', 'users/join.php', 'fa fa-fw fa-plus-square'),
  ('main', -1, 0, 0, 1, 'Log In', 'users/login.php', 'fa fa-fw fa-sign-in'),
  ('main', 2, 0, 1, 2, 'Account', 'users/account.php', 'fa fa-fw fa-user'),
  ('main', 2, 0, 1, 3, '{{hr}}', '', ''),
  ('main', 2, 0, 1, 4, 'Admin Dashboard', 'users/admin.php', 'fa fa-fw fa-cogs'),
  ('main', 2, 0, 1, 5, 'User Management', 'users/admin_users.php', 'fa fa-fw fa-user'),
  ('main', 2, 0, 1, 6, 'Permissions Manager', 'users/admin_permissions.php', 'fa fa-fw fa-lock'),
  ('main', 2, 0, 1, 7, 'Page Management', 'users/admin_pages.php', 'fa fa-fw fa-wrench'),
  ('main', 2, 0, 1, 8, 'Messages Manager', 'users/admin_messages.php', 'fa fa-fw fa-envelope'),
  ('main', 2, 0, 1, 9, 'System Logs', 'users/admin_logs.php', 'fa fa-fw fa-search'),
  ('main', 2, 0, 1, 10, '{{hr}}', '', ''),
  ('main', 2, 0, 1, 11, 'Logout', 'users/logout.php', 'fa fa-fw fa-sign-out'),
  ('main', -1, 0, 0, 0, 'Home', '', 'fa fa-fw fa-home'),
  ('main', -1, 0, 1, 10, 'Home', '', 'fa fa-fw fa-home'),
  ('main', 6, 0, 0, 1, 'Forgot Password', 'users/forgot_password.php', 'fa fa-fw fa-wrench'),
  ('main', -1, 0, 1, 12, '{{notifications}}', '', ''),
  ('main', -1, 0, 1, 13, '{{messages}}', '', '');");
  logger(1,"System Updates","menus Data Inserted.");
//Update message_threads table
  $table_message_threads = $db->query("ALTER TABLE `message_threads` ADD `archive_from` INT(1) NOT NULL DEFAULT '0' AFTER `last_update_by`, ADD `archive_to` INT(1) NOT NULL DEFAULT '0' AFTER `archive_from`, ADD `hidden_from` INT(1) NOT NULL DEFAULT '0' AFTER `archive_to`, ADD `hidden_to` INT(1) NOT NULL DEFAULT '0' AFTER `hidden_from`;");
  logger(1,"System Updates","Added archive_from, archive_to, hidden_from, hidden_to to message_threads table.");
//Insert mqtt table
  $table_mqtt_drop = $db->query("DROP TABLE IF EXISTS `mqtt`");
  $table_mqtt = $db->query("CREATE TABLE IF NOT EXISTS `mqtt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nickname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","mqtt Table Created.");
//Insert mqtt table data
  $fields_mqtt = array(
  'server' => "192.168.0.222",
  'port' => 1883,
  'username' => "",
  'password' => "",
  'nickname' => "Rasperberry PI MQTT2");
  $db->insert("mqtt",$fields_mqtt);
  logger(1,"System Updates","mqtt Data Inserted.");
//Insert notifications table
  $table_notifications_drop = $db->query("DROP TABLE IF EXISTS `notifications`");
  $table_notifications = $db->query("CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` mediumtext NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `is_archived` tinyint(1) DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_read` datetime NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","notifications Table Created.");
//Update pages table
  $table_pages = $db->query("ALTER TABLE `pages` ADD `title` VARCHAR(50) NOT NULL AFTER `private`, ADD `re_auth` INT(1) NOT NULL DEFAULT '0' AFTER `title`;");
  logger(1,"System Updates","Added title and re_auth to pages table.");
//Update settings table
   $table_settings = $db->query("ALTER TABLE `settings` ADD `auto_assign_un` INT(1) NOT NULL DEFAULT '0' AFTER `backup_table`, ADD `msg_default_to` INT(1) NOT NULL DEFAULT '1' AFTER `auto_assign_un`, ADD `msg_notification` INT(1) NOT NULL DEFAULT '0' AFTER `msg_default_to`, ADD `msg_blocked_users` INT(1) NOT NULL DEFAULT '0' AFTER `msg_notification`, ADD `notifications` INT(1) NOT NULL DEFAULT '0' AFTER `msg_blocked_users`, ADD `notif_daylimit` INT(3) NOT NULL DEFAULT '7' AFTER `notifications`, ADD `page_default_private` INT(1) NOT NULL DEFAULT '1' AFTER `notif_daylimit`, ADD `permission_restriction` INT(1) NOT NULL DEFAULT '0' AFTER `page_default_private`, ADD `page_permission_restriction` INT(1) NOT NULL DEFAULT '0' AFTER `permission_restriction`, ADD `recap_public` VARCHAR(100) NOT NULL AFTER `page_permission_restriction`, ADD `recap_private` VARCHAR(100) NOT NULL AFTER `recap_public`, ADD `navigation_type` int(1) NOT NULL DEFAULT '0' AFTER `recap_private`;");
  logger(1,"System Updates","Added new settings to settings table.");
//Update recap keys
  $table_settings_recap = array('recap_public' => "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI",'recap_private' => "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe");
  $table_settings_recap_update = $db->update("settings",1,$table_settings_recap);
  logger(1,"System Update","Set recap keys to the testing keys");
//Update users table
  $table_users = $db->query("ALTER TABLE `users` ADD `email_new` VARCHAR(155) NOT NULL AFTER `email`, ADD `dev_user` INT(1) NOT NULL DEFAULT '0' AFTER `un_changed`, ADD `force_pr` INT(1) NOT NULL DEFAULT '0' AFTER `dev_user`, ADD `last_confirm` DATETIME NULL DEFAULT NULL AFTER `force_pr`, ADD `msg_exempt` INT(1) NOT NULL DEFAULT '0' AFTER `last_confirm`, ADD `msg_notifications` INT(1) NOT NULL DEFAULT '0' AFTER `msg_exempt`, ADD `protected` INT(1) NOT NULL DEFAULT '0' AFTER `msg_notifications`;");
  logger(1,"System Updates","Added dev_user,email_new,force_pr,last_confirm,msg_exempt,msg_notification,protected to users table.");
//Insert us_ip_blacklist
  $table_us_ip_blacklist_drop = $db->query("DROP TABLE IF EXISTS us_ip_blacklist");
  $table_us_ip_blacklist = $db->query("CREATE TABLE IF NOT EXISTS `us_ip_blacklist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `last_user` int(11) NOT NULL DEFAULT '0',
  `reason` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","us_ip_blacklist Table Created.");
//Insert us_ip_list
  $table_us_ip_list_drop = $db->query("DROP TABLE IF EXISTS us_ip_list");
  $table_us_ip_list = $db->query("CREATE TABLE IF NOT EXISTS `us_ip_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`))");
  logger(1,"System Updates","us_ip_list Table Created.");
//Insert us_ip_whitelist
  $table_us_ip_whitelist_drop = $db->query("DROP TABLE IF EXISTS us_ip_whitelist");
  $table_us_ip_whitelist = $db->query("CREATE TABLE IF NOT EXISTS `us_ip_whitelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`))");
//END OF UPDATE SEQUENCE
  logger(1,"System Updates","us_ip_whitelist Table Created.");
  $pages_update = $db->query("UPDATE pages SET private = ? WHERE page = ?",array(1,"users/update.php"));
  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
  $count++;
}
if($count == 1){
echo "Finished applying ".$count." update.<br>";
}else{
echo "Finished applying ".$count." updates.<br>";
}
?>
<a href="admin.php">Return to the Admin Dashboard</a>
</div></div></div></div>
