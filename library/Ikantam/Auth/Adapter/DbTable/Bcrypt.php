<?php

class Ikantam_Auth_Adapter_DbTable_Bcrypt extends Zend_Auth_Adapter_DbTable
{

    protected function _authenticateCreateSelect()
    {
        $dbSelect = clone $this->getDbSelect();
        $dbSelect->from($this->_tableName, array('*'))
                ->where($this->_zendDb->quoteIdentifier($this->_identityColumn, true) . ' = ?', $this->_identity);

        return $dbSelect;
    }

    protected function _authenticateValidateResult($resultIdentity)
    {
        $bcrypt = new Ikantam_Crypt_Password_Bcrypt();

        // Compare db hash against user generated hash
        if (!$bcrypt->verify($this->_credential, $resultIdentity[$this->_credentialColumn])) {
            $this->_authenticateResultInfo['code']       = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
        } else {
            $this->_resultRow                            = $resultIdentity;
            $this->_authenticateResultInfo['code']       = Zend_Auth_Result::SUCCESS;
            $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
        }

        return $this->_authenticateCreateAuthResult();
    }

}