<?php
	if ($ajax) {
		echo json_encode($incidents);
		
	} else {

		foreach ($incidents as $incident) {
			if($incident->incidentStatus === 'On-going'){
				unset($incident->staffID);
				unset($incident->publicName);
				unset($incident->publicContact);
				$incident->incidentCategory = $incident->incidentCategory->incidentCategoryTitle;

			} else {
				echo json_encode(["error" => "Permission denied"]);
				return;
			}
		}

		echo json_encode($incidents);
		
	}
	
?>