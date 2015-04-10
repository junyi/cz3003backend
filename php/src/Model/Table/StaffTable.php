<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Utility\Security;

class StaffTable extends Table
{

	public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('name', 'A name is required')
            ->notEmpty('username', 'A username is required')
            ->notEmpty('password', 'A password is required')
            ->notEmpty('email', 'An e-mail is required')
            ->notEmpty('role', 'A role is required')
            ->add('role', 'inList', [
                'rule' => ['inList', ['Call Operator', 'Administrative']],
                'message' => 'Please enter a valid role'
            ])
            ->notEmpty('gender', 'A gender is required')
            ->notEmpty('status', 'A status is required')
            ->add('status', 'inList', [
                'rule' => ['inList', ['active', 'inactive']],
                'message' => 'Please enter a valid status'
            ]);
    }

    public function initialize(array $config)
    {
        $this->table('Staff');
    }

    public function beforeSave($event, $entity, $options)
    {
        if (!$this->staffID && !$entity->password) {
            $entity->password = hash("sha256", "password");
        } else {
            $entity->password = hash("sha256", $entity->password);
        }

        return true;
    }

}
