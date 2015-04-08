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
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
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

    private function getIncident($id)
    {
        $incident = $this->Incident->get($id);

        return $incident;
    }

	private function getIncidents()
    {
        $query = $this->Incident
            ->find('all')
            ->contain(['IncidentCategory'])
            ->where(['incidentStatus' => 'On-going']);

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

    public function index()
    {

        if ($this->request->params['_ext'] === 'json') {

            $this->getIncidents();

        } else {

            parent::index();

            $this->set('page', 'incidents');

            $this->getIncidents();
        }

    }

    public function view($id)
    {
        $this->set('incident', $this->getIncident($id));
    }

    public function report()
    {
        if ($this->request->is('get')) {
            $this->set('page', 'report_incidents');
            $this->getIncidentCategoryOptions();

        } elseif ($this->request->is('post')) {
            $this->autoRender = false;
            $incident = $this->Incident->newEntity();
            $incident = $this->Incident->patchEntity($incident, $this->request->data);
            $incident['incidentStatus'] = 'Pending';

            if ($this->Incident->save($incident)) {
                $this->Flash->success(__("The incident has been reported. Thank you."));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__("Unable to report the incident. Please try again later."));
                return $this->redirect(['action' => 'report']);
            }
        }
    }
}
