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
            <button class="btn btn-block btn-success" href="remote.html" id="add_incident_btn" data-toggle="modal" data-target="#incident_modal">Add Incident</button>
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
                          echo $this->Html->tableCells(
                              array(
                                  $i->incidentID,
                                  $i->incidentTitle,
                                  $i->incidentDateTime,
                                  $i->address,
                                  $i->incidentCategory->incidentCategoryTitle,
                                  "<span class=\"label ".($status ? "label-success\">" : "label-danger\">").$status."</span>",
                                  '<a href="#" data-toggle="modal" data-target="#editIncident"> Edit </a> | <a href="#">Delete</a>'
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
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="modal_title">Add Incident</h4>
          </div>
          <div class="modal-body">
            <form id="add_incident_form" action="/incident/add" method="post">
              <!-- Incident Title -->
              <div class="form-group">
                  <label>Incident Title</label>
                  <input type="text" class="form-control" name="incidentTitle" id="incident_title_input" placeholder="Enter incident title">
              </div>
              <!-- Date / Time -->
              <div class="form-group">
                  <label>Date/Time</label>
                  <div class="input-group date">
                    <div class="input-group-addon"><span class="fa fa-calendar"></span></div>
                    <input type="text" class="form-control" name="incidentDateTime" placeholder="DD/MM/YYYY hh:mm A" id="incident_datetime_input"/>
                  </div><!-- /.input group -->
              </div><!-- /.form group -->
              <!-- Location -->
              <div class="form-group">
                  <label>Location</label>
                  <input type="text" class="form-control" name="address" id="incident_location_input" placeholder="Enter the location where the incident happened">
                  <div class="details">
                    <input type="hidden" data-geo="lat" name="latitude" value=""/>
                    <input type="hidden" data-geo="lng" name="longitude" value=""/>
                  </div>
              </div>
              <!-- Incident Category -->
              <div class="form-group">
                  <label>Incident Category</label>
                  <select class="form-control" name="incidentCategoryID" id="incident_category_id">
                    <?php foreach($incident_category_options as $k => $v) {?>
                    <option value=<?='"'. ($k+1) . '"'?>><?=$v?></option>
                    <?php }?>
                  </select>
              </div>
              <!-- Status : On-going, Closed -->
              <div class="form-group">
                 <label>Status</label>
                  <select class="form-control" name="incidentStatus" id="incident_status">
                     <option value="On-going">On-going</option>
                     <option value="Closed">Closed</option>
                  </select>
              </div>
              <!-- Remarks -->
              <div class="form-group">
                  <label>Remarks</label>
                  <textarea class="form-control" name="incidentDetails" rows="3" placeholder="Enter remarks" style="resize:vertical"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
          </form>
          </div>
        </div>
      </div>
    </div>
 