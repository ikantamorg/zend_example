<?php

class User_Form_Account_Recovery extends Zend_Form
{

    const ERROR_EMAIL_EMPTY    = 'Enter your email address.';
    const ERROR_EMAIL_FORMAT   = 'Invalid email address.';

    public function init()
    {
        $this->setMethod('post')
                ->setDecorators(array(array('ViewScript', array('viewScript' => 'account/recovery/form.phtml'))
        ));

        $this->addElement($this->_getEmailElement())
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