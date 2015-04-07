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
      <div class="col-md-8">
        <!-- MAP & BOX PANE -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Map Overview</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body no-padding">
            <div class="row">
              <div class="col-md-9 col-sm-8">
                <div class="pad">
                  <!-- Map will be created here -->
                  <div id="world-map-markers" style="height: 325px;"><img src="../dist/img/sample_map.gif" width="540px" height="325"></div>
                </div>
              </div><!-- /.col -->
             <div class="col-md-3 col-sm-4">
                <div class="pad box-pane-right bg-green" style="min-height: 280px">
                  <div class="description-block margin-bottom">
                    <div class="sparkbar pad" data-color="#fff"><u>PSI READING</u></div>
                    <h5 class="description-header">58</h5>
                  </div><!-- /.description-block -->
                  <div class="description-block margin-bottom">
                    <div class="sparkbar pad" data-color="#fff"><u>DATE / TIME</u></div>
                    <h5 class="description-header">16 March 2015</h5>
                    <span class="description-text">13:00</span>
                  </div><!-- /.description-block -->
                  <div class="description-block">
                    <div class="sparkbar pad" data-color="#fff"><u>AIR QUALITY</u></div>
                    <h5 class="description-header">Moderate</h5>
                  </div><!-- /.description-block -->
                </div>
              </div><!-- /.col -->  
            </div><!-- /.row -->
          </div><!-- /.box-body -->
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
        <!-- TABLE: LATEST PSI READINGS -->
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
          <div class="box-footer clearfix">
            <a href="javascript::;" class="btn btn-sm btn-info btn-flat pull-left">Update Records</a>
            <a href="javascript::;" class="btn btn-sm btn-default btn-flat pull-right">View Reports</a>
          </div><!-- /.box-footer -->
        </div><!-- /.box -->
      </div><!-- /.col -->

       <!-- RECENTLY ADDED INCIDENTS -->
      <div class="col-md-4">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Recently Added Incidents</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div><!-- /.box-header -->
          <div class="box-body">
            <ul class="products-list product-list-in-box">
              <?php foreach ($incidents as $i) { 
                $label = ($i->incidentStatus === 'On-going') ? 'success' : 'danger';
              ?>
              <li class="item">
                <div class="product-img">
                  <img src="http://placehold.it/50x50/d2d6de/ffffff" alt="Product Image"/>
                </div>
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