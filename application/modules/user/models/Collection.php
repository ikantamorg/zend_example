<?php

class User_Model_Collection
{

    public function retrieveByCredentials(array $credentials)
    {
        $dbAdapter = Zend_Db_Table::getDefaultAdapter();

        $res = $dbAdapter->fetchRow('SELECT * FROM `users` WHERE `email` = :email', array(':email' => $credentials['email']), Zend_Db::FETCH_ASSOC);

        $user = new \User_Model_User();
        $user->addData($res);

        return $user;
    }

}