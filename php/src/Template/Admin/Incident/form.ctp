<?php
  use Cake\Error\Debugger;

  if($incident){
    $incidentTitle = $incident['incidentTitle'];
    $incidentDateTime = $incident['incidentDateTime']->format('d-m-Y h:i A');
    $incidentDateTime = str_replace('-', '/', $incidentDateTime);
    // $incidentDateTime = $incident['incidentDateTime']->nice();
    $address = $incident['address'];
    $latitude = $incident['latitude'];
    $longitude = $incident['longitude'];
    $incidentCategoryID = $incident['incidentCategoryID'];
    $incidentStatus = $incident['incidentStatus'];
    $incidentDetails = $incident['incidentDetails'];
  } else {
    $incidentTitle = "";
    $incidentDateTime = "";
    $address = "";
    $latitude = "";
    $longitude = "";
    $incidentCategoryID = "";
    $incidentStatus = "";
    $incidentDetails = "";
  }

  $this->layout = false;
?>

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal_title"><?= $header ?></h4>
      </div>
      <div class="modal-body">

        <form id="add_incident_form" action="<?= $action ?>" method="post">
          <!-- Incident Title -->
          <div class="form-group">
              <label>Incident Title</label>
              <input type="text" class="form-control" name="incidentTitle" id="incident_title_input" placeholder="Enter incident title" value="<?= $incidentTitle ?>">
          </div>
          <!-- Location -->
          <div class="form-group">
              <label>Location</label>
              <input type="text" class="form-control" value="<?= $address ?>" name="address" id="incident_location_input" placeholder="Enter the location where the incident happened">
              <div class="details">
                <input type="hidden" data-geo="lat" name="latitude" value="<?= $latitude ?>"/>
                <input type="hidden" data-geo="lng" name="longitude" value="<?= $longitude ?>"/>
              </div>
          </div>
          <!-- Incident Category -->
          <div class="form-group">
              <label>Incident Category</label>
              <select class="form-control" name="incidentCategoryID" id="incident_category_id">
                <?php foreach($incident_category_options as $v) {?>
                <option <?php if($incidentCategoryID == $v['id']){echo "selected";} ?> value=<?='"'. $v['id'] . '"'?>><?=$v['title']?></option>
                <?php }?>
              </select>
          </div>
          <!-- Status : On-going, Closed -->
          <div class="form-group">
             <label>Status</label>
              <select class="form-control" name="incidentStatus" id="incident_status">
                 <option <?php if($incidentStatus == "On-going"){echo "selected";}?> value="On-going">On-going</option>
                 <option <?php if($incidentStatus == "Closed"){echo "selected";}?> value="Closed">Closed</option>
              </select>
          </div>
          <!-- Remarks -->
          <div class="form-group">
              <label>Remarks</label>
              <textarea class="form-control" name="incidentDetails" rows="3" placeholder="Enter remarks" style="resize:vertical"><?= $incidentDetails ?></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
