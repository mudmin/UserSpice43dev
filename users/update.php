<?php
require_once 'init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
//if (!securePage($_SERVER['PHP_SELF'])){die();}
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
      <div class="col-sm-12"><br><br><br>
<?php
//demo migration
$update = '3GJYaKcqUtw7';
if(!in_array($update,$existing_updates)){
//fix vericodes

$u = $db->query("SELECT id FROM users")->results();
foreach($u as $me){
  $db->update('users',$me->id,['vericode'=>randomstring(15)]);
}
  logger(1,"System Updates","Reformatted existing vericodes");

  logger(1,"System Updates","Update $update successfully deployed.");
  $db->insert('updates',['migration'=>$update]);
  echo "Applied update ".$update."<br>";
  $count++;
}

$update = '3GJYaKcqUtz8';
if(!in_array($update,$existing_updates)){
//fix vericodes
$test = $db->query("SELECT * FROM users WHERE id = 1")->first();
if($test->vericode == '322418'){
$u = $db->query("SELECT id FROM users")->results();
foreach($u as $me){
  $db->update('users',$me->id,['vericode'=>randomstring(15)]);
}
  logger(1,"System Updates","Reformatted existing vericodes");

  logger(1,"System Updates","Update $update successfully deployed.");
}
  echo "Patched vericode vulnerability<br>";
  $db->insert('updates',['migration'=>$update]);
  echo "Applied update ".$update."<br>";
  $count++;
}

$update = '69qa8h6E1bzG';
if(!in_array($update,$existing_updates)){
//Change old logs to IP Logging
$db->query("UPDATE logs SET logtype = ? WHERE logtype = ? AND lognote LIKE ?",array("IP Logging","User","%blacklisted%attempted%visit"));
logger(1,"System Updates","Updated old Blacklisted logs to IP Logging type.");
//Add new DB field
$db->query("ALTER TABLE users ADD cloak_allowed tinyint(1) NOT NULL");
logger(1,"System Updates","Added cloaking to users.");
$db->insert('updates',['migration'=>$update]);
$count++;
}

$update = '2XQjsKYJAfn1';
if(!in_array($update,$existing_updates)){
$db->query("ALTER TABLE settings ADD force_notif tinyint(1)");
$db->query("ALTER TABLE settings ADD cron_ip varchar(255)");
$db->update("settings",1,['cron_ip'=>'off']);

echo "<font color='red'>For security reasons</font>, your cron jobs have been temporarily disabled.  Please visit <a href='cron_manager.php'>Cron Manager</a> for more information.<br>";
  logger(1,"System Updates","Update $update successfully deployed.");
  $db->insert('updates',['migration'=>$update]);
  echo "Applied update ".$update."<br>";
  $count++;
}

$update = '549DLFeHMNw7';
if(!in_array($update,$existing_updates)){
$db->query("UPDATE settings SET force_notif=0 WHERE force_notif IS NULL");
  logger(1,"System Updates","Updated force_notif to 0 if you had not set it already.");
  logger(1,"System Updates","Update $update successfully deployed.");
  $db->insert('updates',['migration'=>$update]);
  echo "Applied update ".$update."<br>";
  $count++;
}

$update = '4Dgt2XVjgz2x';
if(!in_array($update,$existing_updates)){
$db->query("ALTER TABLE settings ADD COLUMN registration tinyint(1)");
$db->query("UPDATE settings SET registration=1 WHERE id=1");
  logger(1,"System Updates","Added registration to settings.");
  logger(1,"System Updates","Update $update successfully deployed.");
  $db->insert('updates',['migration'=>$update]);

  $fields = array(
  'page'=>'users/enable2fa.php',
  'title'=>'Enable 2 Factor Auth',
  'private'=>1,
  );
  $i = $db->insert('pages',$fields);
  $id = $db->lastId();
  $fields = array(
    'permission_id'=>1,
    'page_id'=>$id,
  );
  $db->insert('permission_page_matches',$fields);
  $fields = array(
    'permission_id'=>2,
    'page_id'=>$id,
  );
  $db->insert('permission_page_matches',$fields);
  $fields = array(
  'page'=>'users/disable2fa.php',
  'title'=>'Enable 2 Factor Auth',
  'private'=>2,
  );
  $i = $db->insert('pages',$fields);
  $id = $db->lastId();
  $fields = array(
    'permission_id'=>1,
    'page_id'=>$id,
  );
  $db->insert('permission_page_matches',$fields);
  $fields = array(
    'permission_id'=>2,
    'page_id'=>$id,
  );
  $db->insert('permission_page_matches',$fields);

  echo "Applied update ".$update."<br>";
 $count++;
}


$update = 'VLBp32gTWvEo';
if(!in_array($update,$existing_updates)){

  $db->query("ALTER TABLE users ADD COLUMN vericode_expiry timestamp AFTER `vericode`");
  logger(1,"System Updates","Added Vericode Expiry to Users Table.");

  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Two Factor Authentication","users/twofa.php",""]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Disable 2 Factor Auth","users/disable2fa.php","Enable 2 Factor Auth"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Notifications Manager","users/admin_notifications.php","Admin Notifications"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["IP Manager","users/admin_ips.php","Admin IPs"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Menu Manager","users/admin_menu.php","Manage Menus"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Menu Manager","users/admin_menus.php","Manage Menus"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Menu Manager","users/admin_menu_item.php","Manage Menus"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Update Manager","users/update.php","Update UserSpice"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Logs Manager","users/admin_logs.php","Site Logs"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Logs Manager","users/admin_logs_exempt.php","Site Logs"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Logs Manager","users/admin_logs_manager.php","Site Logs"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Logs Manager","users/admin_logs_mapper.php","Site Logs"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Messages Manager","users/admin_messages.php","View Messages"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Messages Manager","users/admin_message.php","View Message"]);
  $db->query("UPDATE pages SET title=null WHERE page = ? and (title = ? OR title = null)",["users/cron_post.php","Post a Cron Job"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Password Verification","users/admin_verify.php","Verify Password"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Backup Manager","users/admin_backup.php","Backup Files"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Messages","users/messages.php","My Messages"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Messages","users/message.php","My Messages"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["User Settings","users/user_settings.php","My Settings"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["User Manager","users/admin_users.php","Manage Users"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["User Manager","users/admin_user.php","Manage User"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Permissions Manager","users/admin_permissions.php","Manage Permissions"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Permissions Manager","users/admin_permission.php","Manage Permission"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Pages Manager","users/admin_pages.php","Manage Pages"]);
  $db->query("UPDATE pages SET title=? WHERE page = ? and (title = ? OR title = null)",["Pages Manager","users/admin_page.php","Manage Page"]);
  logger(1,"System Updates","Reformatted exiting page titles only if they weren't modified.");

  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
 $count++;
}

//form tables
$update = '1XdrInkjV86F';
if(!in_array($update,$existing_updates)){
  $db->query("CREATE TABLE `us_form_views` (
    `id` int(11) NOT NULL,
    `form_name` varchar(255) NOT NULL,
    `view_name` varchar(255) NOT NULL,
    `fields` text NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

  $db->query("ALTER TABLE `us_form_views`
    ADD PRIMARY KEY (`id`)");

  $db->query("ALTER TABLE `us_form_views`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");

    $db->query("CREATE TABLE `us_form_validation` (
      `id` int(11) NOT NULL,
      `value` varchar(255) NOT NULL,
      `description` varchar(255) NOT NULL,
      `params` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

    $db->query("INSERT INTO `us_form_validation` (`id`, `value`, `description`, `params`) VALUES
    (1, 'min', 'Minimum # of Characters', 'number'),
    (2, 'max', 'Maximum # of Characters', 'number'),
    (3, 'is_numeric', 'Must be a number', 'true'),
    (4, 'valid_email', 'Must be a valid email address', 'true'),
    (5, '<', 'Must be a number less than', 'number'),
    (6, '>', 'Must be a number greater than', 'number'),
    (7, '<=', 'Must be a number less than or equal to', 'number'),
    (8, '>=', 'Must be a number greater than or equal to', 'number'),
    (9, '!=', 'Must not be equal to', 'text'),
    (10, '==', 'Must be equal to', 'text'),
    (11, 'is_integer', 'Must be an integer', 'true'),
    (12, 'is_timezone', 'Must be a valid timezone name', 'true'),
    (13, 'is_datetime', 'Must be a valid DateTime', 'true')");

    $db->query("ALTER TABLE `us_form_validation`
      ADD PRIMARY KEY (`id`)");

    $db->query("ALTER TABLE `us_form_validation`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");

    $db->query("CREATE TABLE `us_forms` (
      `id` int(11) NOT NULL,
      `form` varchar(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1");

    $db->query("ALTER TABLE `us_forms`
      ADD PRIMARY KEY (`id`)");

    $db->query("ALTER TABLE `us_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");

  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
 $count++;
}

//Add new pages
$update = 'Q3KlhjdtxE5X';
if(!in_array($update,$existing_updates)){

  $fields = array(
  'page'=>'users/admin_forms.php',
  'title'=>'Form Manager',
  'private'=>1,
  );
  $i = $db->insert('pages',$fields);
  $id = $db->lastId();
  $fields = array(
    'permission_id'=>2,
    'page_id'=>$id,
  );
  $db->insert('permission_page_matches',$fields);

  $fields = array(
  'page'=>'users/admin_form_views.php',
  'title'=>'Form View Manager',
  'private'=>1,
  );
  $i = $db->insert('pages',$fields);
  $id = $db->lastId();
  $fields = array(
    'permission_id'=>2,
    'page_id'=>$id,
  );

  $fields = array(
  'page'=>'users/edit_form.php',
  'title'=>'Form Editor',
  'private'=>1,
  );
  $i = $db->insert('pages',$fields);
  $id = $db->lastId();
  $fields = array(
    'permission_id'=>2,
    'page_id'=>$id,
  );

  $db->insert('permission_page_matches',$fields);

  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
 $count++;
}

//UPDATE TEMPLATE
// $update = '';
// if(!in_array($update,$existing_updates)){
//
//   $db->insert('updates',['migration'=>$update]);
//   logger(1,"System Updates","Update $update successfully deployed.");
//   echo "Applied update ".$update."<br>";
//  $count++;
// }



if($count == 1){
echo "Finished applying ".$count." update.<br>";
}else{
echo "Finished applying ".$count." updates.<br>";
}

if(isset($user) && $user->isLoggedIn()){
?>
<a href="admin.php">Return to the Admin Dashboard</a>
<?php }else{ ?>
<a href="login.php">Click here to login!</a>
<?php } ?>
</div></div></div></div>
