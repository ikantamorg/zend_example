<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    protected function _initHelpers()
    {
        Zend_Controller_Action_HelperBroker::addPrefix('Ikantam_Controller_Action_Helper');
    }

}
