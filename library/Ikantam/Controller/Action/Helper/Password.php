<?php

class Ikantam_Controller_Action_Helper_Password extends Zend_Controller_Action_Helper_Abstract
{

    protected $_users;
    protected $_mailer;
    protected $_reminder;
    protected $_view;
    protected $_template = 'email_templates/recovery_password.phtml';
    protected $_subject  = 'Reset your password';

    public function __construct()
    {
        $this->_users    = new User_Model_Collection();
        $this->_mailer   = new Application_Model_Mailer();
        $this->_reminder = new User_Model_Reminder();
    }

    /**
     * direct(): Perform helper when called as
     * $this->_helper->passwordReminder($credentials)
     *
     * @param  array  $credentials
     * @return void
     */
    public function direct($credentials)
    {
        $this->remind($credentials);
    }

    public function reset($token, array $credentials)
    {
        $reminder = $this->_getReminder($token);

        if (!$reminder->isValid()) {
            return false;
        }

        $user = $this->_getUser(array('email' => $reminder->getUserEmail()));

        if ($user->hasId()) {
            $newPassword = $this->_hashPassword($credentials['password']);
            
            $user->setPassword($newPassword)
                    ->save();
        }
        
        $reminder->setIsActive(0)->save();

        return true;
    }

    public function remind(array $credentials)
    {
        $user = $this->_getUser($credentials);

        if (!$user->hasId()) {
            return; //$this->makeErrorRedirect('user');
        }

        $token = $this->_reminder->create($user);

        $this->_sendReminder($user, $token);

        return; //$this->redirect->refresh()->with('success', true);
    }

    protected function _sendReminder($user, $token)
    {
        $email   = $user->getEmail();
        $subject = $this->_getSubject();
        $body    = $this->_getEmailBody($token);

        return $this->_mailer->send($email, $subject, $body);
    }

    protected function _getReminder($token)
    {
        return $this->_reminder->retrieveByToken($token);
    }

    /**
     * Get user by credentials
     * 
     * @param array $credentials
     * @return User_Model_User
     */
    protected function _getUser(array $credentials)
    {
        return $this->_users->retrieveByCredentials($credentials);
    }

    /**
     * Get view
     * 
     * @return Zend_View_Interface
     */
    public function getView()
    {
        $controller = $this->getActionController();
        if (null === $controller) {
            $controller = $this->getFrontController();
        }

        return $controller->view;
    }

    protected function _getEmailBody($token)
    {
        $view = $this->getView();

        $view->token = $token;

        $body = $view->render($this->_template);

        return $body;
    }

    protected function _getSubject()
    {
        return $this->_subject;
    }

    
    protected function _hashPassword($password)
    {
        $bc = new Ikantam_Crypt_Password_Bcrypt();
        return $bc->create($password);
    }
}