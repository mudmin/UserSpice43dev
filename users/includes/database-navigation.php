<style>
body {
    margin-top: 0 !important;
    background-color: #222;
}

@media(min-width:768px) {
    body {
        margin-top: 0 !important;
    }
}
</style>
  <?php
  /*
  Load main navigation menus
  */
  $main_nav_all = $db->query("SELECT * FROM menus WHERE menu_title='main' ORDER BY display_order");

  /*
  Set "results" to true to return associative array instead of object...part of db class
  */
  $main_nav=$main_nav_all->results(true);

  /*
  Make menu tree
  */
  $prep=prepareMenuTree($main_nav);

  ?>

  <nav class="navbar navbar-inverse navbar-noborder">
  <div class="container navbar-padding">
    <div class="navbar-header">
  	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_test" aria-expanded="false" aria-controls="navbar">
  		<span class="sr-only">Toggle navigation</span>
  		<span class="icon-bar"></span>
  		<span class="icon-bar"></span>
  		<span class="icon-bar"></span>
  	</button>
  	<a href="<?=$us_url_root?>"><img src="<?=$us_url_root?>users/images/logo.png"></img></a>
    </div>
    <div id="navbar_test" class="navbar-collapse collapse">
  	<ul class="nav navbar-nav navbar-right">
  <?php
  foreach ($prep as $key => $value) {
  	/*
  	Check if there are children of the current nav item...if no children, display single menu item, if children display dropdown menu
  	*/
  	if (sizeof($value['children'])==0) {
  		if ($user->isLoggedIn()) {
  			if (checkMenu($value['id'],$user->data()->id) && $value['logged_in']==1) {
  				echo prepareItemString($value);
  			}
  		} else {
  			if ($value['logged_in']==0 || checkMenu($value['id'])) {
  				echo prepareItemString($value);
  			}
  		}
  	} else {
  		if ($user->isLoggedIn()) {
  			if (checkMenu($value['id'],$user->data()->id) && $value['logged_in']==1) {
  				$dropdownString=prepareDropdownString($value);
  				$dropdownString=str_replace('{{username}}',$user->data()->username,$dropdownString);
  				echo $dropdownString;
  			}
  		} else {
  			if ($value['logged_in']==0 || checkMenu($value['id'])) {
  				$dropdownString=prepareDropdownString($value);
  				#$dropdownString=str_replace('{{username}}',$user->data()->username,$dropdownString); # There *is* no $user->...->username because we're not logged in
  				echo $dropdownString;
  			}
  		}
  	}
  }
  ?>
  	</ul>
    </div><!--/.nav-collapse -->
  </div><!--/.container-fluid -->
  </nav>
