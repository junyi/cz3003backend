<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class AgencyTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('Dengue');
    }

}
