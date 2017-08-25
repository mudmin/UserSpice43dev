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
//PHP Goes Here!
$errors = $successes = [];
$query = $db->query("SELECT * FROM email");
$results = $query->first();
$act = $results->email_act;
$form_valid=TRUE;
$permOpsQ = $db->query("SELECT * FROM permissions");
$permOps = $permOpsQ->results();
// dnd($permOps);

//Forms posted
if (!empty($_POST)) {
  //Delete User Checkboxes
  if (!empty($_POST['delete'])){
    $deletions = $_POST['delete'];
    if ($deletion_count = deleteUsersNew($deletions)){
      $successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
    }
    else {
      $errors[] = lang("SQL_ERROR");
    }
  }
}
//Forms posted
if (!empty($_POST)) {
  //Manually Add User
  if(!empty($_POST['addUser'])) {
    $join_date = date("Y-m-d H:i:s");
        $fname = Input::get('fname');
        $lname = Input::get('lname');
        $email = Input::get('email');
        if($settings->auto_assign_un==1) {
        $preusername = $fname[0];
        $preusername .= $lname;
        $preQ = $db->query("SELECT username FROM users WHERE username = ?",array($preusername));
        $preQCount = $preQ->count();
        if($preQCount == 0)
        {
                $username = strtolower($preusername);
        }
        else
        {
                $preusername2 = $fname;
                $preusername2 .= $lname[0];
                $preQ2 = $db->query("SELECT username FROM users WHERE username = ?",array($preusername2));
                $preQCount2 = $preQ2->count();
                        if($preQCount2 == 0)
                        {
                                $username = strtolower($preusername2);
                        }
                        else
                        {
                                $username = $email;
                        }
        } }
        if($settings->auto_assign_un==0) $username = Input::get('username'); 
    $token = $_POST['csrf'];

    if(!Token::check($token)){
      die('Token doesn\'t match!');
    }

    $form_valid=FALSE; // assume the worst
    $validation = new Validate();
    $validation->check($_POST,array(
      'fname' => array(
      'display' => 'First Name',
      'required' => true,
      'min' => 2,
      'max' => 35,
      ),
      'lname' => array(
      'display' => 'Last Name',
      'required' => true,
      'min' => 2,
      'max' => 35,
      ),
      'email' => array(
      'display' => 'Email',
      'required' => true,
      'valid_email' => true,
      'unique' => 'users',
      ),
      'password' => array(
      'display' => 'Password',
      'required' => true,
      'min' => 6,
      'max' => 25,
      ),
      'confirm' => array(
      'display' => 'Confirm Password',
      'required' => true,
      'matches' => 'password',
      ),
    ));
        if($validation->passed()) {
                $form_valid=TRUE;
      try {
        // echo "Trying to create user";
        $fields=array(
          'username' => $username,
          'fname' => Input::get('fname'),
          'lname' => Input::get('lname'),
          'email' => Input::get('email'),
          'password' =>
          password_hash(Input::get('password'), PASSWORD_BCRYPT, array('cost' => 12)),
          'permissions' => 1,
          'account_owner' => 1,
          'stripe_cust_id' => '',
          'join_date' => $join_date,
          'company' => Input::get('company'),
          'email_verified' => 1,
          'active' => 1,
          'vericode' => 111111,
        );
        $db->insert('users',$fields);
        $theNewId=$db->lastId();
        // bold($theNewId);
        $perm = Input::get('perm');
        $addNewPermission = array('user_id' => $theNewId, 'permission_id' => 1);
        $db->insert('user_permission_matches',$addNewPermission);
        $db->insert('profiles',['user_id'=>$theNewId, 'bio'=>'']);
                Redirect::to('admin_user.php?id='.$theNewId);

      } catch (Exception $e) {
        die($e->getMessage());
      }

    }
  }
}
$userData = fetchAllUsers(); //Fetch information for all users
?>
<div id="page-wrapper">

  <div class="container">

    <!-- Page Heading -->
    <div class="row">

            <div class="col-xs-12 col-md-6">
                <h1>Manage Users</h1>
          </div>

          <div class="col-xs-12 col-md-6">
                        <form class="">
                                <label for="system-search">Search:</label>
                                <div class="input-group">
                    <input class="form-control" id="system-search" name="q" placeholder="Search Users..." type="text">
                    <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-times"></i></button>
                    </span>
                </div>
                        </form>
                  </div>

        </div>


                                 <div class="row">
                     <div class="col-md-12">
          <?php echo resultBlock($errors,$successes);
                                ?>

                                                         <hr />
                                                         <a class="pull-right" href="#" data-toggle="modal" data-target="#adduser"><i class="glyphicon glyphicon-plus"></i> User</a>
        <div class="row">
        <div class="col-xs-12">
                                 <div class="alluinfo">&nbsp;</div>
                                 <div class="allutable table-responsive">
                                        <table class='table table-hover table-list-search'>
                                        <thead>
                                        <tr>
                                                <th></th><th>Username</th><th>Name</th><th>Email</th><th>Last Sign In</th><?php if($act==1) {?><th>Verified</th><?php } ?>
                                         </tr>
                                        </thead>
                                 <tbody>
                                        <?php
                                        //Cycle through users
                                        foreach ($userData as $v1) {
                                                        ?>
                                        <tr>
                                        <td><a href='admin_user.php?id=<?=$v1->id?>'><?=$v1->id?></a></td>
                                        <td><a href='admin_user.php?id=<?=$v1->id?>'><?=$v1->username?></a></td>
                                        <td><?=$v1->fname?> <?=$v1->lname?></td>
                                        <td><?=$v1->email?></td>
                                        <td><?php if($v1->last_login != 0) { echo $v1->last_login; } else {?> <i>Never</i> <?php }?></td>
                                        <?php if($act==1) {?><td>
                                                        <?php if($v1->email_verified == 1){
                                                                                echo "<i class='glyphicon glyphicon-ok'></i>";
                                                                        } ?>
                                                        </td><?php } ?>
                                        </tr>
                                                        <?php } ?>

                                  </tbody>
                                </table>
                                </div>
                  </div>
                </div>


  </div>
  <div id="adduser" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">User Addition</h4>
      </div>
      <div class="modal-body">
<form class="form-signup" action="admin_users.php" method="POST" id="payment-form">
        <div class="panel-body">

        <?php if($settings->auto_assign_un==0) {?><label>Username: </label><input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if (!$form_valid && !empty($_POST)){ echo $username;} ?>" required><?php } ?>
        
        <label>First Name: </label><input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php if (!$form_valid && !empty($_POST)){ echo $fname;} ?>" required>

        <label>Last Name: </label><input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php if (!$form_valid && !empty($_POST)){ echo $lname;} ?>" required>

        <label>Email: </label><input  class="form-control" type="text" name="email" id="email" placeholder="Email Address" value="<?php if (!$form_valid && !empty($_POST)){ echo $email;} ?>" required >

        <label>Password: </label><input  class="form-control" type="password" name="password" id="password" placeholder="Password" required aria-describedby="passwordhelp">

        <label>Confirm Password: </label><input  type="password" id="confirm" name="confirm" class="form-control" placeholder="Confirm Password" required >
        <br />
      </div>
      <div class="modal-footer">
          <div class="btn-group">       <input type="hidden" name="csrf" value="<?=Token::generate();?>" />
        <input class='btn btn-primary' type='submit' name="addUser" value='Add User' class='submit' /></div>
        </form>
         <div class="btn-group"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>
      </div>
    </div>
        </div>
  </div>
</div>
</div>
</div>
</div>


        <!-- End of main content section -->

<?php require_once $abs_us_root.$us_url_root.'users/includes/page_footer.php'; // the final html footer copyright row + the external js calls ?>

    <!-- Place any per-page javascript here -->
                <script src="scripts/jwerty.js"></script>
        <script>
        jwerty.key('esc', function () {
        $('.modal').modal('hide');
});
</script>
<script src="/users/js/search.js" charset="utf-8"></script>

<?php require_once $abs_us_root.$us_url_root.'users/includes/html_footer.php'; // currently just the closing /body and /html ?>