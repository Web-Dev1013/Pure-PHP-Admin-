
<div class="login alert alert-success w-25 float-right">
  <button type="button" class="close" data-dismiss="alert"></button>
  <strong> Success! </strong><br><span class="notification"> Successfully Logged In.</span>
</div>
<div class="login alert alert-danger w-25 float-right">
  <button type="button" class="close" data-dismiss="alert"></button>
  <strong> Failed! </strong><br><span class="notification"> Unrecognized User.</span>
</div>
<div class="container-fluid">
  <div class="row login w-100">
    <div class="col-lg-4 col-md-3 col-sm-2 col-0"></div>
    <div class="col-lg-4 col-md-6 col-sm-8 col-12" style="z-index: 2;">
      <div class="content">
        <div class="main p-5">
          <div class="mb-4">
            <p class="h1 font-weight-bold text-gold text-center">Survey Login</p>
          </div>
          <label for="entry_code">Entry Code</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-lock fa-lg"></i></span>
            </div>
            <input type="text" id="entry_code" class="form-control" placeholder="Entry Code">
          </div>
          <label for="password">Entry Password</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-cog fa-lg"></i></span>
            </div>
            <input type="password" id="password" class="form-control" placeholder="Entry Password">
          </div>
          <label for="access_code">Access Code</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="fas fa-calendar-check fa-lg"></i></span>
            </div>
            <input type="text" id="access_code" class="form-control" placeholder="Entry Password">
          </div>
          <div class="">
            <button id="login" class="btn font-weight-bold text-white mr-0 px-4 py-2 btn-warning">
              <i class="fas fa-key fa-lg"></i><span class="ml-3">LOGIN</span>
            </button>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-3 col-sm-2 col-0"></div>
  </div>
</div>

