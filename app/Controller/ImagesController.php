<?php
App::uses('AppController', 'Controller');
/**
 * Images Controller
 *
 * @property Image $Image
 * @property PaginatorComponent $Paginator
 */
class ImagesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

    public $uses = array('Image', 'User');

    public function beforeFilter()
    {
        parent::beforeFilter();

        if(Configure::read('Auth.enabled'))
            $this->Auth->allow('duplicate_image', 'save_image', 'update_item', 'duplicate_item', 'delete_scenario_datasets');
    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Image->recursive = 0;
		$this->set('images', $this->Paginator->paginate());
	}

    public function display_scenarios()
    {
        $allScenarios = $this->_executeGetRequest('getall');

//        debug($allScenarios);

        $scenarios = array();

        foreach($allScenarios as $scenario)
        {
            array_push($scenarios, array( 'scenarioId'  => $scenario->_id,
                                          'title'       => $scenario->title,
                                          'description' => $scenario->description));
        }

        $this->set('scenarios', $scenarios);
    }

    public function update_item($imageData, $imageName, $datasetId, $userId)
    {
        $this->autoRender = false;

        $dataSet = $this->_executeGetRequest('getdata', $datasetId);

        foreach($dataSet->data as $screenKey => $screen)
        {
            $j = 0;

            $tempScreen = $screen;

            foreach($screen as $element)
            {
                if(is_object($element) and $element->type == 'image')
                {
                    $path = explode('files/', $element->value)[1];

                    if(count($path) > 0 )
                    {
                        $img = base64_encode(file_get_contents('http://' . Configure::read('Domain.base') . $tempScreen[$j]->value));
                        $tempScreen[$j]->value = $img;
                    }

                    if($imageName === $path) {
                        $content = file_get_contents($imageData);

                        $tempScreen[$j]->value = base64_encode($content);
                        $tempScreen[$j]->author = $userId;

                        if (property_exists($tempScreen[$j], 'version')) {

                            if(isset($tempScreen[$j]->version))
                            {
                                $tempScreen[$j]->version = ($tempScreen[$j]->version) + 1;
                            }
                            else
                            {
                                $tempScreen[$j]->version = 1;
                            }
                        }
                    }
                }
                $j++;
            }
            $dataSet->data->$screenKey = $tempScreen;
        }

        $data = array();
        $data['data'] = $dataSet->data;
        $encoded = json_encode($data);
        $this->_executePutRequest('updatedata', $datasetId, $encoded);

        $this->redirect(array('controller' => 'images', 'action' => 'display_scenario', $dataSet->scenarioId));
    }

    public function duplicate_item($imageData, $imageName, $datasetId, $userId)
    {
        $this->autoRender = false;

        $dataSet = $this->_executeGetRequest('getdata', $datasetId);

        $tempElement = '';

        foreach($dataSet->data as $screenKey => $screen)
        {
            $j = 0;

            $tempScreen = $screen;

            foreach($screen as $element)
            {
                if(is_object($element) and $element->type == 'image')
                {
                    $path = explode('files/', $element->value)[1];

                    if(count($path) > 0 )
                    {
                        $img = base64_encode(file_get_contents('http://' . Configure::read('Domain.base') . $tempScreen[$j]->value));
                        $tempScreen[$j]->value = $img;
                    }

                    if($imageName === $path)
                    {
                        $content = file_get_contents($imageData);

                        $tempElement->value     = base64_encode($content);
                        $tempElement->elementId = $tempScreen[$j]->elementId . '_' . ($j);
                        $tempElement->type      = $tempScreen[$j]->type;
                        $tempElement->author    = $userId;
                        $tempElement->version   = 0;

                        array_push($tempScreen, $tempElement);
                    }
                }
                $j++;
            }
            $dataSet->data->$screenKey = $tempScreen;
        }

        $data = array();
        $data['data'] = $dataSet->data;
        $encoded      = json_encode($data);
        $this->_executePutRequest('updatedata', $datasetId, $encoded);

        $this->redirect(array('controller' => 'images', 'action' => 'display_scenario', $dataSet->scenarioId));
    }

    public function create_dataset($id)
    {
        $this->autoRender = false;

        $content = file_get_contents('http://upload.wikimedia.org/wikipedia/en/a/a6/Bender_Rodriguez.png');

        $data = array();
        $data['groupname'] = 'API_TEST';

//        $data['_id'] = '544d490b3c710bfe6d015293';
//        $data['scenarioId'] = '544d25543c710bfe6d01528f';
//        $data['_v'] = '1';

        $data['data'] = array('screen1' => array(array('elementId' => 'ci2', 'type' => 'image', 'value' => base64_encode($content))));

        $encoded = json_encode($data);

        $this->_executePostRequest('newdata', $id, $encoded);

        $this->redirect(array('controller' => 'images', 'action' => 'display_scenario', $id));

    }

    public function _executePutRequest($api = 'newdata', $id, $data)
    {
        App::uses('HttpSocket', 'Network/Http');
        $HttpSocket = new HttpSocket();

        $response = $HttpSocket->put('http://' . Configure::read('Domain.base') . DIRECTORY_SEPARATOR .
                                                 Configure::read('Domain.app')  . DIRECTORY_SEPARATOR .
                                                 $api . DIRECTORY_SEPARATOR . $id,
                                     $data,
                                     array('header' => array(
                                            'Content-Type' => 'application/json',
                                     )));

        if ($response->code != 200)
            return false;
    }

    public function _executePostRequest($api = 'newdata', $id, $data)
    {
        App::uses('HttpSocket', 'Network/Http');
        $HttpSocket = new HttpSocket();

        $response = $HttpSocket->post('http://' . Configure::read('Domain.base') . DIRECTORY_SEPARATOR .
            Configure::read('Domain.app')  . DIRECTORY_SEPARATOR .
            $api . DIRECTORY_SEPARATOR . $id,
            $data,
            array('header' => array(
                'Content-Type' => 'application/json',
            )));

        if ($response->code != 200)
            return false;
    }

    public function display_scenario($id)
    {
        $scenarioDatas = $this->_executeGetRequest('getscenariodata', $id);
        $images = array();

        debug($scenarioDatas);

        if(!empty($scenarioDatas))
        {
            foreach($scenarioDatas as $scenarioData)
            {
                if(isset($scenarioData->data))
                {
                    foreach($scenarioData->data as $screenKey => $screenValue)
                    {
                        foreach($screenValue as $element)
                        {
                            if(is_object($element) and $element->type == 'image')
                            {
                                if ($this->verifyExtension($element->value))
                                {
                                    if(isset($element->author))
                                    {
                                        $user = $this->User->find('first', array('conditions' => array('User.id' => $element->author)));
                                    }

                                    array_push($images, array( 'image' => 'http://' .Configure::read('Domain.base') . $element->value,
                                                               'datasetId' => $scenarioData->_id,
                                                               'name' => explode('es/', $element->value)[1],
                                                               'user' => (isset($user) ? $user : null),
                                                               'version' => (isset($element->version) ? $element->version : 0)));
                                    $user = null;
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->set('auth', $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')))));
        $this->set('images', $images);
        $this->set('scenarioId', $id);
        $this->set('user', $this->Auth->user('id'));
    }

    public function delete_scenario_datasets($scenarioId)
    {
        $this->autoRender = false;
        $scenarioDatas = $this->_executeGetRequest('getscenariodata', $scenarioId);

        if(!empty($scenarioDatas))
        {
            foreach ($scenarioDatas as $scenarioData)
            {
                $this->_executeGetRequest('deletedata', $scenarioData->_id);
            }
        }
        $this->redirect(array('controller' => 'images', 'action' => 'display_scenario', $scenarioId));
    }

    public function duplicate_image($imageName, $datasetId, $userId)
    {
        $this->autoRender = false;

        $this->duplicate_item($_REQUEST['image'], $imageName, $datasetId, $userId);

    }

    public function save_image($imageName, $datasetId, $userId)
    {
        $this->autoRender = false;

        $this->update_item($_REQUEST['image'], $imageName, $datasetId, $userId);


    }

    public function display_images()
    {
        // Get all data from all scenarios
        $allData = $this->_executeGetRequest('getalldata');

        debug($allData);
        // Create an empty array to hold our image paths
        $images = array();

        // Loop through the scenario data
        if($allData)
        {
            // Loop through the each individual scenario
            foreach($allData as $item)
            {
                // If we have a \'screen1\' object then examine it
                if(isset($item->data->screen1))
                {
                    // Go through each attribute of the \'screen1\' object
                    foreach($item->data->screen1 as $element)
                    {
                        // Verify we have an object with image type
                        if(is_object($element) and $element->type == 'image')
                        {
                            // Double check we have an extension
                            if($this->verifyExtension($element->value))
                                // Build the full path to the image and push it to the end of the images array
                                array_push($images, 'http://' .Configure::read('Domain.base') . $element->value);
                        }
                    }
                }
            }
            // Set the images array for use in the view
            $this->set('images', $images);
        }
    }

    /**
     * Convenience method to verify the extension of the path.
     * @param $toVerfiy
     * @return bool true if valid, false otherwise
     *
     */
    private function verifyExtension($toVerfiy)
    {
        $path = strtolower($toVerfiy);
        if (strpos($path, 'jpg') !== false || strpos($path, 'png') !== false || strpos($path, 'gif') !== false)
            return true;

        return false;
    }

    /**
     * Performs an HTTP GET request using some Caketastic nifftyness.
     *
     * @param string $path e.g. the api to call
     * @return bool|mixed
     */
    public function _executeGetRequest($path = 'getall', $id = null)
    {
        App::uses('HttpSocket', 'Network/Http');
        $HttpSocket = new HttpSocket();

        // Let's purge the cache
        $response = $HttpSocket->request(array('method' => 'GET',
            'uri' => array(
                'scheme' => 'http',
                'host' => Configure::read('Domain.base') . DIRECTORY_SEPARATOR . Configure::read('Domain.app'),
                'port' => 80,
                'path' => (isset($id) ? $path . DIRECTORY_SEPARATOR . $id : $path))));

        if ($response->code != 200)
            return false;

        return json_decode($response['body']);
    }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Image->exists($id)) {
			throw new NotFoundException(__('Invalid image'));
		}
		$options = array('conditions' => array('Image.' . $this->Image->primaryKey => $id));
		$this->set('image', $this->Image->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Image->create();
			if ($this->Image->save($this->request->data)) {
				$this->Session->setFlash(__('The image has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.'));
			}
		}
		$images = $this->Image->find('list');
		$Users = $this->User->find('list');
		$this->set(compact('images', 'Users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Image->exists($id)) {
			throw new NotFoundException(__('Invalid image'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Image->save($this->request->data)) {
				$this->Session->setFlash(__('The image has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The image could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Image.' . $this->Image->primaryKey => $id));
			$this->request->data = $this->Image->find('first', $options);
		}
		$images = $this->Image->find('list');
		$Users = $this->Image->User->find('list');
		$this->set(compact('images', 'Users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Image->id = $id;
		if (!$this->Image->exists()) {
			throw new NotFoundException(__('Invalid image'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Image->delete()) {
			$this->Session->setFlash(__('The image has been deleted.'));
		} else {
			$this->Session->setFlash(__('The image could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
