      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Events
            <small> List of all dengue records</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
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
                          $i['postDateTime']->timezone = 'Asia/Singapore';
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