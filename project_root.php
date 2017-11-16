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
<?php
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/header.php';
require_once $abs_us_root.$us_url_root.'users/includes/navigation.php';
?>

<?php if (!securePage($_SERVER['PHP_SELF'])){die();} ?>

<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-sm-12">
				<h1 class="page-header">
					Welcome to UserSpice
					<small>An Open Source PHP User Management Framework</small>
				</h1>
				<!-- Content goes here -->
<?php
function test($params = array()){
	$db = DB::getInstance();

if(isset($params['id'])){
		$q = $db->query("SELECT * FROM users WHERE id = ?",array($params['id']));
		$r = $q->results();
		dump($r);
}

if(isset($params['order'])){
		$q = $db->query("SELECT * FROM users ORDER BY id {$params['order']}");
		$r = $q->results();
		dump($r);
}


}
echo "This is a test with id of 1<br>";
test(['id'=>'1']);

echo "This is a test with an order of DESCending<br>";
test(['order'=>'DESC']);

echo "This is a test with an order of ASCending<br>";
test(['order'=>'ASC']);

echo "This is a test with an order of ASCending AND just the second one<br>";
test(['order'=>'ASC','id'=>2]);

?>
				<!-- Content Ends Here -->
			</div> <!-- /.col -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</div> <!-- /.wrapper -->


<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

<!-- Place any per-page javascript here -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>
