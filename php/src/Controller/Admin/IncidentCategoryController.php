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
class IncidentCategoryController extends AppController
{

    public function index()
    {
        parent::index();
        
        $this->set('page', 'incident_category');

        $query = $this->IncidentCategory->find('all');

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

    private function getIncidentCategory($id)
    {
        $incidentCategory = $this->IncidentCategory->get($id);

        return $incidentCategory;
    }

    public function form()
    {
        if ($this->request->is('get')) {
            $action = $this->request->query['action'];

            $this->set('incidentCategory', false);

            if ($action === 'add') {
                $this->set('header', "Add Incident Category");
                $this->set('action', '/incidentCategory/'.$action);

            } else if ($action === 'edit') {
                $id = $this->request->query['id'];

                $this->set('header', "Edit Incident Category");
                $this->set('action', '/incidentCategory/'.$action.'?id='.$id);
                $incidentCategory = $this->getIncidentCategory($id);
                $this->set('incidentCategory', $incidentCategory);

            }
        }
    }

    public function add()
    {
        $this->autoRender = false;
        $incidentCategory = $this->IncidentCategory->newEntity();
        if ($this->request->is('post')) {
            $incidentCategory = $this->IncidentCategory->patchEntity($incidentCategory, $this->request->data);
            if ($this->IncidentCategory->save($incidentCategory)) {
                $this->Flash->success(__('The incident category has been added.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to add your incident category.'));
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
            $incidentCategory = $this->getIncidentCategory($id);
            $incidentCategory = $this->IncidentCategory->patchEntity($incidentCategory, $this->request->data);
            if ($this->IncidentCategory->save($incidentCategory)) {
                $this->Flash->success(__('The incident category has been edited.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to edit your incident category.'));
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
            $incidentCategory = $this->getIncidentCategory($id);
            if ($this->IncidentCategory->delete($incidentCategory)) {
                $this->Flash->success(__('The incident category has been deleted.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to delete your incident category.'));
            }
        } else {
            return $this->redirect(['action' => 'index']);
        }
    }
}
