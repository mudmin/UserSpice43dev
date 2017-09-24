<!-- Site Settings -->
<form class="" action="admin.php?tab=2" name="settings" method="post">
<h2 >Site Settings</h2>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<!-- Left -->

		<!-- Site Name -->
		<div class="form-group">
		<label for="site_name">Site Name</label>
		<input type="text" class="form-control" name="site_name" id="site_name" value="<?=$settings->site_name?>">
		</div>

		<!-- Recaptcha Option -->
		<div class="form-group">
			<label for="recaptcha">Recaptcha</label>
			<select id="recaptcha" class="form-control" name="recaptcha">
				<option value="1" <?php if($settings->recaptcha==1) echo 'selected="selected"'; ?> >Enabled</option>
				<option value="0" <?php if($settings->recaptcha==0) echo 'selected="selected"'; ?> >Disabled</option>
				<option value="2" <?php if($settings->recaptcha==2) echo 'selected="selected"'; ?> >For Join Only</option>
			</select>
		</div>

	<div class="form-group">
    <label for="min_pw">Recaptcha Public (Site) Key</label>
    <input type="password" class="form-control" name="recap_public" id="recap_public" value="<?=$settings->recap_public?>">
    </div>

	<div class="form-group">
    <label for="max_pw">Recaptcha Private (Secret) Key</label>
    <input type="password" class="form-control" name="recap_private" id="recap_private" value="<?=$settings->recap_private?>">
    </div>

		<!-- Messaging Option -->
		<div class="form-group">
			<label for="messaging">Messaging</label>
			<select id="messaging" class="form-control" name="messaging">
				<option value="1" <?php if($settings->messaging==1) echo 'selected="selected"'; ?> >Enabled</option>
				<option value="0" <?php if($settings->messaging==0) echo 'selected="selected"'; ?> >Disabled</option>
			</select>
			<br>
		</div>

		<!-- echouser Option -->
		<div class="form-group">
			<label for="echouser">echouser Function</label>
			<select id="echouser" class="form-control" name="echouser">
				<option value="0" <?php if($settings->echouser==0) echo 'selected="selected"'; ?> >FName LName</option>
				<option value="1" <?php if($settings->echouser==1) echo 'selected="selected"'; ?> >Username</option>
				<option value="2" <?php if($settings->echouser==2) echo 'selected="selected"'; ?> >Username (FName LName)</option>
				<option value="3" <?php if($settings->echouser==3) echo 'selected="selected"'; ?> >Username (FName)</option>
			</select>
		</div>

		<!-- WYSIWYG Option -->
		<div class="form-group">
			<label for="wys">WYSIWYG Editor</label>
			<select id="wys" class="form-control" name="wys">
				<option value="0" <?php if($settings->wys==0) echo 'selected="selected"'; ?> >Disabled</option>
				<option value="1" <?php if($settings->wys==1) echo 'selected="selected"'; ?> >Enabled</option>
			</select>
		</div>

	</div>

	<!-- right column -->
	<div class="col-xs-12 col-sm-6">
		<!-- Force Password Reset -->



		<!-- Force SSL -->
		<div class="form-group">
			<label for="force_ssl">Force HTTPS Connections</label>
			<select id="force_ssl" class="form-control" name="force_ssl">
				<option value="1" <?php if($settings->force_ssl==1) echo 'selected="selected"'; ?> >Yes</option>
				<option value="0" <?php if($settings->force_ssl==0) echo 'selected="selected"'; ?> >No</option>
			</select>
		</div>


		<div class="form-group">
				<label for="force_user_pr">Force Password Reset</label>
				<select id="force_user_pr" class="form-control" name="force_user_pr">
						<option value="0" selected>No</option>
						<option value="1">Yes</option>
				</select>
		</div>

		<!-- Force Password Reset -->
		<div class="form-group">
				<label for="force_pr">Force Password Reset on Manual Creation</label>
				<select id="force_pr" class="form-control" name="force_pr">
						<option value="1" <?php if($settings->force_pr==1) echo 'selected="selected"'; ?> >Yes</option>
						<option value="0" <?php if($settings->force_pr==0) echo 'selected="selected"'; ?> >No</option>
				</select>
		</div>

		<!-- Site Offline -->
		<div class="form-group">
			<label for="site_offline">Site Offline</label>
			<select id="site_offline" class="form-control" name="site_offline">
				<option value="1" <?php if($settings->site_offline==1) echo 'selected="selected"'; ?> >Yes</option>
				<option value="0" <?php if($settings->site_offline==0) echo 'selected="selected"'; ?> >No</option>
			</select>
		</div>

		<!-- Track Guests -->
		<div class="form-group">
			<label for="track_guest">Track Guests</label>
			<select id="track_guest" class="form-control" name="track_guest">
				<option value="1" <?php if($settings->track_guest==1) echo 'selected="selected"'; ?> >Yes</option>
				<option value="0" <?php if($settings->track_guest==0) echo 'selected="selected"'; ?> >No</option>
			</select><small>If your site gets a lot of traffic and starts to stumble, this is the first thing to turn off.</small>
		</div>

		<div class="form-group">
						<label for="permission_restriction">Permission Restrictions</label>
						<select id="permission_restriction" class="form-control" name="permission_restriction">
										<option value="1" <?php if($settings->permission_restriction==1) echo 'selected="selected"'; ?> >Enabled</option>
										<option value="0" <?php if($settings->permission_restriction==0) echo 'selected="selected"'; ?> >Disabled</option>
						</select>
		</div>

		<div class="form-group">
						<label for="page_page_permission_restriction">Page Permission Restrictions</label>
						<select id="page_permission_restriction" class="form-control" name="page_permission_restriction">
										<option value="1" <?php if($settings->page_permission_restriction==1) echo 'selected="selected"'; ?> >Enabled</option>
										<option value="0" <?php if($settings->page_permission_restriction==0) echo 'selected="selected"'; ?> >Disabled</option>
						</select>
		</div>

		<div class="form-group">
						<label for="page_default_private">New Pages Default To "Private"</label>
						<select id="page_default_private" class="form-control" name="page_default_private">
										<option value="1" <?php if($settings->page_default_private==1) echo 'selected="selected"'; ?> >Enabled</option>
										<option value="0" <?php if($settings->page_default_private==0) echo 'selected="selected"'; ?> >Disabled</option>
						</select>
		</div>


	</div>
</div>



<input type="hidden" name="csrf" value="<?=Token::generate();?>" />

<p><input class='btn btn-primary' type='submit' name="settings" value='Save Site Settings' /></p>
</form>
