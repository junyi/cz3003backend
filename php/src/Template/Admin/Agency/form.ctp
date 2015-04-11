 <?php
  use Cake\Error\Debugger;

  if($agency){
    $agencyName = $agency['agencyName'];
    $agencyContact = $agency['agencyContact'];
    $incidentCategory = [];
    foreach ($agency['incidentCategory'] as $i) {
      array_push($incidentCategory, $i->incidentCategoryID);
    }
  } else {
    $agencyName = "";
    $agencyContact = "";
    $incidentCategory = [];
  }

  $this->layout = false;
?>

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="modal_title"><?= $header ?></h4>
      </div>
      <div class="modal-body">

        <form id="add_agency_form" action="<?= $action ?>" method="post">
          <!-- Agency -->
          <div class="form-group">
              <label>Agency</label>
              <input type="text" class="form-control" name="agencyName" id="agency_name_input" placeholder="Enter agency" value="<?= $agencyName ?>">
          </div>
         
          <!-- Contact -->
          <div class="form-group">
              <label>Contact</label>
              <input type="text" class="form-control" id="contact_input" maxlength="8" name="agencyContact" placeholder="Enter contact no" value="<?= $agencyContact ?>"/>
          </div>
          <!-- Multiple select of incident categories -->
          <div class="form-group">
              <label>Incident Categories</label>
              <!-- add select multiple incident categories input here -->
              <select multiple data-placeholder="Select incident categories" class="form-control chosen-select" name="incidentCategory[_ids][]" id="incident_category_id">
                <?php foreach($incident_category_options as $v) {?>
                <option <?php if(in_array($v['id'], $incidentCategory)){echo "selected";} ?> value=<?='"'. $v['id'] . '"'?>><?=$v['title']?></option>
                <?php }?>
              </select>
          </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
