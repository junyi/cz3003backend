<!-- ...................................... MAIN CONTENT ................................................. -->
<!-- DASHBOARD -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Dashboard
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
  
    <!-- Main row -->
    <div class="row">
      <!-- Left col -->
      <div class="col-md-12">
        
        <div id="map-canvas" style="width: 100%; height: 400px; box-shadow: 0px 0px 1px #999999; margin-bottom: 20px;"></div>
	      
        <a href="#" id="legend-toggle-btn">L</a>
        
        <div id="legend-box">
          <h3>LEGEND</h3>
          <form>
            <ul>
              <li><input type="checkbox" checked="checked" onclick="toggleIncidentMarkers(this, 1);" /> <img src="http://labs.google.com/ridefinder/images/mm_20_blue.png" /> Road Accidents</li>
              <li><input type="checkbox" checked="checked" onclick="toggleIncidentMarkers(this, 2);" /> <img src="http://labs.google.com/ridefinder/images/mm_20_red.png" /> Fire Outbreaks</li>
              <li><input type="checkbox" checked="checked" onclick="toggleIncidentMarkers(this, 3);" /> <img src="http://labs.google.com/ridefinder/images/mm_20_yellow.png" /> Flood</li>
              <li><input type="checkbox" checked="checked" onclick="toggleIncidentMarkers(this, 4);" /> <img src="http://labs.google.com/ridefinder/images/mm_20_green.png" /> Suicide</li>
              <li><input type="checkbox" checked="checked" onclick="toggleDengueMarkers(this);" /> <img src="../dist/img/dengue_marker.png" /> Dengue</li>
              <li><input type="checkbox" onclick="toggleWeather(this);" /> <img src="../dist/img/weather.png" /> Weather</li>
              <li><input type="checkbox" onclick="toggleRegionOverlays(this);" /> <img src="../dist/img/haze.png" /> Regions</li>
            </ul>
          </form>
        </div><!-- /.legend-box -->

      </div><!-- /.col -->
    </div><!-- /.row -->


    <!-- EVENTS -->
    <div class="row">
      <div class="col-md-8">
        <!-- TABLE: DENGUE CASE READINGS -->
        <div class="box box-info">
          <div class="box-header with-border">
            <h3 class="box-title">Dengue Cases</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                  <tr>
                    <th width="50%">Region</th>
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
                                $i->region,
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
          <div class="box-footer clearfix">
            
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

       <!-- RECENTLY ADDED INCIDENTS -->
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Recently Added Incidents</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              <?php foreach ($incidents as $i) { 
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
              ?>
              <li class="item">
                <div class="product-info">
                  <a href="javascript::;" class="product-title"><?= $i->incidentTitle ?><span class="label label-<?=$label?> pull-right"><?=$i->incidentStatus?></span></a>
                  <span class="product-description">
                    <?=$i->address?>
                  </span>
                </div>
              </li><!-- /.item -->
              <?php }?>
            </ul>
          </div><!-- /.box-body -->
          <div class="box-footer text-center">
            <a href="/admin/incident" class="uppercase">View All Incidents</a>
          </div><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->

  </section><!-- /.content -->
 
</div><!-- /.content-wrapper -->
<!-- ...................................... END OF MAIN CONTENT................................................. -->