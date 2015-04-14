<?php
  $this->layout = 'login';
?>

<?= $this->Flash->render(); ?>

<?php echo $this->Form->create(); ?>
<!-- <form name='User' action="login" method="post"> -->
  <div class="form-group has-feedback">
    <input type="text" class="form-control" placeholder="Email" name="email" id="email"/>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
  </div>
  <div class="form-group has-feedback">
    <input type="password" class="form-control" placeholder="Password" name="password" id="password"/>
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
  </div>
  <div class="row">
    <div class="col-xs-8">    
      <div class="checkbox icheck">
        <label>
          <input type="checkbox"> Remember Me
        </label>
      </div>                        
    </div><!-- /.col -->
    <div class="col-xs-4">
      <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
    </div><!-- /.col -->
  </div>
</form>
<a href = "forgot_password" > Forgot Password </a>

   