<?php

class Ikantam_Controller_Action_Helper_Security extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * direct(): Perform helper when called as
     * $this->_helper->auth($credentials)
     *
     * @param  array  $credentials
     * @return void
     */
    public function direct($fileName)
    {
        return $this->getUrl($fileName);
    }

    public function getUrl($fileName)
    {
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        
        $secret        = $config->getOption('downloadSecret');
        $protectedPath = $config->getOption('downloadPath');
        $ipLimitation  = $config->getOption('downloadipLimitation');
        $hexTime       = dechex(time());

        if ($ipLimitation) {
            $token = md5($secret . $fileName . $hexTime . $this->getRequest()->getClientIp());
        } else {
            $token = md5($secret . $fileName . $hexTime);
        }

        return $protectedPath . $token . '/' . $hexTime . $fileName;
    }

}