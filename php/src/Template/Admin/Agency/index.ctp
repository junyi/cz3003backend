      <script src="script/agency.js"></script>

      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Contacts
            <small> to manage email and contacts of agencies for dispatching of notifications</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Contacts</a></li>
            <li class="active">Agencies</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div style="width:200px; float:right; margin-top:10px; margin-bottom:10px; ">
            <button class="btn btn-block btn-success" data-remote="/admin/agency/form?action=add" id="add_agency_btn" data-toggle="modal" data-target="#agency_modal">Add Agency</button>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Agency</h3>
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
                      <th>Agency</th>
                      <th>Contact</th>
                      <th>Type of Incident</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                      foreach ($agencies as $i) {               
                          //$status = $i->incidentStatus;
                          echo $this->Html->tableCells(
                              array(
                                  $i->agencyID,
                                  $i->agencyName,
                                  $i->agencyContact,
                                  '',
                                  '<a href="#" data-toggle="modal" data-remote="/admin/agency/form?action=edit&id='.$i->agencyID.'" data-target="#agency_modal"> Edit </a> | <a href="/admin/agency/delete?id='.$i->agencyID.'" onclick="return confirm(\'Confirm delete?\');">Delete</a>'
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
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">&raquo;</a></li>
                  </ul>
                </div>
                <!-- /.footer pagination -->
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


   <!-- Modal -->
    <div class="modal fade" id="agency_modal" tabindex="-1" role="dialog" aria-labelledby="Agency modal" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="progress progress-popup">
              <div class="progress-bar progress-bar-striped active" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
            </div>
          </div>
        </div>
      </div>
    </div>