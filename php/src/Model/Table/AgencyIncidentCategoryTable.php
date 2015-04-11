<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AgencyIncidentCategoryTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('Agency_IncidentCategory');

        $this->belongsTo('Agency', [
        	'className' => 'Agency',
            'foreignKey' => 'agencyID',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('IncidentCategory', [
        	'className' => 'IncidentCategory',
            'foreignKey' => 'incidentCategoryID',
            'joinType' => 'INNER',
        ]);
    }

}
