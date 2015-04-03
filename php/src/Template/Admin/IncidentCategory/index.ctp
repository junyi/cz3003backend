     
      <link href="dist/css/formStyle.css" rel="stylesheet" type="text/css" />
      <script src='script/incident_categories.js'></script>
      
      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Incident
            <small> to add, edit, or remove incident category</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php?pg=dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Incidents</a></li>
            <li class="active">Incident Category</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div style="width:200px; float:right; margin-top:10px; margin-bottom:10px; ">
            <button class="btn btn-block btn-success" data-remote="/incidentCategory/form?action=add" id="add_incident_category_btn" data-toggle="modal" data-target="#incident_category_modal">Add Incident Category</button>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Incident Categories</h3>
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
                      <th>Incident Category</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                      $num = 1;
                      foreach ($categories as $i) {               
                          echo $this->Html->tableCells(
                              array(
                                  $num++,
                                  $i->incidentCategoryTitle,
                                  $i->incidentCategoryDescription,
                                  '<a href="#" data-toggle="modal" data-remote="/incidentCategory/form?action=edit&id='.$i->incidentCategoryID.'" data-target="#incident_category_modal"> Edit </a> | <a href="/incidentCategory/delete?id='.$i->incidentCategoryID.'" onclick="return confirm(\'Confirm delete?\');">Delete</a>'
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

    
    



 
 


    
