<?php

namespace App\Auth;

use Cake\Auth\AbstractPasswordHasher;

class LegacyPasswordHasher extends AbstractPasswordHasher
{

    public function hash($password)
    {
        return hash("sha256", $password);
    }

    public function check($password, $hashedPassword)
    {
        return $this->hash($password) === $hashedPassword;
    }
}