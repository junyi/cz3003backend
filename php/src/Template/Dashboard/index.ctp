      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
	  
	  <div id="map-canvas" style="width: 100%; height: 400px; box-shadow: 0px 0px 1px #999999; margin-bottom: 20px;"></div>
        
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
              <!-- TABLE: LATEST DENGUE READINGS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Recent Incidents</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Incident</th>
                          <th>Date/Time</th>
                          <th>Location</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($incidents as $i) {               
                              $status = $i->incidentStatus;
                              $incidentDateTime = $i['incidentDateTime']->format('d-m-Y h:i A');
                              $incidentDateTime = str_replace('-', '/', $incidentDateTime);
                              echo $this->Html->tableCells(
                                  array(
                                      '<a href="#">'. $i->incidentTitle .'</a>',
                                      '<div class="sparkbar" data-color="#00a65a" data-height="20">'.$incidentDateTime.'</div>',
                                      $i->address,
                                      "<span class=\"label ".($status === 'On-going' ? "label-success\">" : "label-danger\">").$status."</span>"
                                  )
                              );
                          }
                        ?>
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <a href="/incident" class="btn btn-sm btn-info btn-flat pull-left">View All Incidents</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->

            <!-- INCIDENT CATEGORIES -->
            <div class='col-md-4'>
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">Incident Categories</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-footer no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <?php foreach ($incident_category_stat as $stat) {
                      ?><li><a href="#"><?= $stat->incidentCategory->incidentCategoryTitle?><span class="pull-right text-green"> <?= round($stat->percentage, 1)?>% </span></a></li>
                    <?php }?>
                  </ul>
                </div><!-- /.footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- EVENTS -->
          <div class="row">
            <div class="col-md-8">
              <!-- TABLE: LATEST DENGUE READINGS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Dengue Cases</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Region</th>
                          <th>No of people infected</th>
                          <th>Severity</th>
                          <th>Date / Time Record</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Central Area</td>
                          <td>15 people</td>
                          <td><span class="label label-danger">Alert</span></td>
                          <td><div class="sparkbar" data-color="#00a65a" data-height="20">16 March 2015 - 13:00</div></td>
                        </tr>
                        <tr>
                          <td>NorthEast Area</td>
                          <td>20 people</td>
                          <td><span class="label label-danger">Alert</span></td>
                          <td><div class="sparkbar" data-color="#f39c12" data-height="20">16 March 2015 - 13:00</div></td>
                        </tr>
                        <tr>
                          <td>NorthWest Area</td>
                          <td>3 people</td>
                          <td><span class="label label-info">Info</span></td>
                          <td><div class="sparkbar" data-color="#f56954" data-height="20">16 March 2015 - 13:00</div></td>
                        </tr>
                        <tr>
                          <td>SouthEast Area</td>
                          <td>9 people</td>
                          <td><span class="label label-warning">Warning</span></td>
                          <td><div class="sparkbar" data-color="#00c0ef" data-height="20">16 March 2015 - 13:00</div></td>
                        </tr>
                        <tr>
                          <td>SouthWest Area</td>
                          <td>10 people</td>
                          <td><span class="label label-warning">Warning</span></td>
                          <td><div class="sparkbar" data-color="#f39c12" data-height="20">16 March 2015 - 13:00</div></td>
                        </tr>
                        <tr>
                          <td>Cluster</td>
                          <td>10 people</td>
                          <td><span class="label label-warning">Warning</span></td>
                          <td><div class="sparkbar" data-color="#f56954" data-height="20">16 March 2015 - 13:00</div></td>
                        </tr>
                       
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                  <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Update Records</a>
                  <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View Reports</a>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
       
      </div><!-- /.content-wrapper -->