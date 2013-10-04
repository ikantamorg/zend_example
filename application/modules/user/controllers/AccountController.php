<?php

class User_AccountController extends Ikantam_Controller_Front
{

    const EMAIL_SENT          = 'Email with recovery link has been sent.';
    const ERROR_INVALID_TOKEN = 'The token you provided is invalid or expired.';
    const PASSWORD_CHANGED    = 'Your password has been successfully updated. Please try login again.';

    public function init()
    {
        
    }

    public function indexAction()
    {
        if (!$this->_getSession()->isLoggedIn()) {
            $this->_redirectSuccess('login', 'auth', 'user');
        }
    }

    public function recoveryAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirectSuccess('index', 'account', 'user');
        }

        $this->view->messages = $this->_getSession()->getMessages('success');

        $form = new User_Form_Account_Recovery();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                $this->_helper->getHelper('password')->remind($form->getValues());
                $this->_getSession()->addMessage('success', self::EMAIL_SENT);
                $this->_redirectSuccess('recovery', 'account', 'user');
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }

        $this->view->form = $form;
    }

    public function resetPasswordAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirectSuccess('index', 'account', 'user');
        }

        $this->view->messages = $this->_getSession()->getMessages('success');

        $token = $this->getRequest()->getParam('token');
        $form  = new User_Form_Account_ResetPassword();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                if ($this->_helper->getHelper('password')->reset($token, $form->getValues())) {
                    $this->_getSession()->addMessage('success', self::PASSWORD_CHANGED);
                    $this->_redirectSuccess('login', 'auth', 'user');
                } else {
                    $form->addErrorMessage(self::ERROR_INVALID_TOKEN);
                }
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        } else {
            $reminder = new User_Model_Reminder();
            $reminder->retrieveByToken($token);
            if (!$reminder->isValid($token)) {
                $form->addErrorMessage(self::ERROR_INVALID_TOKEN);
            }
        }

        $this->view->form = $form;
    }

}