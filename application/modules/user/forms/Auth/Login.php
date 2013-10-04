<?php

class User_Form_Auth_Login extends Zend_Form
{

    const ERROR_EMAIL_EMPTY    = 'Enter your email address.';
    const ERROR_EMAIL_FORMAT   = 'Invalid email address.';
    const ERROR_PASSWORD_EMPTY = 'Enter your password.';
    const ERROR_USER_DOES_NOT_EXIST = 'The email address or the password that you entered does not match our records.';

    public function init()
    {
        $this->setMethod('post')
                ->setDecorators(array(array('ViewScript', array('viewScript' => 'auth/login/form.phtml'))
        ));

        $this->addElement($this->_getEmailElement())
                ->addElement($this->_getPasswordElement())
                ->addElement($this->_getSubmitElement());
                
    }

    protected function _getEmailElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_EMAIL_EMPTY);

        $emailAddress = new Zend_Validate_EmailAddress();
        $emailAddress->setMessage(self::ERROR_EMAIL_FORMAT);

        $email = new Ikantam_Form_Element_Email('email');

        $email->setRequired(true)
                ->addValidator($notEmpty, true)
                ->addValidator($emailAddress, true)
                ->setAttrib('placeholder', 'Email');
        
        $email->setDecorators(array(
            'ViewHelper',
            'Description',
            array('Errors', array('class' => 'required', 'elementStart' => '<div%s>', 'elementEnd' => '</div>', 'elementSeparator' => '')),
            array(array('control' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control')),
            array(array('controlGroup' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group')),
            'Label',
        ));

        return $email;
    }

    protected function _getPasswordElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_PASSWORD_EMPTY);

        $password = new Zend_Form_Element_Password('password');
        $password->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setAttrib('placeholder', 'Password');
        
        $password->setDecorators(array(
            'ViewHelper',
            'Description',
            array('Errors', array('class' => 'required', 'elementStart' => '<div%s>', 'elementEnd' => '</div>', 'elementSeparator' => '')),
            array(array('control' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control')),
            array(array('controlGroup' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group')),
            'Label',
        ));
        
        

        return $password;
    }

    protected function _getSubmitElement()
    {
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Login')
                ->setAttrib('class', 'red-btn')
                ->setDecorators(array('ViewHelper'));

        return $submit;
    }

    public function isValid($data)
    {
        $valid = parent::isValid($data);
 
        foreach ($this->getElements() as $element) {
            if ($element->hasErrors()) {
                $element->addDecorator(
                    array('controlGroup' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group error')
                );
            }
        }
 
        return $valid;
    }
    
    
}