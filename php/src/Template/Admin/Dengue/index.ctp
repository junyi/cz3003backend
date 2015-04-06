      <link href="dist/css/formStyle.css" rel="stylesheet" type="text/css" />
      <script src="script/dengue.js"></script>

      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Events
            <small> to manage and summarize dengue cases that are obtained from reliable sources</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Events</a></li>
            <li class="active">Dengue</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Dengue Case</h3>
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
                      <th>Region</th>
                      <th>No of People Infected</th>
                      <th>Severity</th>
                      <th>Date/Time</th>
                    </tr>
                    <?php 
                      $count = 1;
                      foreach ($dengue as $i) {               
                          $time = $i['postDateTime']->format('d-m-Y h:i A');
                          $time = str_replace('-', '/', $time);
                          $label = "";
                          switch ($i->severity) {
                            case 'Alert':
                              $label = "danger";
                              break;
                            case 'Info':
                              $label = "info";
                              break;
                            case 'Warning':
                              $label = "warning";
                              break;
                            default:
                              break;
                          }
                          echo $this->Html->tableCells(
                              array(
                                  $count++,
                                  $dengueMapping[$i->region],
                                  ($i->noOfPeopleInfected)." people",
                                  "<span class=\"label label-$label\">$i->severity</span>",
                                  "<div class=\"sparkbar\" data-color=\"#00a65a\" data-height=\"20\">$time</div>"
                              )
                          );
                      }
                    ?>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div>
          </div>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    <!-- Add New Region - Dengue Form -->
    <div class="modal fade" id="addDengue" tabindex="-1" role="dialog" aria-labelledby="addDengue" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="addDengue">Add New Region</h4>
          </div>
          <div class="modal-body">
            <form role="form">
                <!-- Region -->
                <div class="form-group">
                    <label>Region</label>
                    <input type="text" class="form-control" id="region_input" placeholder="Enter region in Singapore">
                </div>
                <!-- No of people infected -->
                <div class="form-group">
                    <label>No of people infected</label>
                    <input type="text" class="form-control" id="no_of_people_infected_input" placeholder="Enter no of people infected">
                </div>
                <!-- Severity : Alert, Warning, Info -->
                <div class="form-group">
                   <label>Severity</label>
                    <select class="form-control" id="severity_input">
                       <option value="alert">Alert</option>
                       <option value="warning">Warning</option>
                       <option value="info">Info</option>
                    </select>
                </div>
                <!-- Date / Time -->
                <div class="form-group">
                    <label>Date/Time</label>
                    <div class="input-group">
                      <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                      <input type="text" class="form-control" id="datetime_input" placeholder="yyyy-mm-dd HH:mm"/>
                    </div>
                </div>
                <!-- Remarks -->
                <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control" rows="3" placeholder="Enter remarks" style="resize:vertical"></textarea>
                </div>
            </form>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>