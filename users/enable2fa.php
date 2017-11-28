<?php require_once '../users/init.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/header.php'; ?>
<?php require_once $abs_us_root.$us_url_root.'users/includes/navigation.php'; ?>
<?php if (!securePage($_SERVER['PHP_SELF'])){die();}?>
<?php
if($settings->twofa != 1){
  Redirect::to('account.php?err=Sorry.Two+factor+is+not+enabled+at+this+time');
}
//dealing with if the user is logged in
if($user->isLoggedIn() || !$user->isLoggedIn() && !checkMenu(2,$user->data()->id)){
    if (($settings->site_offline==1) && (!in_array($user->data()->id, $master_account)) && ($currentPage != 'login.php') && ($currentPage != 'maintenance.php')){
        $user->logout();
        Redirect::to($us_url_root.'users/maintenance.php');
    }
}

$currentUser = $user->data();

use PragmaRX\Google2FA\Google2FA;
$google2fa = new Google2FA();

$google2fa_url = $google2fa->getQRCodeGoogleUrl(
    $settings->site_name,
    $currentUser->email,
    $currentUser->twoKey
);
?>

<section class="cid-qABkfm0Pyl mbr-fullscreen mbr-parallax-background" id="header2-0" data-rv-view="1854">



    <div class="mbr-overlay" style="opacity: 0.4; background-color: rgb(40, 0, 60);"></div>

    <div class="container">
        <div class="row">
            <div class="mbr-white col-md-10">

                <div class="well">
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <p><a href="account.php" class="btn btn-primary">Account Home</a></p>
                            <p><a class="btn btn-primary " href="/usersc/wallet.php" role="button">Manage Wallet</a></p>

                        </div>
                        <div class="col-xs-12 col-md-9">
                            <h1>Enable 2-Factor</h1>
                            <p>Scan this QR code with your authenticator app or input the key: <b><?php echo $currentUser->twoKey; ?></b></p>
                            <p><img src="<?php echo $google2fa_url; ?>"></p>
                            <p>Then enter one of your one-time passkeys here:</p>
                            <p>
                                <table border="0">
                                    <tr>
                                        <td><input class="form-control" placeholder="2FA Code" type="text" name="twoCode" id="twoCode" size="10"></td>
                                        <td><button id="twoBtn" class="btn btn-primary">Verify</button></td>
                                    </tr>
                                </table>
                            </p>

                        </div>
                    </div>
                </div>

            </div> <!-- /container -->

        </div> <!-- /#page-wrapper -->
    </div>
</section>

<!-- footers -->
<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->
<script>
    $(document).ready(function() {
        $("#twoBtn").click(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "/api/",
                data: {
                    action: "verify2FA",
                    twoCode: $("#twoCode").val()
                },
                success: function(result) {
                    var resultO = JSON.parse(result);
                    if(!resultO.error){
                        alert('2FA verified and enabled.');
                    }else{
                        alert('Incorrect 2FA code.');
                    }
                },
                error: function(result) {
                    alert('There was a problem verifying 2FA. Please check Internet or contact support.');
                }
            });
        });
    });
</script>
<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
