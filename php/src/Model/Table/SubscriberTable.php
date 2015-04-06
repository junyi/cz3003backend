<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubscriberTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('Subscriber');
    }

	public function validationDefault(Validator $validator)
    {
        $validator
            ->add('email', [
            	'validFormat' => [
			        'rule' => 'email',
			        'message' => 'Email must be valid'
			    ], 
		    	'unique' => [
		    		'rule' => 'validateUnique', 
		    		'message' => 'This email has been previously subscribed',
		    		'provider' => 'table'
		    	]
		    ]);

        return $validator;
    }
}
