      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Events
            <small> List of all haze records</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Events</a></li>
            <li class="active">Haze</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Haze</h3>
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
                      <th>PSI Value</th>
                      <th>Air Quality Descriptor</th>
                      <th>Date/Time</th>
                    </tr>
                    <?php 
                      $count = 1;
                      foreach ($haze as $i) {               
                          $i['postDateTime']->timezone = 'Asia/Singapore';
                          $time = $i['postDateTime']->format('d-m-Y h:i A');
                          $time = str_replace('-', '/', $time);
                          $label = "";
                          switch ($i->airQualityDescriptor) {
                            case 'Good':
                              $label = "success";
                              break;
                            case 'Moderate':
                              $label = "info";
                              break;
                            case 'Unhealthy':
                            case 'Very unhealthy':
                              $label = "warning";
                              break;
                            case 'Hazardous':
                              $label = "danger";
                              break;
                          }
                          echo $this->Html->tableCells(
                              array(
                                  $count++,
                                  ucfirst($i->region),
                                  $i->psiValue,
                                  "<span class=\"label label-$label\">$i->airQualityDescriptor</span>",
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