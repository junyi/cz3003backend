     <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Profile
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Edit Profile</li>
          </ol>
        </section>

        <section class="content">
          <div class="row">
            <!-- left column -->
            <div class="col-xs-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">General Details</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="edit_profile_form" action="/admin/editProfile" method="post" enctype="multipart/form-data">
                  <div class="box-body">
                    <!-- Profile Picture -->
                    <div class="form-group">
                      <label for="exampleInputFile">Profile Picture</label>
                      <input type="file" name="file" id="profile_picture_input">
                    </div>
                    <!-- Full Name -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Full Name</label>
                      <input type="text" class="form-control" id="full_name_input" name="name" value="<?= h($user['name'])?>" placeholder="Enter full name">
                    </div>
                    <!-- Email Address -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email</label>
                      <input type="email" class="form-control" id="email_input" name="email" value="<?= h($user['email'])?>" placeholder="Enter email">
                    </div>
                    <!-- Contact -->
                    <div class="form-group">
                      <label for="exampleInputEmail1">Contact</label>
                      <input type="text" class="form-control" id="contact_input" name="contact" value="<?= h($user['contact'])?>" placeholder="Enter contact number" maxlength="8">
                  </div>
                    <!-- Role: administrator, call operator -->
                    <div class="form-group">
                       <label>Role</label>
                        <select class="form-control" id="role_input">
                           <option value="Administrator" <?php if($user['role'] == "Administrator"){echo "selected";}?>>Administrator</option>
                           <option value="Call Operator" <?php if($user['role'] == "Call Operator"){echo "selected";}?>>Call Operator</option>
                        </select>
                    </div>
                    <!-- Status: active, inactive -->
                    <div class="form-group">
                       <label>Status</label>
                        <select class="form-control" id="status_input">
                           <option value="active" <?php if($user['status'] == "active"){echo "selected";}?>>Active</option>
                           <option value="inactive" <?php if($user['status'] == "inactive"){echo "selected";}?>>Inactive</option>
                        </select>
                    </div>

                    <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
             </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->

        <section class="content">
            <div class="row">
            <!-- left column -->
              <!-- left column -->
            <div class="col-xs-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title">Reset Password</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role="form" id="change_password_form" action="/admin/staff/changePwd" method="post">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Old Password</label>
                      <input type="password" maxlength="12" class="form-control" id="old_password_input" name="old_password" placeholder="Enter old password">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">New Password</label>
                      <input type="password" maxlength="12" class="form-control" id="new_password_input" name="new_password" placeholder="Enter new password">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputPassword1">Confirm Password</label>
                      <input type="password" maxlength="12" class="form-control" id="confirm_password_input" name="confirm_password" placeholder="Enter confirm password">
                    </div>
                    
                  
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div><!-- /.box -->
  
            </div><!--/.col (right) -->
          </div>   <!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->