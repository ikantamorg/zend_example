<?php

class User_Model_Session extends Application_Model_Session
{

    protected $_user      = null;
    protected $_messenger = null;

    /**
     * Get user associated with current session
     * 
     * @return User_Model_User
     */
    public function getUser()
    {
        if (!$this->_user) {
            $this->_user = new User_Model_User();

            $auth = Zend_Auth::getInstance();

            if ($auth->hasIdentity()) {
                $data = get_object_vars($auth->getIdentity());
                $this->_user->addData($data);
            }
        }
        return $this->_user;
    }

}