      <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
	  
	  <div class="row">
            <div class="col-md-12">
	      <div id="map-canvas" style="width: 100%; height: 400px; box-shadow: 0px 0px 1px #999999; margin-bottom: 20px;"></div>
	      <div id="legend-box">
		<h3>LEGEND</h3>
		<form>
		  <ul>
		    <li><input type="checkbox" checked="checked" onclick="toggleRoadMarkers(this);"/> <img src="http://labs.google.com/ridefinder/images/mm_20_blue.png" /> Road Accidents</li>
		    <li><input type="checkbox" checked="checked" onclick="toggleFireMarkers(this);"/> <img src="http://labs.google.com/ridefinder/images/mm_20_red.png" /> Fire Outbreaks</li>
		    <li><input type="checkbox" checked="checked"/> <img src="http://labs.google.com/ridefinder/images/mm_20_yellow.png" /> Flood</li>
		    <li><input type="checkbox" checked="checked" onclick="toggleDengueMarkers(this);"/> <img src="dist/img/dengue_marker.png" /> Dengue</li>
		    <li><input type="checkbox" onclick="toggleWeather(this);" /> <img src="dist/img/weather.png" /> Weather</li>
		    <li><input type="checkbox" onclick="toggleRegionOverlays(this);" /> <img src="dist/img/haze.png" /> Regions</li>
		  </ul>
		</form>
	      </div><!-- /.legend-box -->
	    </div><!-- /.col-md-12 -->
	  </div><!-- /.row -->
        
          <!-- Main row -->
          <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
              <!-- TABLE: LATEST DENGUE READINGS -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Recent Incidents</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          <th>Incident</th>
                          <th>Date/Time</th>
                          <th>Location</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          foreach ($incidents as $i) {               
                              $status = $i->incidentStatus;
                              $i['incidentDateTime']->timezone = 'Asia/Singapore';
                              $incidentDateTime = $i['incidentDateTime']->format('d-m-Y h:i A');
                              $incidentDateTime = str_replace('-', '/', $incidentDateTime);
                              echo $this->Html->tableCells(
                                  array(
                                      '<a href="#">'. $i->incidentTitle .'</a>',
                                      '<div class="sparkbar" data-color="#00a65a" data-height="20">'.$incidentDateTime.'</div>',
                                      $i->address
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
                        <?php 
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
                                      $dengueMapping[$i->region],
                                      ($i->noOfPeopleInfected)." people",
                                      "<span class=\"label label-$label\">$i->severity</span>",
                                      "<div class=\"sparkbar\" data-color=\"#00a65a\" data-height=\"20\">$time</div>"
                                  )
                              );
                          }
                        ?>
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">&nbsp;</div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
	    
	    <!-- HAZE CATEGORIES -->
            <div class='col-md-4'>
              <div class="box box-default">
                <div class="box-header with-border">
                  <h3 class="box-title">PSI INDEX <small>As of 16 Mar 1300 hours</small></h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-footer no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">North <span class="pull-right text-green"> 50 </span></a></li>
                    <li><a href="#">Central  <span class="pull-right text-green"> 50 </span></a></li>
                    <li><a href="#">East <span class="pull-right text-green"> 60 </span></a></li>
                    <li><a href="#">West  <span class="pull-right text-green"> 70 </span></a></li>
                    <li><a href="#">South  <span class="pull-right text-green"> 80 </span></a></li>
                  </ul>
                </div><!-- /.footer -->
              </div><!-- /.box -->
            </div><!-- /.col -->
	    
          </div><!-- /.row -->

        </section><!-- /.content -->
       
      </div><!-- /.content-wrapper -->