<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public function login()
    {
        if (!$this->Auth->user()) {
            if (!$this->request->query('code')) {
                $authUrl = $this->googleClient->createAuthUrl();
                $this->redirect($authUrl);
            } else {
                $authCode = $this->request->query('code');
                $this->googleClient->authenticate($authCode);

                $token = $this->googleClient->getAccessToken();

                $user = array(
                    'code' => $authCode,
                    'token' => $token
                );

                if ($this->Auth->login($user)) {
                    $this->redirect($this->Auth->redirect());
                }
            }
        } else {
            $this->redirect($this->Auth->redirect());
        }
    }

    public function logout()
    {
        $this->Auth->logout();
        $this->redirect($this->Auth->redirect());
    }
}
