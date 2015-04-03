<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Error\Debugger;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class IncidentController extends AppController
{
    public $helper = ['Time'];

    private function getIncidents()
    {
        $query = $this->Incident->find('all')->contain(['IncidentCategory']);

        // Iteration will execute the query.
        foreach ($query as $row) {
        }

        // Calling execute will execute the query
        // and return the result set.
        $results = $query->all();

        // Once we have a result set we can get all the rows
        $data = $results->toArray();

        // Converting the query to an array will execute it.
        $results = $query->toArray();

        $this->set('incidents', $results);
    }

    private function getIncidentCategoryOptions()
    {
        $query = $this->Incident->IncidentCategory->find('all');

        // Iteration will execute the query.
        foreach ($query as $row) {
        }

        // Calling execute will execute the query
        // and return the result set.
        $results = $query->all();

        // Once we have a result set we can get all the rows
        $data = $results->toArray();

        // Converting the query to an array will execute it.
        $results = $query->toArray();

        $results = array_map(function($v){
            return $v->incidentCategoryTitle;
        }, $results);

        $this->set('incident_category_options', $results);
    }

    public function index()
    {
        parent::index();

        $this->set('page', 'incident');

        $this->getIncidents();

    }

    public function form()
    {
        if ($this->request->is('get')) {
            $action = $this->request->query['action'];
            if ($action === 'add') {
                $this->getIncidentCategoryOptions();
            }
        }
    }

    public function add()
    {
        $this->autoRender = false;
        $incident = $this->Incident->newEntity();
        if ($this->request->is('post')) {
            $incident = $this->Incident->patchEntity($incident, $this->request->data);
            if ($this->Incident->save($incident)) {
                $this->Flash->success(__('The incident has been added.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add your incident.'));
            }
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function edit()
    {
        $this->autoRender = false;
        $incident = $this->Incident->newEntity();
        if ($this->request->is('post')) {
            $incident = $this->Incident->patchEntity($incident, $this->request->data);
            if ($this->Incident->save($incident)) {
                $this->Flash->success(__('The incident has been added.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add your incident.'));
            }
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function isAuthorized($user)
    {   
        // Logged in users can access
        if (isset($user['role'])) {
            return true;
        }

        // Default deny
        return false;
    }
}
