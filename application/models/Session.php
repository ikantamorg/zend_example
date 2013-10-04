<?php

abstract class Application_Model_Session
{

    protected $_data = array();
    protected $_namespace;
    
    public function __construct()
    {
        $this->_data = $this->_getNamespace()->data;
    }

    abstract public function getUser();

    /**
     * Check whether any user is associated with current session
     * 
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->getUser()->hasId();
    }

    /**
     * Check whether a specific type of messages exists
     * 
     * @param string $type
     * @return boolean
     */
    public function hasMessages($type)
    {
        return $this->_getMessenger()->hasMessages($type);
    }

    /**
     * Get messages of a specific type
     * 
     * @param string $type
     * @return arry
     */
    public function getMessages($type)
    {
        return $this->_getMessenger()->getMessages($type);
    }

    /**
     * Add a message of a specific type
     * 
     * @param string $type
     * @param string $message
     * @return User_Model_Session
     */
    public function addMessage($type, $message)
    {
        $this->_getMessenger()->addMessage($message, $type);
        return $this;
    }

    /**
     * Get instance of FlashMessenger helper
     * 
     * @return Zend_Controller_Action_Helper_FlashMessenger
     */
    protected function _getMessenger()
    {
        if (!$this->_messenger) {
            $this->_messenger = new Zend_Controller_Action_Helper_FlashMessenger();
        }
        return $this->_messenger;
    }

    public function addData(array $arr)
    {
        foreach ($arr as $index => $value) {
            $this->setData($index, $value);
        }
        return $this;
    }

    public function setData($key, $value = null)
    {
        if (is_array($key)) {
            $this->_data = $key;
        } else {
            $this->_data[$key] = $value;
        }

        $this->_getNamespace()->data = $this->_data;

        return $this;
    }
    
    public function unsetData($key = null)
    {
        if (is_null($key)) {
            $this->_data = array();
        } else {
            unset($this->_data[$key]);
        }
        
        $this->_getNamespace()->data = $this->_data;
        
        return $this;
    }

    public function getData($key = '', $default = null)
    {
        if ($key === '') {
            return $this->_data;
        }

        return $this->_getData($key, $default);
    }

    protected function _getData($key, $default)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : $default;
    }

    /**
     * 
     * @return Zend_Session_Namespace
     */
    protected function _getNamespace()
    {
        if (!$this->_namespace) {
            $this->_namespace = new Zend_Session_Namespace();
        }
        return $this->_namespace;
    }

}