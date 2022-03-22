<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $this->view->users = Users::find();
    }

    public function signupAction()
    {
        $this->view->value = $this->request->getPost();
        if (($this->request->isPost('name')) || ($this->request->isPost('email'))) {
            $this->view->msg = 'Error';
        }
        if (($this->request->getPost('name')) != null) {
            $user = new Users();
            $user->assign(
                $this->request->getPost(),
                [
                    'name',
                    'email'
                ]
            );
            $success = $user->save();
            if ($success) {
                $this->view->msg = 'Success';
            }
        }
    }
    public function registerAction()
    {
    }
}
