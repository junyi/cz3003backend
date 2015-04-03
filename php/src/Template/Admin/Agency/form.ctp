 <?php
  use Cake\Error\Debugger;

  if($agency){
    $agencyName = $agency['agencyName'];
    $agencyContact = $agency['agencyContact'];
  } else {
    $agencyName = "";
    $agencyContact = "";
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
              <input type="text" class="form-control" name="agencyName" id="agency_contact_input" placeholder="Enter agency" value="<?= $agencyContact ?>">
          </div>

          <!-- Multiple select of incident categories -->
          <div class="form-group">
              <label>Incident Categories</label>
              <!-- add select multiple incident categories input here -->

          </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
