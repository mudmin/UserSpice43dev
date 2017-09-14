<?php
/*
UserSpice 4
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php require_once 'init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>
<link href="css/admin-tabs.css" rel="stylesheet">
<?php
$pagePermissions = fetchPagePermissions(4);
$tab = Input::get('tab');

// To make this panel super admin only, uncomment out the lines below
// if($user->data()->id !='1'){
//   Redirect::to('account.php');
// }

//PHP Goes Here!
delete_user_online(); //Deletes sessions older than 24 hours

//Find users who have logged in in X amount of time.
$date = date("Y-m-d H:i:s");

$hour = date("Y-m-d H:i:s", strtotime("-1 hour", strtotime($date)));
$today = date("Y-m-d H:i:s", strtotime("-1 day", strtotime($date)));
$week = date("Y-m-d H:i:s", strtotime("-1 week", strtotime($date)));
$month = date("Y-m-d H:i:s", strtotime("-1 month", strtotime($date)));

$last24=time()-86400;

$recentUsersQ = $db->query("SELECT * FROM users_online WHERE timestamp > ? ORDER BY timestamp DESC",array($last24));
$recentUsersCount = $recentUsersQ->count();
$recentUsers = $recentUsersQ->results();

$usersHourQ = $db->query("SELECT * FROM users WHERE last_login > ?",array($hour));
$usersHour = $usersHourQ->results();
$hourCount = $usersHourQ->count();

$usersTodayQ = $db->query("SELECT * FROM users WHERE last_login > ?",array($today));
$dayCount = $usersTodayQ->count();
$usersDay = $usersTodayQ->results();

$usersWeekQ = $db->query("SELECT username FROM users WHERE last_login > ?",array($week));
$weekCount = $usersWeekQ->count();

$usersMonthQ = $db->query("SELECT username FROM users WHERE last_login > ?",array($month));
$monthCount = $usersMonthQ->count();

$usersQ = $db->query("SELECT * FROM users");
$user_count = $usersQ->count();

$pagesQ = $db->query("SELECT * FROM pages");
$page_count = $pagesQ->count();

$levelsQ = $db->query("SELECT * FROM permissions");
$level_count = $levelsQ->count();

$settingsQ = $db->query("SELECT * FROM settings");
$settings = $settingsQ->first();

$tomC = $db->query("SELECT * FROM audit")->count();

if(!empty($_POST['settings'])){
	$token = $_POST['csrf'];
	if(!Token::check($token)){
		die('Token doesn\'t match!');
	}

	if($settings->recaptcha != $_POST['recaptcha']) {
		$recaptcha = Input::get('recaptcha');
		$fields=array('recaptcha'=>$recaptcha);
		$db->update('settings',1,$fields);
	}

	if($settings->messaging != $_POST['messaging']) {
		$messaging = Input::get('messaging');
		$fields=array('messaging'=>$messaging);
		$db->update('settings',1,$fields);
	}

	if($settings->echouser != $_POST['echouser']) {
		$echouser = Input::get('echouser');
		$fields=array('echouser'=>$echouser);
		$db->update('settings',1,$fields);
	}

	if($settings->wys != $_POST['wys']) {
		$wys = Input::get('wys');
		$fields=array('wys'=>$wys);
		$db->update('settings',1,$fields);
	}

	if($settings->site_name != $_POST['site_name']) {
		$site_name = Input::get('site_name');
		$fields=array('site_name'=>$site_name);
		$db->update('settings',1,$fields);
	}

	// if($settings->login_type != $_POST['login_type']) {
	// 	$login_type = Input::get('login_type');
	// 	$fields=array('login_type'=>$login_type);
	// 	$db->update('settings',1,$fields);
	// }

	if($settings->force_ssl != $_POST['force_ssl']) {
		$force_ssl = Input::get('force_ssl');
		$fields=array('force_ssl'=>$force_ssl);
		$db->update('settings',1,$fields);
	}

	if( $_POST['force_user_pr'] == 1) {
		$db->query("UPDATE users SET force_pr = 1");
		$successes[] = "Requiring all users to reset their password.";
	}
	if($settings->force_pr != $_POST['force_pr']) {
		$force_pr = Input::get('force_pr');
		$fields=array('force_pr'=>$force_pr);
		$db->update('settings',1,$fields);
	}

	if($settings->site_offline != $_POST['site_offline']) {
		$site_offline = Input::get('site_offline');
		$fields=array('site_offline'=>$site_offline);
		$db->update('settings',1,$fields);
	}
	if($settings->track_guest != $_POST['track_guest']) {
		$track_guest = Input::get('track_guest');
		$fields=array('track_guest'=>$track_guest);
		$db->update('settings',1,$fields);
	}

	if($settings->auto_assign_un != $_POST['auto_assign_un']) {
		$auto_assign_un = Input::get('auto_assign_un');
		if(empty($auto_assign_un)) { $auto_assign_un==0; }
		$fields=array('auto_assign_un'=>$auto_assign_un);
		$db->update('settings',1,$fields);
	}

	if($settings->msg_notification != $_POST['msg_notification']) {
		$msg_notification = Input::get('msg_notification');
		if(empty($msg_notification)) { $msg_notification==0; }
		$fields=array('msg_notification'=>$msg_notification);
		$db->update('settings',1,$fields);
	}

	if($settings->permission_restriction != $_POST['permission_restriction']) {
		$permission_restriction = Input::get('permission_restriction');
		if(empty($permission_restriction)) { $permission_restriction==0; }
		$fields=array('permission_restriction'=>$permission_restriction);
		$db->update('settings',1,$fields);
	}

	if($settings->page_permission_restriction != $_POST['page_permission_restriction']) {
		$page_permission_restriction = Input::get('page_permission_restriction');
		if(empty($page_permission_restriction)) { $page_permission_restriction==0; }
		$fields=array('page_permission_restriction'=>$page_permission_restriction);
		$db->update('settings',1,$fields);
	}

	Redirect::to('admin.php?tab='.$tab);
}

if(!empty($_POST['css'])){
	if($settings->css_sample != $_POST['css_sample']) {
		$css_sample = Input::get('css_sample');
		$fields=array('css_sample'=>$css_sample);
		$db->update('settings',1,$fields);
	}

	if($settings->us_css1 != $_POST['us_css1']) {
		$us_css1 = Input::get('us_css1');
		$fields=array('us_css1'=>$us_css1);
		$db->update('settings',1,$fields);
	}
	if($settings->us_css2 != $_POST['us_css2']) {
		$us_css2 = Input::get('us_css2');
		$fields=array('us_css2'=>$us_css2);
		$db->update('settings',1,$fields);
	}

	if($settings->us_css3 != $_POST['us_css3']) {
		$us_css3 = Input::get('us_css3');
		$fields=array('us_css3'=>$us_css3);
		$db->update('settings',1,$fields);
	}
	Redirect::to('admin.php?tab='.$tab);
}

if(!empty($_POST['social'])){

	if($settings->change_un != $_POST['change_un']) {
		$change_un = Input::get('change_un');
		$fields=array('change_un'=>$change_un);
		$db->update('settings',1,$fields);
	}

	if($settings->req_cap != $_POST['req_cap']) {
		$req_cap = Input::get('req_cap');
		$fields=array('req_cap'=>$req_cap);
		$db->update('settings',1,$fields);
	}

	if($settings->req_num != $_POST['req_num']) {
		$req_num = Input::get('req_num');
		$fields=array('req_num'=>$req_num);
		$db->update('settings',1,$fields);
	}

	if($settings->min_pw != $_POST['min_pw']) {
		$min_pw = Input::get('min_pw');
		$fields=array('min_pw'=>$min_pw);
		$db->update('settings',1,$fields);
	}

	if($settings->max_pw != $_POST['max_pw']) {
		$max_pw = Input::get('max_pw');
		$fields=array('max_pw'=>$max_pw);
		$db->update('settings',1,$fields);
	}

	if($settings->min_un != $_POST['min_un']) {
		$min_un = Input::get('min_un');
		$fields=array('min_un'=>$min_un);
		$db->update('settings',1,$fields);
	}

	if($settings->max_un != $_POST['max_un']) {
		$max_un = Input::get('max_un');
		$fields=array('max_un'=>$max_un);
		$db->update('settings',1,$fields);
	}

	if($settings->glogin != $_POST['glogin']) {
		$glogin = Input::get('glogin');
		$fields=array('glogin'=>$glogin);
		$db->update('settings',1,$fields);
	}

	if($settings->fblogin != $_POST['fblogin']) {
		$fblogin = Input::get('fblogin');
		$fields=array('fblogin'=>$fblogin);
		$db->update('settings',1,$fields);
	}

	if($settings->gid != $_POST['gid']) {
		$gid = Input::get('gid');
		$fields=array('gid'=>$gid);
		$db->update('settings',1,$fields);
	}

	if($settings->gsecret != $_POST['gsecret']) {
		$gsecret = Input::get('gsecret');
		$fields=array('gsecret'=>$gsecret);
		$db->update('settings',1,$fields);
	}

	if($settings->gredirect != $_POST['gredirect']) {
		$gredirect = Input::get('gredirect');
		$fields=array('gredirect'=>$gredirect);
		$db->update('settings',1,$fields);
	}

	if($settings->ghome != $_POST['ghome']) {
		$ghome = Input::get('ghome');
		$fields=array('ghome'=>$ghome);
		$db->update('settings',1,$fields);
	}

	if($settings->fbid != $_POST['fbid']) {
		$fbid = Input::get('fbid');
		$fields=array('fbid'=>$fbid);
		$db->update('settings',1,$fields);
	}

	if($settings->fbsecret != $_POST['fbsecret']) {
		$fbsecret = Input::get('fbsecret');
		$fields=array('fbsecret'=>$fbsecret);
		$db->update('settings',1,$fields);
	}

	if($settings->fbcallback != $_POST['fbcallback']) {
		$fbcallback = Input::get('fbcallback');
		$fields=array('fbcallback'=>$fbcallback);
		$db->update('settings',1,$fields);
	}

	if($settings->graph_ver != $_POST['graph_ver']) {
		$graph_ver = Input::get('graph_ver');
		$fields=array('graph_ver'=>$graph_ver);
		$db->update('settings',1,$fields);
	}

	if($settings->finalredir != $_POST['finalredir']) {
		$finalredir = Input::get('finalredir');
		$fields=array('finalredir'=>$finalredir);
		$db->update('settings',1,$fields);
	}

	Redirect::to('admin.php?tab='.$tab);
}

?>
<div id="page-wrapper"> <!-- leave in place for full-screen backgrounds etc -->
	<div class="container"> <!-- -fluid -->

		<h1 class="text-center">UserSpice Dashboard Version <?=$user_spice_ver?></h1>

		<div class="well well-lg text-center">
			<a href="check_updates.php" class="btn btn-primary">Check for Updates</a>
			<a href="admin_backup.php" class="btn btn-primary">Backup UserSpice</a>
			<a href="cron_manager.php" class="btn btn-primary">Cron Manager</a>
			<a href="admin_messages.php" class="btn btn-primary">Manage Messages</a>


		</div>

		<div class="row"> <!-- row for Users, Permissions, Pages, Email settings panels -->
			<h2>Admin Panels</h2>
			<!-- Users Panel -->
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Users</strong></div>
					<div class="panel-body text-center"><div class="huge"> <i class='fa fa-user fa-1x'></i> <?=$user_count?></div></div>
					<div class="panel-footer">
						<span class="pull-left"><a href="admin_users.php">Manage</a></span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div> <!-- /panel-footer -->
				</div><!-- /panel -->
			</div><!-- /col -->

			<!-- Permissions Panel -->
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Permission Levels</strong></div>
					<div class="panel-body text-center"><div class="huge"> <i class='fa fa-lock fa-1x'></i> <?=$level_count?></div></div>
					<div class="panel-footer">
						<span class="pull-left"><a href="admin_permissions.php">Manage</a></span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div> <!-- /panel-footer -->
				</div><!-- /panel -->
			</div> <!-- /.col -->

			<!-- Pages Panel -->
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Pages</strong></div>
					<div class="panel-body  text-center"><div class="huge"> <i class='fa fa-file-text fa-1x'></i> <?=$page_count?></div></div>
					<div class="panel-footer">
						<span class="pull-left"><a href="admin_pages.php">Manage</a></span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					</div> <!-- /panel-footer -->
				</div><!-- /panel -->
			</div><!-- /col -->

			<!-- Email Settings Panel -->
			<div class="col-xs-6 col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Email Settings</strong></div>
					<div class="panel-body text-center"><div class="huge"> <i class='fa fa-paper-plane fa-1x'></i> 9</div></div>
					<div class="panel-footer">
						<span class="pull-left"><a href='email_settings.php'>Manage</a></span>
						<span class="pull-right"><i class='fa fa-arrow-circle-right'></i></span>
						<div class="clearfix"></div>
					</div> <!-- /panel-footer -->
				</div> <!-- /panel -->
			</div> <!-- /col -->

		</div> <!-- /.row -->

		<!-- CHECK IF ADDITIONAL ADMIN PAGES ARE PRESENT AND INCLUDE IF AVAILABLE -->

		<?php
		if(file_exists($abs_us_root.$us_url_root.'usersc/includes/admin_panels.php')){
			require_once $abs_us_root.$us_url_root.'usersc/includes/admin_panels.php';
		}
		?>

		<!-- /CHECK IF ADDITIONAL ADMIN PAGES ARE PRESENT AND INCLUDE IF AVAILABLE -->

		<div class="row "> <!-- rows for Info Panels -->
			<h2>Info Panels</h2>
			<div class="col-xs-12 col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>All Users</strong> <span class="small">(Who have logged in)</span></div>
					<div class="panel-body text-center">
						<div class="row">
							<div class="col-xs-3 "><h3><?=$hourCount?></h3><p>per hour</p></div>
							<div class="col-xs-3"><h3><?=$dayCount?></h3><p>per day</p></div>
							<div class="col-xs-3 "><h3><?=$weekCount?></h3><p>per week</p></div>
							<div class="col-xs-3 "><h3><?=$monthCount?></h3><p>per month</p></div>
						</div>
					</div>
				</div><!--/panel-->


				<div class="panel panel-default">
					<div class="panel-heading"><strong>All Visitors</strong> <span class="small">(Whether logged in or not)</span></div>
					<div class="panel-body">
						<?php  if($settings->track_guest == 1){ ?>
							<?="In the last 30 minutes, the unique visitor count was ".count_users()."<br>";?>
						<?php }else{ ?>
							Guest tracking off. Turn "Track Guests" on below for advanced tracking statistics.
						<?php } ?>
					</div>
				</div><!--/panel-->

			</div> <!-- /col -->

			<div class="col-xs-12 col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Logged In Users</strong> <span class="small">(past 24 hours)</span></div>
					<div class="panel-body">
						<div class="uvistable table-responsive">
							<table class="table">
								<?php if($settings->track_guest == 1){ ?>
									<thead><tr><th>Username</th><th>IP</th><th>Last Activity</th></tr></thead>
									<tbody>

										<?php foreach($recentUsers as $v1){
											$user_id=$v1->user_id;
											$username=name_from_id($v1->user_id);
											$timestamp=date("Y-m-d H:i:s",$v1->timestamp);
											$ip=$v1->ip;

											if ($user_id==0){
												$username="guest";
											}

											if ($user_id==0){?>
												<tr><td><?=$username?></td><td><?=$ip?></td><td><?=$timestamp?></td></tr>
											<?php }else{ ?>
												<tr><td><a href="admin_user.php?id=<?=$user_id?>"><?=$username?></a></td><td><?=$ip?></td><td><?=$timestamp?></td></tr>
											<?php } ?>

										<?php } ?>

									</tbody>
								<?php }else{echo 'Guest tracking off. Turn "Track Guests" on below for advanced tracking statistics.';} ?>
							</table>
						</div>
					</div>
				</div><!--/panel-->

				<div class="panel panel-default">
					<div class="panel-heading"><strong>Security Events</strong><span align="right" class="small"><a href="tomfoolery.php"> (View Logs)</a></span></div>
					<div class="panel-body" align="center">
						There have been<br>
						<h2><?=$tomC?></h2>
						security events triggered
					</div>
				</div><!--/panel-->
			</div>
		</div>
	</div>



	<!-- tabs -->

	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel with-nav-tabs panel-default">
				<div class="panel-heading">
					<ul class="nav nav-tabs">
						<li <?php if($tab == 1){echo "class='active'";}?>><a href="#tab1default" data-toggle="tab">Site Settings</a></li>
						<li <?php if($tab == 2){echo "class='active'";}?>><a href="#tab2default" data-toggle="tab">Register & Login</a></li>
						<li <?php if($tab == 3){echo "class='active'";}?>><a href="#tab3default" data-toggle="tab">CSS Settings</a></li>
						<li <?php if($tab == 4){echo "class='active'";}?>><a href="#tab4default" data-toggle="tab">CSS Samples</a></li>
					</ul>
				</div>
				<div class="panel-body">
					<div class="tab-content">
						<div class="tab-pane fade <?php if($tab == 1){echo "in active";}?>" id="tab1default">
							<?php include('views/_admin_site_settings.php');?>
						</div>

						<div class="tab-pane fade <?php if($tab == 2){echo "in active";}?>" id="tab2default">
							<?php include('views/_admin_login_settings.php');?>
						</div>

						<div class="tab-pane fade <?php if($tab == 3){echo "in active";}?>" id="tab3default">
							<!-- css settings -->
							<?php include('views/_admin_css_settings.php');?>
						</div>
						<div class="tab-pane fade <?php if($tab == 4){echo "in active";}?>" id="tab4default">
							<?php include('views/_admin_css_samples.php');?>
						</div>



					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-xs-12 col-md-6"> <!-- Site Settings Column -->

</div> <!-- /col1/2 -->

<div class="col-xs-12 col-md-6"><!-- CSS Settings Column -->

</div> <!-- /col1/3 -->
</div> <!-- /row -->

<!-- Social Login -->
<div class="col-xs-12 col-md-12">

</div> <!-- /col1/3 -->
</div> <!-- /row -->




</div> <!-- /container -->
</div> <!-- /#page-wrapper -->

<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->
<script type="text/javascript">
$(document).ready(function(){

	$("#times").load("times.php" );

	var timesRefresh = setInterval(function(){
		$("#times").load("times.php" );
	}, 30000);


	$('[data-toggle="tooltip"]').tooltip();
	$('[data-toggle="popover"]').popover();
	// -------------------------------------------------------------------------
});
</script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
