      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Accounts
            <small> to manage call operator and administrator accounts</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Accounts</a></li>
            <li class="active">Staff Accounts</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div style="width:200px; float:right; margin-top:10px; margin-bottom:10px; ">
            <button class="btn btn-block btn-success" id="add_staff_accounts_btn" data-remote="/staff/form?action=add" data-toggle="modal" data-target="#staff_modal">Add Account</button>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Staff Accounts</h3>
                  <div class="box-tools">
                    <div class="input-group">
                      <input type="text" name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search"/>
                      <div class="input-group-btn">
                        <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th>No.</th>
                      <th>Profile Picture</th>
                      <th>Full Name</th>
                      <th>Email</th>
                      <th>Contact</th>
                      <th>Role</th>
                      <th>Status</th>
                    </tr>
                    <?php 
                      $count = 1;
                      foreach ($staffs as $i) {               
                          $gender = $i->gender;
                          $status = $i->status;
                          if ($i->photo) {
                            $avatar = "../uploads/$i->photo";
                          } else {
                            $avatar = '../dist/img/avatar'.($gender === 'Male' ? '5' : '2').'.png"';
                          }
                          echo $this->Html->tableCells(
                              array(
                                  $count++,
                                  '<img src="'.$avatar.'" class="img-circle" alt="User Image" width="80px" height="80px" />',
                                  $i->name,
                                  $i->email,
                                  $i->contact,
                                  $i->role,
                                  "<a href=\"staff/deactivate?id=$i->staffID\" onclick=\"return confirm('Deactivate this user?');\"<span class=\"label ".($status === "active" ? "label-success\">" : "label-danger\">").$status."</span></a>"
                              )
                          );
                      }
                    ?>
                  </table>
                </div><!-- /.box-body -->
                <!-- footer pagination -->
                <div class="box-footer clearfix">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">&laquo;</a></li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </div>
                <!-- /.footer pagination -->
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


    <!-- Add Staff Accounts Form -->
    <!-- Modal -->
    <div class="modal fade" id="staff_modal" tabindex="-1" role="dialog" aria-labelledby="Staff modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
              <h4 class="modal-title" id="modal_title"><?= $header ?></h4>
            </div>
            <div class="modal-body">
              <form role="form" id="add_staff_accounts_form" action="/admin/staff/add" method="post">
                <!-- Profile Picture -->
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" id="profile_picture_inputfile">
                </div>
                <!-- Full Name -->
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="full_name_input" name="name" placeholder="Enter full name">
                </div>
                <!-- Email -->
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email_input" name="email" placeholder="Enter email">
                </div>
                <!-- Contact -->
                <div class="form-group">
                    <label>Contact</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-phone"></i></div>
                      <input type="text" class="form-control" id="contact_input" maxlength="8" name="contact" placeholder="Enter contact no"/>
                    </div>
                </div>
                <!-- Gender : Male, Female -->
                <div class="form-group">
                   <label>Gender</label>
                    <select class="form-control" id="role_input">
                       <option value="Male">Male</option>
                       <option value="Female">Female</option>
                    </select>
                </div>
                <!-- Role : Administrator, Call Operator -->
                <div class="form-group">
                   <label>Role</label>
                    <select class="form-control" id="role_input">
                       <option value="Administrator">Administrator</option>
                       <option value="Call Operator">Call Operator</option>
                    </select>
                </div>
                <!-- Status : Active, Inactive -->
                <div class="form-group">
                   <label>Status</label>
                    <select class="form-control" id="status_input">
                       <option value="Active">Active</option>
                       <option value="Inactive">Inactive</option>
                    </select>
                </div>
                <!-- Remarks -->
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control" rows="3" placeholder="Enter remarks" style="resize:vertical"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
       
    </div>