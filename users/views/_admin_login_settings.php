<form class="" action="admin.php?tab=2" name="social" method="post">
<h2>Register and Login Settings</h2>
<strong>Please note:</strong> Social logins require that you do some configuration on your own with Google and/or Facebook.<br>It is strongly recommended that you <a href="http://www.userspice.com/documentation-social-logins/">check the documentation at UserSpice.com.</a><br><br>
<!-- Allow users to change Usernames -->
<div class="form-group">
<label for="change_un">Allow users to change their Usernames</label>
<select id="change_un" class="form-control" name="change_un">
  <option value="0" <?php if($settings->change_un==0) echo 'selected="selected"'; ?> >Disabled</option>
  <option value="1" <?php if($settings->change_un==1) echo 'selected="selected"'; ?> >Enabled</option>
  <option value="2" <?php if($settings->change_un==2) echo 'selected="selected"'; ?> >Only once</option>
</select>
</div>
<div class="form-group">
<label for="min_pw">Minimum Password Length</label>
<input type="text" class="form-control" name="min_pw" id="min_pw" value="<?=$settings->min_pw?>">
</div>
<div class="form-group">
<label for="max_pw">Maximum Password Length</label>
<input type="text" class="form-control" name="max_pw" id="max_pw" value="<?=$settings->max_pw?>">
</div>
<div class="form-group">
<label for="req_num">Recommend a Number in the Password? (1=Yes)</label>
<input type="text" class="form-control" name="req_num" id="req_num" value="<?=$settings->req_num?>">
</div>
<div class="form-group">
<label for="req_cap">Recommend a Capital Letter in the Password? (1=Yes)</label>
<input type="text" class="form-control" name="req_cap" id="req_cap" value="<?=$settings->req_cap?>">
</div>
<div class="form-group">
<label for="min_un">Minimum Username Length</label>
<input type="text" class="form-control" name="min_un" id="min_un" value="<?=$settings->min_un?>">
</div>
<div class="form-group">
<label for="max_un">Maximum Username Length</label>
<input type="text" class="form-control" name="max_un" id="max_un" value="<?=$settings->max_un?>">
</div>

<div class="form-group">
  <label for="glogin">Enable Google Login</label>
  <select id="glogin" class="form-control" name="glogin">
    <option value="1" <?php if($settings->glogin==1) echo 'selected="selected"'; ?> >Enabled</option>
    <option value="0" <?php if($settings->glogin==0) echo 'selected="selected"'; ?> >Disabled</option>
  </select>
</div>

<div class="form-group">
  <label for="fblogin">Enable Facebook Login</label>
  <select id="fblogin" class="form-control" name="fblogin">
    <option value="1" <?php if($settings->fblogin==1) echo 'selected="selected"'; ?> >Enabled</option>
    <option value="0" <?php if($settings->fblogin==0) echo 'selected="selected"'; ?> >Disabled</option>
  </select>
</div>

<div class="form-group">
  <label for="gid">Google Client ID</label>
  <input type="password" class="form-control" name="gid" id="gid" value="<?=$settings->gid?>">
</div>

<div class="form-group">
  <label for="gsecret">Google Client Secret</label>
  <input type="password" class="form-control" name="gsecret" id="gsecret" value="<?=$settings->gsecret?>">
</div>

<div class="form-group">
  <label for="ghome">Full Home URL of Website - include the final /</label>
  <input type="text" class="form-control" name="ghome" id="ghome" value="<?=$settings->ghome?>">
</div>

<div class="form-group">
  <label for="gredirect">Google Redirect URL (Path to oauth_success.php)</label>
  <input type="text" class="form-control" name="gredirect" id="gredirect" value="<?=$settings->gredirect?>">
</div>

<div class="form-group">
  <label for="fbid">Facebook App ID</label>
  <input type="password" class="form-control" name="fbid" id="fbid" value="<?=$settings->fbid?>">
</div>

<div class="form-group">
  <label for="fbsecret">Facebook Secret</label>
  <input type="password" class="form-control" name="fbsecret" id="fbsecret" value="<?=$settings->fbsecret?>">
</div>

<div class="form-group">
  <label for="fbcallback">Facebook Callback URL</label>
  <input type="text" class="form-control" name="fbcallback" id="fbcallback" value="<?=$settings->fbcallback?>">
</div>

<div class="form-group">
  <label for="graph_ver">Facebook Graph Version - Formatted as v2.2</label>
  <input type="text" class="form-control" name="graph_ver" id="graph_ver" value="<?=$settings->graph_ver?>">
</div>

<div class="form-group">
  <label for="finalredir">Redirect After Facebook Login</label>
  <input type="text" class="form-control" name="finalredir" id="finalredir" value="<?=$settings->finalredir?>">
</div>

<p><input class='btn btn-large btn-primary' type='submit' name="social" value='Save Register and Login Settings'/></p>
</form>
