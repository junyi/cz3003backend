<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class SubscriberTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('Subscriber');
    }

}
