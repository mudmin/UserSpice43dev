<?php require_once 'classes/class.autoloader.php';
session_start();

$abs_us_root=$_SERVER['DOCUMENT_ROOT'];

$self_path=explode("/", $_SERVER['PHP_SELF']);
$self_path_length=count($self_path);
$file_found=FALSE;

for($i = 1; $i < $self_path_length; $i++){
	array_splice($self_path, $self_path_length-$i, $i);
	$us_url_root=implode("/",$self_path)."/";

	if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
		$file_found=TRUE;
		break;
	}else{
		$file_found=FALSE;
	}
}

require_once $abs_us_root.$us_url_root.'users/helpers/helpers.php';

// Set config
$GLOBALS['config'] = array(
	'mysql'      => array('host'         => 'localhost',
'username'     => 'root',
'password'     => '',
'db'           => '43',
),
'remember'        => array(
  'cookie_name'   => 'pmqesoxiw318374csb',
  'cookie_expiry' => 604800  //One week, feel free to make it longer
),
'session' => array(
  'session_name' => 'user',
  'token_name' => 'token',
)
);

//If you changed your UserSpice or UserCake database prefix
//put it here.
$db_table_prefix = "uc_";  //Old database prefix
$timezone_string = 'Africa/Abidjan';
$copyright_message = 'ALPHA - Do not use';
$your_private_key = 'gfd';
$your_public_key = 'gfsd';
$publickey = $your_public_key;
$privatekey = $your_private_key;

date_default_timezone_set($timezone_string);

//adding more ids to this array allows people to access everything, whether offline or not. Use caution.
$master_account = [1];

//Put Your Stripe Keys Here (if you have them)
$test_secret = "Insert_Your_Own_Key_Here";
$test_public = "Insert_Your_Own_Key_Here";
$live_secret = "Insert_Your_Own_Key_Here";
$live_public = "Insert_Your_Own_Key_Here";

// require_once $abs_us_root.$us_url_root.'users/classes/Config.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Cookie.php';
// require_once $abs_us_root.$us_url_root.'users/classes/DB.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Hash.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Input.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Redirect.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Session.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Token.php';
// require_once $abs_us_root.$us_url_root.'users/classes/User.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Validate.php';
// require_once $abs_us_root.$us_url_root.'users/classes/phpmailer/PHPMailerAutoload.php';
// require_once $abs_us_root.$us_url_root.'users/classes/Shuttle_Dumper.php';

$currentPage = currentPage();

//Check to see if user has a remember me cookie
if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
	$hash = Cookie::get(Config::get('remember/cookie_name'));
	$hashCheck = DB::getInstance()->query("SELECT * FROM users_session WHERE hash = ? AND uagent = ?",array($hash,Session::uagent_no_version()));

	if ($hashCheck->count()) {
		$user = new User($hashCheck->first()->user_id);
		$user->login();

	}
}



//Check to see that user is logged in on a temporary password
$user = new User();

//Check to see that user is verified
if($user->isLoggedIn()){
	if($user->data()->email_verified == 0 && $currentPage != 'verify.php' && $currentPage != 'logout.php' && $currentPage != 'verify_thankyou.php'){
		Redirect::to('users/verify.php');
	}
}
