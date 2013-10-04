<?php

class Ikantam_Controller_Action_Helper_Auth extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * direct(): Perform helper when called as
     * $this->_helper->auth($credentials)
     *
     * @param  array  $credentials
     * @return void
     */
    public function direct(array $credentials)
    {
        return $this->login($credentials);
    }

    public function login(array $credentials)
    {
        $adapter = $this->_getAuthAdapter($credentials);
        $auth    = Zend_Auth::getInstance();
        $result  = $auth->authenticate($adapter);

        if ($result->isValid()) {
            $user = $adapter->getResultRowObject();
            $auth->getStorage()->write($user);
            return true;
        }
        return false;
    }
    
    public function logout()
    {
        Zend_Auth::getInstance()->clearIdentity();
    }
    
    protected function _getAuthAdapter($credentials)
    {
        $dbAdapter   = Zend_Db_Table::getDefaultAdapter();
        $authAdapter = new Ikantam_Auth_Adapter_DbTable_Bcrypt($dbAdapter);

        $authAdapter->setTableName('users')
                ->setIdentityColumn('email')
                ->setCredentialColumn('password');

        $authAdapter->setIdentity($credentials['email']);
        $authAdapter->setCredential($credentials['password']);

        return $authAdapter;
    }

}