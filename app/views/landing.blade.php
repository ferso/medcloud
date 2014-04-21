   @if (Session::has('flash_error'))
        <div id="flash_error">{{ Session::get('flash_error') }}</div>
    @endif

  <div class="row">
          <div class="col-md-offset-3 col-md-6">
              <form  action="/" method="POST" class="form-signin" role="form">
                <h2 class="form-signin-heading">Login</h2>
                <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <!-- <label class="checkbox">
                  <input type="checkbox" value="remember-me"> Remember me
                </label> -->
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
              </form>
            </div>
      </div>

