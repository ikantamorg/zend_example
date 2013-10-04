<?php

class User_Model_Backend
{
    public function getByEmail($email, User_Model_User $user)
    {
        //@TODO: get user from database
        $sql = 'SELECT * FROM `users` WHERE `email` = :email';
        
    }
}