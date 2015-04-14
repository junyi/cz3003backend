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
namespace App\Controller\Admin;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Error\Debugger;
use Cake\Datasource\ConnectionManager;
use App\Controller\SSP;
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

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    private function getIncident($id)
    {
        // $query = $this->Incident->find('all', [
        //     'where' => ['incidentID' => $id]
        // ]);

        // $incident = $query->first();
        $incident = $this->Incident->get($id);

        return $incident;
    }

    private function getIncidents()
    {
        $query = $this->Incident->find('all')
            ->order(['incidentStatus' => 'ASC', 'incidentDateTime' => 'ASC'])
            ->contain(['IncidentCategory']);

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
            return [
                    'title' => $v->incidentCategoryTitle,
                    'id' => $v->incidentCategoryID
                ];
        }, $results);

        $this->set('incident_category_options', $results);
    }

    public function index()
    {
        if ($this->request->params['_ext'] === 'json') {

            if (($this->request->is('get') || $this->request->is('ajax')) && isset($this->request->query['draw'])) {
                $connection = ConnectionManager::get('default');

                $columns = [
                    ['db'=>'incidentID', 'dt'=>'DT_RowId'],
                    ['db'=>'incidentTitle', 'dt'=>1],
                    ['db'=>'incidentDateTime', 'dt'=>2],
                    ['db'=>'address', 'dt'=>3],
                    ['db'=>'incidentCategoryTitle', 'dt'=>4],
                    ['db'=>'incidentStatus', 'dt'=>5]
                ];

                $joinQuery = "FROM Incident AS c JOIN IncidentCategory AS ic ON c.incidentCategoryID=ic.incidentCategoryID";

                $results = SSP::simple($this->request->query, $connection, 'Incident', 'incidentID', $columns, $joinQuery);
                $this->set('incidents', $results);

            } else {
                $this->set('incidents', []);
            }

        } else {
            parent::index();

            $this->set('page', 'incidents');
            $this->set('incidents', []);

            // $this->getIncidents();
        }
    }

    public function form()
    {
        if ($this->request->is('get')) {
            $action = $this->request->query['action'];

            $this->set('incident', false);

            if ($action === 'add') {
                $this->getIncidentCategoryOptions();
                $this->set('header', "Add Incident");
                $this->set('action', '/admin/incident/'.$action);

            } else if ($action === 'edit') {
                $id = $this->request->query['id'];

                $this->getIncidentCategoryOptions();
                $this->set('header', "Edit Incident");
                $this->set('action', '/admin/incident/'.$action.'?id='.$id);
                $incident = $this->getIncident($id);
                $this->set('incident', $incident);

            }
        }
    }

    public function add()
    {
        $this->autoRender = false;
        $incident = $this->Incident->newEntity();
        if ($this->request->is('post')) {
            $incident = $this->Incident->patchEntity($incident, $this->request->data);

            $session = $this->request->session();
            $user = $session->read('Auth.User');
            $incident->set('staffID', $user['staffID']);
            
            if ($this->Incident->save($incident)) {
                $id = $incident->incidentID;
                $this->set('data', ["id" => $id, "message" => "The incident has been added.", "success" => true]);
                $this->render('/Element/ajaxreturn');
            }else{
                $this->set('data', ["message" => "Unable to add your incident.", "success" => false]);
                $this->render('/Element/ajaxreturn');
            }
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function edit()
    {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $id = $this->request->query['id'];
            $incident = $this->getIncident($id);
            $incident = $this->Incident->patchEntity($incident, $this->request->data);

            $session = $this->request->session();
            $user = $session->read('Auth.User');
            $incident->set('staffID', $user['staffID']);

            if ($this->Incident->save($incident)) {
                $this->set('data', ["message" => "The incident has been edited.", "success" => true]);
                $this->render('/Element/ajaxreturn');
            }else{
                $this->set('data', ["message" => "Unable to edit your incident.", "success" => false]);
                $this->render('/Element/ajaxreturn');
            }
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function delete()
    {
        $this->autoRender = false;
        if ($this->request->is('get')) {
            $id = $this->request->query['id'];
            $incident = $this->getIncident($id);
            if ($this->Incident->delete($incident)) {
                $this->set('data', ["id" => $id, "message" => "The incident has been deleted.", "success" => true]);
                $this->render('/Element/ajaxreturn');
            }else{
                $this->set('data', ["id" => $id, "message" => "Unable to delete your incident.", "success" => false]);
                $this->render('/Element/ajaxreturn');
            }
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }

    public function isAuthorized($user)
    {   
        // Logged in users can access
        if (isset($user['role']) && isset($user['status']) && $user['status'] === 'active') {
            return true;
        }

        // Default deny
        return false;
    }
}
