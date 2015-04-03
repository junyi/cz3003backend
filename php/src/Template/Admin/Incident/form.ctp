<?php
  use Cake\Error\Debugger;

  if($incidentCategory){
    $incidentCategoryTitle = $incidentCategory['incidentCategoryTitle'];
    $incidentDetails = $incidentCategory['incidentCategoryDescription'];
  } else {
    $incidentCategoryTitle = "";
    $incidentCategoryDetails = "";
  }

  $this->layout = false;
?>



      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal_title"><?= $header ?></h4>
      </div>
      <div class="modal-body">

        <form id="add_incident_categories_form" action="<?= $action ?>" method="post">
          <!-- Incident Title -->
          <div class="form-group">
              <label>Incident Category</label>
              <input type="text" class="form-control" name="incidentCategoryTitle" id="incident_category_title_input" placeholder="Enter incident title" value="<?= $incidentCategoryTitle ?>">
          </div>
  
          <!-- Description -->
          <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" name="incident_category_description_input" rows="3" placeholder="Enter remarks" style="resize:vertical"><?= $incidentCategoryDetails ?></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
