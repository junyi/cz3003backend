<?php
namespace App\Model\Table;

use \ArrayObject;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\Entity;
use \DateTimeZone;
use \DateTime;

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
	    	// $entity->incidentDateTime = date("Y-m-d H:i:s", $datetime);

            $src_tz = new DateTimeZone('Asia/Singapore');
            $dest_tz = new DateTimeZone('UTC');

            $dt = new DateTime($entity->incidentDateTime, $src_tz);
            $dt->setTimeZone($dest_tz);

            $entity->incidentDateTime = $dt->format('Y-m-d H:i:s');
	    	return true;
	    }
	    return false;
	}
}
