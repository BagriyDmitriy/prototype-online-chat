<form class="form-horizontal" onsubmit="register(this); return false;">
  <h3>Create account</h3>
  <div class="form-group">
    <label for="inputUsername" class="col-sm-2 control-label">Username:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" id="inputUsername" placeholder="Username">
      <?php if(isset($error['username'])) { ?>
        <div class="alert alert-warning" role="alert">Username invalid</div>
      <?php } ?>
      <?php if(isset($error['username_exists'])) { ?>
        <div class="alert alert-warning" role="alert">Username already exists</div>
      <?php } ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="col-sm-2 control-label">Email:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" id="inputEmail" placeholder="email">
      <?php if(isset($error['email'])) { ?>
        <div class="alert alert-warning" role="alert">Email invalid</div>
      <?php } ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputHomepage" class="col-sm-2 control-label">Homepage:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="homepage" value="<?php echo $homepage; ?>" id="inputHomepage" placeholder="homepage">
      <?php if(isset($error['homepage'])) { ?>
        <div class="alert alert-warning" role="alert">Homepage invalid</div>
      <?php } ?>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="col-sm-2 control-label">password:</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" id="inputPassword" placeholder="password">
      <?php if(isset($error['password'])) { ?>
        <div class="alert alert-warning" role="alert">Password is empty</div>
      <?php } ?>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Create accoun</button>
      <button id="login_form_btn" onclick="showForm(); return false;" class="btn btn-default"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> Back to login form</button>
    </div>
  </div>
</form>