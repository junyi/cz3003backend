<?php

	if($incident->incidentStatus === 'On-going'){
		unset($incident->staffID);
		unset($incident->publicName);
		unset($incident->publicContact);
		unset($incident->postDate);

		echo json_encode($incident);
	} else {
		echo json_encode(["error" => "Permission denied"]);
	}

	
?>