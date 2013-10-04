<?php

class User_AuthController extends Ikantam_Controller_Front
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->_forward('login', 'auth', 'user');
    }

    public function loginAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirectSuccess('index', 'account', 'user');
        }

        $this->view->messages = $this->_getSession()->getMessages('success');

        $form = new User_Form_Auth_Login();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                if ($this->_helper->getHelper('auth')->login($form->getValues())) {
                    $this->_redirectSuccess('index', 'account', 'user');
                } else {
                    $form->addErrorMessage(User_Form_Auth_Login::ERROR_USER_DOES_NOT_EXIST);
                }
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }

        $this->view->form = $form;
    }

    public function logoutAction()
    {
        $this->_helper->getHelper('auth')->logout();

        $this->_redirectSuccess('login', 'auth', 'user');
    }

}
