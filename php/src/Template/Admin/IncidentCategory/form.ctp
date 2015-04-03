<?php
  use Cake\Error\Debugger;

  if($incidentCategory){
    $incidentCategoryTitle = $incidentCategory['incidentCategoryTitle'];
    $incidentCategoryDetails = $incidentCategory['incidentCategoryDescription'];
  } else {
    $incidentCategoryTitle = "";
    $incidentCategoryDescription = "";
  }

  $this->layout = false;
?>

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal_title"><?= $header ?></h4>
      </div>
      <div class="modal-body">

        <form id="add_incident_category_form" action="<?= $action ?>" method="post">
          <!-- Incident Category -->
          <div class="form-group">
              <label>Incident Category</label>
              <input type="text" class="form-control" name="incidentCategoryTitle" id="incident_category_title_input" placeholder="Enter incident title" value="<?= $incidentTitle ?>">
          </div>
         
          <!-- Description -->
          <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" name="incidentCategoryDetails" rows="3" placeholder="Enter incident category description" style="resize:vertical"><?= $incidentCategoryDescription ?></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="incidentCategory_modal" tabindex="-1" role="dialog" aria-labelledby="IncidentCate modal" aria-hidden="true">
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