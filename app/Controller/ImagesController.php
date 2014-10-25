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

        if(!Configure::read('Auth.enabled'))
            $this->Auth->allow();
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

    public function display_scenario($id)
    {
        $scenarioDatas = $this->_executeGetRequest('getscenariodata', $id);
        $images = array();

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
                                    array_push($images, 'http://' .Configure::read('Domain.base') . $element->value);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->set('images', $images);
        $this->set('scenarioId', $id);
    }

    public function save_image()
    {
        $this->autoRender = false;

    }

    public function display_images()
    {
        // Get all data from all scenarios
        $allData = $this->_executeGetRequest('getalldata');

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
