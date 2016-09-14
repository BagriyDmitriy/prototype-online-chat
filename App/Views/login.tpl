<form class="form-horizontal" onsubmit="login(this);return false;">
  <h3>Login</h3>
  <div class="form-group">
    <label for="inputUsername" class="col-sm-2 control-label">Username:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="username" value="" id="inputUsername" placeholder="Username">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" name="password" value="" id="inputPassword" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" value="Login">Login</button>
      <p><a href="#" onclick="showRegisterForm(); return false;" id="register">Create account</a></p>
    </div>
  </div>
</form>