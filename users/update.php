<?php
require_once '../users/init.php';
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

$update = 'qbQsBNQ82Q59';
if(!in_array($update,$existing_updates)){
  $db->query("CREATE TABLE IF NOT EXISTS fingerprints (
  kFingerprintID int(11) NOT NULL,
  fkUserID int(11) NOT NULL,
  Fingerprint varchar(32) NOT NULL,
  Fingerprint_Expiry datetime NOT NULL,
  PRIMARY KEY (kFingerprintID)
  );");
  $db->query("ALTER TABLE fingerprints
      MODIFY COLUMN kFingerprintID int(11) NOT NULL AUTO_INCREMENT;");
  logger(1,"System Updates","Created table fingerprints");

  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
 $count++;
}

$update = 'ug5D3pVrNvfS';
if(!in_array($update,$existing_updates)){
  $db->query("ALTER TABLE settings
    ADD COLUMN join_vericode_expiry int(9) UNSIGNED NOT NULL,
    ADD COLUMN reset_vericode_expiry int(9) UNSIGNED NOT NULL");
  $db->query("UPDATE settings SET settings.join_vericode_expiry=24,reset_vericode_expiry=15 WHERE id=1");
  logger(1,"System Updates","Added join_vericode_expiry and reset_vericode_expiry to settings table.");
  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
 $count++;
}

$update = 'V6R8xNxJj47h';
if(!in_array($update,$existing_updates)){
  $db->query("CREATE TABLE Fingerprints_Assets (
    kFingerprintAssetID int(11) NOT NULL,
    fkFingerprintID int(11) NOT NULL,
    IP_Address varchar(255) NOT NULL,
    User_Agent varchar(255) NOT NULL,
    PRIMARY KEY (kFingerprintAssetID)
)");
  $db->query("ALTER TABLE Fingerprints_Assets
    MODIFY COLUMN kFingerprintAssetID int(11) NOT NULL AUTO_INCREMENT");
    $db->query("ALTER TABLE Fingerprints
    ADD COLUMN Fingerprint_Added timestamp DEFAULT CURRENT_TIMESTAMP()");
  logger(1,"System Updates","Added Fingerprint Assets table and Fingerprint_Added to Fingerprints table");
  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
 $count++;
}

$update = '69FbVbv4Jtrz';
if(!in_array($update,$existing_updates)){
  $db->query("ALTER TABLE users
    ADD COLUMN pin varchar(255) DEFAULT NULL AFTER `password`");
  $db->query("ALTER TABLE settings
    ADD COLUMN admin_verify tinyint(1) NOT NULL,
    ADD COLUMN admin_verify_timeout int(9) NOT NULL");
    $db->query("UPDATE settings SET admin_verify=1,settings.admin_verify_timeout=120 WHERE id=1");
    $db->insert('pages',['page' => 'users/admin_pin.php','title' => 'Verification PIN Set','re_auth'=>0,'private'=>1]);
    $db->insert('permission_page_matches',['permission_id' => 1,'page_id' => $db->lastId()]);
    $db->insert('pages',['page' => 'users/manage2fa.php','title' => 'Manage Two FA','re_auth'=>0,'private'=>1]);
    $db->insert('permission_page_matches',['permission_id' => 1,'page_id' => $db->lastId()]);
  logger(1,"System Updates","Added pin to users, admin_verify and admin_verify_timeout to settings");
  logger(1,"System Updates","Added admin_pin page to pages table");
  $db->insert('updates',['migration'=>$update]);
  logger(1,"System Updates","Update $update successfully deployed.");
  echo "Applied update ".$update."<br>";
 $count++;
}

$update = '4A6BdJHyvP4a';
if(!in_array($update,$existing_updates)){
  $db->query("ALTER TABLE users
    ADD COLUMN twoDate datetime DEFAULT NULL AFTER `twoEnabled`");
  logger(1,"System Updates","Added twoDate to users");
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
