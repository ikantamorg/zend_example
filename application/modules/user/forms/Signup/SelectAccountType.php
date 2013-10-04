<?php

class User_Form_Signup_SelectAccountType extends Zend_Form
{

    const ERROR_SELECT_USER_GROUP = 'Select your user group.';
    const ERROR_ACCEPT_TERMS      = 'Accept terms and conditions.';

    public function init()
    {
        $this->setMethod('post')
                ->setDecorators(array(array('ViewScript', array('viewScript' => 'signup/index/form.phtml'))
        ));

        $this->addElement($this->_getUserGroupElement())
                ->addElement($this->_getTermsConditionsElement())
                ->addElement($this->_getSubmitElement());
    }

    protected function _getUserGroupElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_SELECT_USER_GROUP);

        $values = array(1 => 'Buyer', 2 => 'Owner');

        $inArray = new Zend_Validate_InArray(array_keys($values));
        $inArray->setMessage(self::ERROR_SELECT_USER_GROUP);

        $email = new Zend_Form_Element_Select('user_group');

        $email->setRequired(true)
                ->addValidator($notEmpty, true)
                ->addValidator($inArray, true)
                ->addMultiOptions(array_merge(array(0 => '-- Select --'), $values))
                ->setAttrib('class', 'select_block');

        $email->setDecorators(array(
            'ViewHelper',
            'Description',
            array('Errors', array('class'            => 'required', 'elementStart'     => '<div%s>', 'elementEnd'       => '</div>', 'elementSeparator' => '')),
            array(array('control' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control select_customer long')),
            array(array('controlGroup' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control-group')),
            'Label',
        ));

        return $email;
    }

    protected function _getTermsConditionsElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_ACCEPT_TERMS);

        $inArray = new Zend_Validate_InArray(array(1));
        $inArray->setMessage(self::ERROR_ACCEPT_TERMS);

        $password = new Zend_Form_Element_Checkbox('terms_conditions');
        $password->setRequired(true)
                ->setDescription(sprintf('I accept <a class="red" href="%s">Terms & Conditions</a>', $this->getAttrib('url')))
                ->addValidator($notEmpty, true)
                ->addValidator($inArray, true);

        $password->setDecorators(array(
            'ViewHelper',
            array('Description', array('tag'    => 'label', 'escape' => false)),
            array('Errors', array('class'            => 'required', 'elementStart'     => '<div%s>', 'elementEnd'       => '</div>', 'elementSeparator' => '')),
            array(array('control' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control ch-line')),
            array(array('controlGroup' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control-group')),
            'Label',
        ));



        return $password;
    }

    protected function _getSubmitElement()
    {
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Continue')
                ->setAttrib('class', 'red-btn special')
                ->setDecorators(array('ViewHelper'));

        $submit->setDecorators(array(
            'ViewHelper',
            'Description',
            'Errors',
            array(array('control' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control pull-right')),
            array(array('controlGroup' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control-group clearfix')),
        ));

        return $submit;
    }

    public function isValid($data)
    {
        $valid = parent::isValid($data);

        foreach ($this->getElements() as $element) {
            if ($element->hasErrors()) {
                $element->addDecorator(
                        array('controlGroup' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control-group error')
                );
            }
        }

        return $valid;
    }

}