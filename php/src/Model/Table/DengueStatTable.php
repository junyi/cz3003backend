<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class DengueStatTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('DengueStat');
    }

}
