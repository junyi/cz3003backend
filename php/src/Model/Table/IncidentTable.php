<?php
namespace App\Model\Table;

use \ArrayObject;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\Entity;

class IncidentTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('Incident');

        $this->belongsTo('IncidentCategory', [
        	'propertyName' => 'incidentCategory',
            'foreignKey' => 'incidentCategoryID',
            'joinType' => 'INNER',
        ]);
    }

    public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
	{
		if (!empty($entity->incidentDateTime)){
			$datetime = strtotime($entity->incidentDateTime);
	    	$entity->incidentDateTime = date("Y-m-d H:i:s", $datetime);
	    	return true;
	    }
	    return false;
	}

}
