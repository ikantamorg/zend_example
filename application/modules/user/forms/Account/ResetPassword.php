<?php

class User_Form_Account_ResetPassword extends Zend_Form
{

    const ERROR_PASSWORD_EMPTY    = 'Enter your new password.';
    const ERROR_CONFIRMATION_EMPTY    = 'Confirm you new password.';
    const ERROR_CONFIRMATION_MATCH   = 'Passwords should match.';

    public function init()
    {
        $this->setMethod('post')
                ->setDecorators(array(array('ViewScript', array('viewScript' => 'account/reset-password/form.phtml'))
        ));

        $this->addElement($this->_getPasswordElement())
              ->addElement($this->_getConfirmPasswordElement())  
                ->addElement($this->_getSubmitElement());
                
    }

    protected function _getPasswordElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_PASSWORD_EMPTY);

        $email = new Zend_Form_Element_Password('password');

        $email->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setAttrib('placeholder', 'Password');
        
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
    
    protected function _getConfirmPasswordElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_CONFIRMATION_EMPTY);
        
        $match = new Zend_Validate_Identical('password');
        $match->setMessage(self::ERROR_CONFIRMATION_MATCH);

        $email = new Zend_Form_Element_Password('confirmation');

        $email->setRequired(true)
                ->addValidator($notEmpty, true)
                ->addValidator($match, true)
                ->setAttrib('placeholder', 'Confirm Password');
        
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

    protected function _getSubmitElement()
    {
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Submit')
                ->setAttrib('class', 'red-btn');

        $submit->setDecorators(array(
            'ViewHelper',
            'Description',
            'Errors',
            array(array('control' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control pull-right')),
            array(array('controlGroup' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group clearfix')),
        ));
   
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