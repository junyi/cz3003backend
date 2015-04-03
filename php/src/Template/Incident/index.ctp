<?php

use Cake\Error\Debugger;

?>


      <!-- ........................................COPY HERE........................................ -->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Incident
            <small> to add, edit, or remove incident</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Incidents</a></li>
            <li class="active">Incidents</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div style="width:200px; float:right; margin-top:10px; margin-bottom:10px; ">
            <button class="btn btn-block btn-success" data-remote="/incident/form?action=add" id="add_incident_btn" data-toggle="modal" data-target="#incident_modal">Add Incident</button>
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
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    <?php 
                      foreach ($incidents as $i) {               
                          $status = $i->incidentStatus;
                          $incidentDateTime = $i['incidentDateTime']->format('d-m-Y h:i A');
                          $incidentDateTime = str_replace('-', '/', $incidentDateTime);
                          echo $this->Html->tableCells(
                              array(
                                  $i->incidentID,
                                  $i->incidentTitle,
                                  $incidentDateTime,
                                  $i->address,
                                  $i->incidentCategory->incidentCategoryTitle,
                                  /*if($status == "On-going"){
                                     ?><span class="label label-success">On-going</span><?php
                                  }else if ($status == "Closed")
                                     ?><span class="label label-danger">Closed</span><?php
                                  }else if ($status == "Pending"){
                                     ?><span class="label label-warning">Pending</span><?php
                                  }*/
                                  ($status=='On-Going')?.'<span class="label label-success">On-going</span>'.:.'<span class="label label-danger">Closed</span>'
                                  /*"<span class=\"label ".($status == 'On-Going' ? "label-success">" : "label-danger\">").$status."</span>"*/,

                                  '<a href="#" data-toggle="modal" data-remote="/incident/form?action=edit&id='.$i->incidentID.'" data-target="#incident_modal"> Edit </a> | <a href="/incident/delete?id='.$i->incidentID.'" onclick="return confirm(\'Confirm delete?\');">Delete</a>'
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
    <div class="modal fade" id="incident_modal" tabindex="-1" role="dialog" aria-labelledby="Incident modal" aria-hidden="true">
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
 