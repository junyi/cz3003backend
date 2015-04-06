<?php

namespace App\Controller;

use Cake\Controller\Controller;

class AppController extends Controller
{
	public function index()
    {
    }

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */

    public function initialize()
    {
        $this->loadComponent('Flash');
    }
}
