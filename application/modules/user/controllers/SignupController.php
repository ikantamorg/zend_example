<?php

class User_SignupController extends Ikantam_Controller_Front
{

    protected $_imageTypes = array('photo', 'bill', 'w9');

    public function init()
    {
        
    }

    public function indexAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirectSuccess('index', 'account', 'user');
        }

        $termsAndConditionsUrl = $this->_helper->url('index', 'terms-conditions', 'default');

        $form = new User_Form_Signup_SelectAccountType(array('url' => $termsAndConditionsUrl));

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->getRequest()->getPost())) {
                $this->_getSession()->addData($form->getValues());
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }


        $this->view->form = $form;
    }

    public function buyerAction()
    {
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirectSuccess('index', 'account', 'user');
        }

        $form = new User_Form_Signup_Buyer();

        if ($this->getRequest()->isPost()) {
            if ($form->isValid($this->getRequest()->getPost())) {
                if ($this->getHelper('signup')->buyer($form->getValues())) {
                    $this->_redirectSuccess('index', 'account', 'user');
                } else {
                    $form->addErrorMessage(User_Form_Signup_Buyer::ERROR_USER_EXISTS);
                }
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }

        $this->view->form = $form;
    }

    public function ownerAction()
    {
        $form = new User_Form_Signup_Owner();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->getRequest()->getPost())) {

                // $this->_getSession()->addData($form->getValues());
            } else {
                $form->populate($this->getRequest()->getPost());
            }
        }

        $this->view->form = $form;
    }

    public function stepFourAction()
    {
        
    }

    public function uploadAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();


        $type = $this->getRequest()->getParam('type');

        if (!in_array($type, $this->_imageTypes)) {
            $response['success'] = false;
            $response['error']   = 'Could not upload image';
            $this->getResponse()
                    ->setHeader('Content-type', 'text/plain')
                    ->setBody(json_encode($response));
        }

        $d = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('uploadDir') . DIRECTORY_SEPARATOR . 'tmp';


        $uploader = new Ikantam_File_Uploader();

        $uploader->setAdapter(new Ikantam_File_Transfer_Adapter_Http())
                ->setUploadPath($d);

        if (!$uploader->upload()) {
            $errors = $uploader->getErrorMessages();

            $response['success'] = false;
            $response['error']   = implode("\n", $errors);
            $this->getResponse()
                    ->setHeader('Content-type', 'text/plain')
                    ->setBody(json_encode($response));
        } else {
            $fileName = $uploader->getOriginalFileName();

            $this->_getSession()->setData($type, $uploader->getFileName());

            $response['success']      = true;
            $response['file']['name'] = basename($fileName);
        }

        $this->getResponse()
                ->setHeader('Content-type', 'text/plain')
                ->setBody(json_encode($response));
    }

    public function removeImageAction()
    {
        $type = $this->getRequest()->getPost('type');

        //@TODO: to be implemented
    }

}
