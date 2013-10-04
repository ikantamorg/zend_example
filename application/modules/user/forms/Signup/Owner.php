<?php

class User_Form_Signup_Owner extends Zend_Form
{

    const ERROR_STUDIO_NAME_EMPTY  = 'Enter your studio name.';
    const ERROR_FIRST_NAME_EMPTY   = 'Enter your first name.';
    const ERROR_LAST_NAME_EMPTY    = 'Enter your last name.';
    const ERROR_EMAIL_EMPTY        = 'Enter your email address.';
    const ERROR_EMAIL_FORMAT       = 'Invalid email address.';
    const ERROR_SELECT_COUNTRY     = 'Select your country.';
    const ERROR_SELECT_STATE       = 'Select your state.';
    const ERROR_CITY_EMPTY         = 'Enter your city.';
    const ERROR_POSTAL_CODE_EMPTY  = 'Enter your ZIP code.';
    const ERROR_PHONE_NUMBER_EMPTY = 'Enter your phone number.';
    const ERROR_WEBSITE_EMPTY      = 'Enter your website.';
    const ERROR_PASSWORD_EMPTY     = 'Enter your password.';
    const ERROR_CONFIRMATION_EMPTY = 'Confirm you password.';
    const ERROR_CONFIRMATION_MATCH = 'Passwords should match.';

    public function init()
    {
        $this->setMethod('post')
                ->setDecorators(array(array('ViewScript', array('viewScript' => 'signup/owner/form.phtml'))
        ));

        $this->addElement($this->_getStudioNameElement())
                ->addElement($this->_getFirstNameElement())
                ->addElement($this->_getLastNameElement())
                ->addElement($this->_getEmailElement())
                ->addElement($this->_getCountryElement())
                ->addElement($this->_getStateElement())
                ->addElement($this->_getCityElement())
                ->addElement($this->_getPostalCodeElement())
                ->addElement($this->_getPhoneNumberElement())
                ->addElement($this->_getWebsiteElement())
                ->addElement($this->_getPasswordElement())
                ->addElement($this->_getConfirmPasswordElement())
                ->addElement($this->_getSubmitElement());
    }

    protected function _getStudioNameElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_STUDIO_NAME_EMPTY);

        $studioName = new Zend_Form_Element_Text('studio_name');

        $studioName->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('Studio Name')
                ->setDecorators($this->_getDefaultDecorators());

        return $studioName;
    }

    protected function _getFirstNameElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_FIRST_NAME_EMPTY);

        $firstName = new Zend_Form_Element_Text('first_name');

        $firstName->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('First Name')
                ->setDecorators($this->_getDefaultDecorators());

        return $firstName;
    }

    protected function _getLastNameElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_LAST_NAME_EMPTY);

        $lastName = new Zend_Form_Element_Text('last_name');

        $lastName->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('Last Name')
                ->setDecorators($this->_getDefaultDecorators());

        return $lastName;
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
                ->setLabel('Email')
                ->setDecorators($this->_getDefaultDecorators());

        return $email;
    }

    protected function _getCountryElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_SELECT_COUNTRY);

        $values = array(1 => 'United States', 2 => 'Canada');

        $inArray = new Zend_Validate_InArray(array_keys($values));
        $inArray->setMessage(self::ERROR_SELECT_COUNTRY);

        $country = new Zend_Form_Element_Select('country');

        $country->setRequired(true)
                ->addValidator($notEmpty, true)
                ->addValidator($inArray, true)
                ->addMultiOptions(array_merge(array(0 => '-- Select --'), $values))
                ->setAttrib('class', 'select_block')
                ->setLabel('Country')
                ->setDecorators($this->_getDefaultSelectDecorators());

        return $country;
    }

    protected function _getStateElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_SELECT_STATE);

        $values = array(1 => 'United States', 2 => 'Canada');

        $inArray = new Zend_Validate_InArray(array_keys($values));
        $inArray->setMessage(self::ERROR_SELECT_STATE);

        $state = new Zend_Form_Element_Select('state');

        $state->setRequired(true)
                ->addValidator($notEmpty, true)
                ->addValidator($inArray, true)
                ->addMultiOptions(array_merge(array(0 => '-- Select --'), $values))
                ->setAttrib('class', 'select_block')
                ->setLabel('State')
                ->setDecorators($this->_getDefaultSelectDecorators());

        return $state;
    }

    protected function _getCityElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_CITY_EMPTY);

        $city = new Zend_Form_Element_Text('city');

        $city->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('City')
                ->setDecorators($this->_getDefaultDecorators());

        return $city;
    }

    protected function _getPostalCodeElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_POSTAL_CODE_EMPTY);

        $postalCode = new Zend_Form_Element_Text('postal_code');

        $postalCode->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('ZIP Code')
                ->setDecorators($this->_getDefaultDecorators());

        return $postalCode;
    }

    protected function _getPhoneNumberElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_PHONE_NUMBER_EMPTY);

        $phoneNumber = new Zend_Form_Element_Text('phone_number');

        $phoneNumber->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('Phone Number')
                ->setDecorators($this->_getDefaultDecorators());

        return $phoneNumber;
    }

    protected function _getWebsiteElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_WEBSITE_EMPTY);

        $website = new Zend_Form_Element_Text('website');

        $website->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('Website')
                ->setDecorators($this->_getDefaultDecorators());

        return $website;
    }

    protected function _getPasswordElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_PASSWORD_EMPTY);

        $password = new Zend_Form_Element_Password('password');
        $password->setRequired(true)
                ->addValidator($notEmpty, true)
                ->setLabel('Password')
                ->setDecorators($this->_getDefaultDecorators());

        return $password;
    }

    protected function _getConfirmPasswordElement()
    {
        $notEmpty = new Zend_Validate_NotEmpty();
        $notEmpty->setMessage(self::ERROR_CONFIRMATION_EMPTY);

        $match = new Zend_Validate_Identical('password');
        $match->setMessage(self::ERROR_CONFIRMATION_MATCH);

        $confirmation = new Zend_Form_Element_Password('confirmation');

        $confirmation->setRequired(true)
                ->addValidator($notEmpty, true)
                ->addValidator($match, true)
                ->setLabel('Confirm Password')
                ->setDecorators($this->_getDefaultDecorators());

        return $confirmation;
    }

    protected function _getSubmitElement()
    {
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Continue')
                ->setAttrib('class', 'red-btn special')
                ->setDecorators(array('ViewHelper'));

        $submit->setDecorators(array(
            $this->_getViewHelperDecorator(),
            $this->_getDescriptionDecorator(),
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
                $element->addDecorator(array('controlGroup' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control-group error'));
            }
        }

        return $valid;
    }

    protected function _getDefaultDecorators()
    {
        return array(
            $this->_getViewHelperDecorator(),
            $this->_getDescriptionDecorator(),
            $this->_getErrorsDecorator(),
            $this->_getControlDecorator(),
            $this->_getControlGroupDecorator(),
            $this->_getLabelDecorator()
        );
    }

    protected function _getDefaultSelectDecorators()
    {
        return array(
            $this->_getViewHelperDecorator(),
            $this->_getDescriptionDecorator(),
            $this->_getErrorsDecorator(),
            array(array('control' => 'HtmlTag'), array('tag'   => 'div', 'class' => 'control select_customer long')),
            $this->_getControlGroupDecorator(),
            $this->_getLabelDecorator(),
        );
    }

    protected function _getViewHelperDecorator()
    {
        return 'ViewHelper';
    }

    protected function _getDescriptionDecorator()
    {
        return 'Description';
    }

    protected function _getLabelDecorator()
    {
        return 'Label';
    }

    protected function _getErrorsDecorator()
    {
        $options = array(
            'class'            => 'required',
            'elementStart'     => '<div%s>',
            'elementEnd'       => '</div>',
            'elementSeparator' => ''
        );

        return array('Errors', $options);
    }

    protected function _getControlDecorator()
    {
        return array(
            array(
                'control' => 'HtmlTag'),
            array(
                'tag'   => 'div',
                'class' => 'control')
        );
    }

    protected function _getControlGroupDecorator()
    {
        return array(
            array(
                'controlGroup' => 'HtmlTag'),
            array(
                'tag'   => 'div',
                'class' => 'control-group')
        );
    }

}