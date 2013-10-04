<?php

class Ikantam_Controller_Action_Helper_Signup extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * direct(): Perform helper when called as
     * $this->_helper->signup($credentials)
     *
     * @param  array  $credentials
     * @return void
     */
    public function direct(array $credentials)
    {
        return $this->buyer($credentials);
    }

    public function buyer(array $credentials)
    {
        $buyer = new User_Model_User();

        try {
            $buyer->setUserGroupId(User_Model_UserGroup::USER_GROUP_BUYER)
                    ->setFirstName($credentials['first_name'])
                    ->setLastName($credentials['last_name'])
                    ->setEmail($credentials['email'])
                    ->setPassword($this->_hash($credentials['password']))
                    ->setStatus(User_Model_User::STATUS_APPROVED)
                    ->save();
        } catch (Exception $exc) {
            //@TODO: log exception
            return false;
        }
        return true;
    }

    public function owner(array $credentials)
    {
        
    }

    protected function _hash($password)
    {
        $bcrypt = new Ikantam_Crypt_Password_Bcrypt();
        return $bcrypt->create($password);
    }

}