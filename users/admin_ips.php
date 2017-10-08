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

<?php
$wl = $db->query("SELECT * FROM us_ip_whitelist")->results();
$bl = $db->query("SELECT * FROM us_ip_blacklist")->results();


  ?>
  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">

        <div class="col-xs-12 col-md-6">
          <h1>Manage IP Addresses</h1>
        </div>
      </div>

<div class="row">
        <div class="col-xs-12 col-md-6">
          <h3>Whitelisted IP Addresses</h3>
          <p>Note: Whitelist overrides Blacklist</p>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th><th>IP Address</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($wl as $b){ ?>
              <tr>
                <td><?=$b->id?></td>
                <td><?=$b->ip?></td>
              </tr>
          <?php }?>
            </tbody>
          </table>
        </div>

        <div class="col-xs-12 col-md-6">
          <h3>Blacklisted IP Addresses</h3>

          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th><th>IP Address</th>
              </tr>
            </thead>
            <tbody>
            <?php foreach($bl as $b){ ?>
              <tr>
                <td><?=$b->id?></td>
                <td><?=$b->ip?></td>
              </tr>
          <?php }?>
            </tbody>
          </table>
        </div>
  </div>

</div>
</div>

      <!-- End of main content section -->

      <?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

      <!-- Place any per-page javascript here -->
      <script src="js/jwerty.js"></script>
      <script>
      jwerty.key('esc', function () {
        $('.modal').modal('hide');
      });
      </script>
      <script src="/users/js/search.js" charset="utf-8"></script>

      <script>
    	$(document).ready(function() {
    		$('#paginate').DataTable(
          {  searching: false,
            "pageLength": 25
          }
        );
    	} );
    	</script>
    	<script src="js/pagination/jquery.dataTables.js" type="text/javascript"></script>
    	<script src="js/pagination/dataTables.js" type="text/javascript"></script>

      <?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
