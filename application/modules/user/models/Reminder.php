<?php

class User_Model_Reminder extends RedLightCloud_Entity_PasswordReset
{

    protected $_lifetime = 3600;

    public function create(User_Model_User $user)
    {
        $token = $this->_createToken();

        $this->setUserEmail($user->getEmail())->
                setToken($token)->
                setCreatedAt(time())->
                setLifetime($this->_lifetime)->
                setIsActive(1)->
                save();

        return $token;
    }

    protected function _createToken()
    {

        $token = Ikantam_Math_Rand::getString(64, Ikantam_Math_Rand::ALPHANUMERIC);
        return $token;
    }

    public function save()
    {
        if ($this->hasId()) {
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $dbAdapter->update('password_resets', $this->getData(), $dbAdapter->quoteInto('id = ?', $this->getId()));
        } else {
            $dbAdapter = Zend_Db_Table::getDefaultAdapter();
            $dbAdapter->insert('password_resets', $this->getData());
        }
    }

    public function isValid()
    {
        return ($this->getIsActive() && ($this->getCreatedAt() + $this->getLifetime() > time()));
    }

    public function retrieveByToken($token)
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $res = $dbAdapter->fetchRow('SELECT * FROM `password_resets` WHERE `token` = :token', array(':token' => $token), Zend_Db::FETCH_ASSOC);

        $this->addData($res);

        return $this;
    }

}