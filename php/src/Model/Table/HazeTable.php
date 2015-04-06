<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class HazeTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('Haze');
    }

}
