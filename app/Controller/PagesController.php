<?php
App::uses('AppController', 'Controller');

class PagesController extends AppController {
    public $uses = array();

    public $service;

    public $folderId;

    public function beforeFilter()
    {
        parent::beforeFilter();

        $this->service = new Google_Service_Drive($this->googleClient);

        // Check have FOLDER or not?
        $_folder = $this->service->children->listChildren('root', array(
            'q' => "title = 'Cake Drive' and mimeType = 'application/vnd.google-apps.folder'"
        ));

        if ($_folder->count() > 0) {
            $this->folderId = $_folder->offsetGet(0)->id;
        } else {
            $file = new Google_Service_Drive_DriveFile();

            $file->setTitle('Cake Drive');
            $file->setDescription('Cake Drive');
            $file->setMimeType('application/vnd.google-apps.folder');

            $_folder = $this->service->files->insert($file);

            $this->folderId = $_folder->id;
        }
    }

	public function index() {
        $_files = $this->service->children->listChildren($this->folderId);

        $files = array();

        $_count = $_files->count();
        for ($i = 0; $i < $_count; $i++) {
            $_tmp  = $_files->offsetGet($i);
            $_file = $this->service->files->get($_tmp->id);

            $files[] = array(
                'id'    => $_tmp->id,
                'title' => $_file->title
            );
        }

        $this->set(compact('files'));
	}

    public function create()
    {
        if ($this->request->is('POST')) {
            $file   = new Google_Service_Drive_DriveFile();
            $parent = new Google_Service_Drive_ParentReference();

            $file->setTitle($this->request->data('title'));
            $file->setDescription($this->request->data('description'));
            $file->setMimeType('text/plain');

            $parent->setId($this->folderId);
            $file->setParents(array($parent));

            $created = $this->service->files->insert($file, array(
                'data' => $this->request->data('content'),
                'mimeType' => 'text/plain',
                'uploadType' => 'media',
            ));

            $this->redirect(array('action' => 'index'));
        }
    }

    public function edit($fileId = null)
    {
        $file = $this->service->files->get($fileId);

        if ($this->request->is('GET')) {
            $this->request->data = array(
                'title'       => $file->title,
                'description' => $file->description,
                // 'content'     => $file->content
            );
        }

        if ($this->request->is('POST')) {
            $file->setTitle($this->request->data('title'));
            $file->setDescription($this->request->data('description'));
            $file->setMimeType('text/plain');

            $created = $this->service->files->update($fileId, $file, array(
                'data' => $this->request->data('content'),
                'mimeType' => 'text/plain',
                'uploadType' => 'media',
            ));

            $this->redirect(array('action' => 'index'));
        }

    }

}
