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

<div class="container">
        <div class="row">
                <div class="col-sm-12 text-center">
                        <footer><font color='white'><br>&copy; <?=$copyright_message; ?></font></footer>
                        <?php if($your_public_key  == "6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI") { echo "<h3 align='center'style='color:white'>For security reasons, you need to change your reCAPTCHA key.</h3>"; } ?>
                </div>
        </div>
</div>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
// (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
// function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
// e=o.createElement(i);r=o.getElementsByTagName(i)[0];
// e.src='//www.google-analytics.com/analytics.js';
// r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
// ga('create','UA-XXXXX-X','auto');ga('send','pageview');
</script>

<!-- Bootstrap Core JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php if (isset($user) && $user->isLoggedIn()) { ?>

<div id="notificationsModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Notifications</h4>
      </div>
      <div id="notificationsModalBody" class="modal-body"></div>
      <div class="modal-footer">
         <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $('#notificationsTrigger').on('click', function(){
        $.ajax({
            url: '<?=$us_url_root?>users/parsers/getNotifications.php',
            type: 'POST',
            success: function(response) {
                $('#notificationsModalBody').html(response);
                $('#notifCount').hide();
            },
            error: function() {
                $('#notificationsModalBody').html('<div class="text-center">There was an error retrieving your notifications.</div>');
            }
        });
        $('#notificationsModal').on('shown.bs.modal', function(e){
            $('#notificationsTrigger').on('focus', function(e){$(this).blur();});
        });
    });
});
</script>
<?php } ?>
