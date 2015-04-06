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

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SubscribeController extends AppController
{

    public function index()
    {
        parent::index();

        $this->set('page', 'subscribe');

    }

    public function subscribe()
    {
        $this->autoRender = false;
    	$this->loadModel('Subscriber');
        if ($this->request->is('post')) {
            $subscriber = $this->Subscriber->newEntity();
            $subscriber = $this->Subscriber->patchEntity($subscriber, $this->request->data);

            if (!$subscriber->errors()){
            	if ($this->Subscriber->save($subscriber)) {
	                $this->Flash->success(__('Your subscription has been created'));
	                return $this->redirect(['action' => 'index']);
	            }else{
	                $this->Flash->error(__('Unable to create subscription'));
	                return $this->redirect(['action' => 'index']);
	            }
            }else{
                $this->Flash->error(__($subscriber->errors()['email']['unique']));
                return $this->redirect(['action' => 'index']);
            }
            
        }
    }
}
