<?php
App::uses('Controller', 'Controller');

require_once APPLIBS . 'google-api' . DS .'autoload.php';

class AppController extends Controller {
    public $theme = "Cakestrap";

    public $helpers = array('Html', 'Form');

    public $components = array('Auth');

    public $googleClient = null;

    public function beforeFilter()
    {
        parent::beforeFilter();

        // Init Google Client
        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId(Configure::read('Google.client_id'));
        $this->googleClient->setClientSecret(Configure::read('Google.client_secret'));
        $this->googleClient->setRedirectUri(Configure::read('Google.redirect_uri'));
        $this->googleClient->setScopes(array(
            'https://www.googleapis.com/auth/drive',
            'https://www.googleapis.com/auth/drive.file',
            'https://www.googleapis.com/auth/drive.appdata',
            'https://www.googleapis.com/auth/drive.apps.readonly'
        ));

        if ($this->Auth->user()) {
            $this->googleClient->setAccessToken($this->Auth->user('token'));
        }
    }
}
