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
use Cake\Event\Event;
use Cake\Error\Debugger;
use Cake\Routing\Router;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class StaffController extends AppController
{
    public $helpers = ['Url'];

    /**
     * uploads files to the server
     * @params:
     *      $folder     = the folder to upload the files e.g. 'img/files'
     *      $formdata   = the array containing the form files
     *      $itemId     = id of the item (optional) will create a new sub folder
     * @return:
     *      will return an array with the success of each file upload
     */
    function uploadFiles($folder, $formdata, $itemId = null) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT.$folder;
        $rel_url ='../'.$folder;
        
        // create the folder if it does not exist
        if(!is_dir($folder_url)) {
            mkdir($folder_url);
        }
            
        // if itemId is set create an item folder
        if($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT.$folder.'/'.$itemId; 
            // set new relative folder
            $rel_url = $folder.'/'.$itemId;
            // create directory
            if(!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }
        
        // list of permitted file types, this is only images but documents can be added
        $permitted = array('image/gif','image/jpeg','image/pjpeg','image/png');
        
        // loop through and deal with the files
        foreach($formdata as $file) {
            // replace spaces with underscores
            $filename = str_replace(' ', '_', $file['name']);
            // assume filetype is false
            $typeOK = false;
            // check filetype is ok
            foreach($permitted as $type) {
                if($type == $file['type']) {
                    $typeOK = true;
                    break;
                }
            }
            
            // if file type ok upload the file
            if($typeOK) {
                // switch based on error code
                switch($file['error']) {
                    case 0:
                        // check filename already exists
                        if(!file_exists($folder_url.'/'.$filename)) {
                            // create full filename
                            $full_url = $folder_url.'/'.$filename;
                            $url = $rel_url.'/'.$filename;
                            // upload the file
                            $success = move_uploaded_file($file['tmp_name'], $url);
                        } else {
                            // create unique filename and upload file
                            ini_set('date.timezone', 'Asia/Singapore');
                            $now = date('Y-m-d-His');
                            $full_url = $folder_url.'/'.$now.$filename;
                            $url = $rel_url.'/'.$now.$filename;
                            $success = move_uploaded_file($file['tmp_name'], $url);
                        }
                        // if upload was successful
                        if($success) {
                            // save the url of the file
                            $result['urls'][] = $url;
                        } else {
                            $result['errors'][] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                        // an error occured
                        $result['errors'][] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                        // an error occured
                        $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'][] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'][] = "$filename cannot be uploaded. Acceptable file types: gif, jpg, png.";
            }
        }
        return $result;
    }

    public function initialize()
    {
        parent::initialize();
    }

    public function index()
    {
        parent::index();
        
        $this->set('page', 'staff_account');

        $query = $this->Staff->find('all');

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

        $this->set('staffs', $results);
        $this->set('header', "Add Account");
    }

    public function isAuthorized($user) {
        return parent::isAuthorized($user);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['logout']);
    }

    public function login()
    {
        $session = $this->request->session();
        $user = $session->read('Auth.User');

        $url = Router::url(array('admin'=>true, 'controller'=>'Dashboard', 'action'=>'index'));

        if ($user) {
            return $this->redirect($url);
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                // $Session->write('Company', $this->User->Company->findById($this->Auth->user('id')));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }

    public function editProfile()
    {
        parent::index();

        $this->set('page', 'edit_profile');

        $session = $this->request->session();
        $sessionUser = $session->read('Auth.User');
        $id = $sessionUser['staffID'];

        if ($this->request->is('post') && $id) {
            

            $user = $this->Staff->get($id);
            $user = $this->Staff->patchEntity($user, $this->request->data);

            $filePath = $this->uploadFiles('uploads', [$this->request->data['file']]);

            if ($filePath) {
                $user->set('photo', $filePath);
            } else {
                $this->Flash->error(__('Unable to upload your photo.'));
                return $this->redirect(['action' => 'index']);
            }

            if ($this->Staff->save($user)) {
                $this->Flash->success(__('Your profile has been updated.'));
                return $this->redirect(['action' => 'index']);
            }else{
                $this->Flash->error(__('Unable to edit your profile.'));
                return $this->redirect(['action' => 'index']);
            }
        } 
        // else {
        //     return $this->redirect(['action' => 'index']);
        // }
    }
}
