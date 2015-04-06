<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class IncidentCategoryStatTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('IncidentCategoryStat');
        $this->belongsTo('IncidentCategory', [
        	'propertyName' => 'incidentCategory',
            'foreignKey' => 'incidentCategoryID',
            'joinType' => 'INNER',
        ]);
    }

}
