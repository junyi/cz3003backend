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

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class AgencyController extends AppController
{

    public function index()
    {
        parent::index();
        
        $this->set('page', 'agency');

        $query = $this->Agency->find('all');

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

        $this->set('categories', $results);
    }

    private function getAgency($id)
    {
        $agency = $this->Agency->get($id);

        return $agency;
    }

    public function form()
    {
        if ($this->request->is('get')) {
            $action = $this->request->query['action'];

            $this->set('agency', false);

            if ($action === 'add') {
                $this->set('header', "Add Agency");
                $this->set('action', '/admin/agency/'.$action);

            } else if ($action === 'edit') {
                $id = $this->request->query['id'];

                $this->set('header', "Edit Agency");
                $this->set('action', '/admin/agency/'.$action.'?id='.$id);
                $agency = $this->getAgency($id);
                $this->set('agency', $agency);

            }
        }
    }

    public function add()
    {
        $this->autoRender = false;
        $agency = $this->Agency->newEntity();
        if ($this->request->is('post')) {
            $agency = $this->IncidentCategory->patchEntity($agency, $this->request->data);
            if ($this->Agency->save($agency)) {
                $this->Flash->success(__('The agency has been added.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add the agency.'));
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
            $agency = $this->getAgency($id);
            $agency = $this->Agency->patchEntity($agency, $this->request->data);
            if ($this->Agency->save($agency)) {
                $this->Flash->success(__('The agency has been edited.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to edit the agency.'));
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
            $agency = $this->getAgency($id);
            if ($this->Agency->delete($agency)) {
                $this->Flash->success(__('The agency has been deleted.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to delete the agency.'));
            }
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }
}
