<?php

class Ikantam_Controller_Front extends Zend_Controller_Action
{

    protected $_session = null;

    /**
     * 
     * @return User_Model_Session
     */
    protected function _getSession()
    {
        if (!$this->_session) {
            $this->_session = new User_Model_Session();
        }

        return $this->_session;
    }
    
    /**
     * 
     * @return User_Model_Session
     */
    public function getSession()
    {
        if (!$this->_session) {
            $this->_session = new User_Model_Session();
        }

        return $this->_session;
    }

    protected function _redirectSuccess($action, $controller, $module)
    {
        if ($this->_redirectTo) {
            //@TODO: redirect back
        }
        $this->_helper->redirector($action, $controller, $module);
    }
}