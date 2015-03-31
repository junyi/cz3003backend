<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class IncidentCategoryTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('IncidentCategory');
    }

}
