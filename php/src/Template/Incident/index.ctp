      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Incident
            <small> List of all reported incidents</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Incidents</a></li>
            <li class="active">Incidents</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div style="width:200px; float:right; margin-top:10px; margin-bottom:10px; ">
            <a href="/report">
              <button class="btn btn-block btn-success" id="add_incident_btn">Report An Incident</button>
            </a>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Incident</h3>
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
                      <th>Incident</th>
                      <th>Date/Time</th>
                      <th>Location</th>
                      <th>Category</th>
                    </tr>
                    <?php 
                      $num = 1;
                      foreach ($incidents as $i) {               
                          $status = $i->incidentStatus;
                          $i['incidentDateTime']->timezone = 'Asia/Singapore';
                          $incidentDateTime = $i['incidentDateTime']->format('d-m-Y h:i A');
                          $incidentDateTime = str_replace('-', '/', $incidentDateTime);
                          echo $this->Html->tableCells(
                              array(
                                  $num++,
                                  $i->incidentTitle,
                                  $incidentDateTime,
                                  $i->address,
                                  $i->incidentCategory->incidentCategoryTitle
                              )
                          );
                      }
                    ?>
                  </table>
                </div><!-- /.box-body -->
                <!-- footer pagination -->
                <div class="box-footer clearfix">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">1</a></li>
                  </ul>
                </div>
                <!-- /.footer pagination -->
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
 