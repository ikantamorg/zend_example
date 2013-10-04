<?php

class User_Model_User extends RedLightCloud_Entity_User
{

    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_PENDING  = 'pending';

    public function getByEmail($email)
    {
        $this->_getBackend()->getByEmail($email, $this);
    }

    protected function _getByEmail($email)
    {
        $this->_getBackend()->getByEmail($email, $this);
    }

    protected function _getBackend()
    {
        return new User_Model_Backend();
    }

    public function save()
    {
        if ($this->hasId()) {
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $dbAdapter->update('users', $this->getData(), $dbAdapter->quoteInto('id = ?', $this->getId()));
        } else {
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $dbAdapter->insert('users', $this->getData());
        }
    }

}
