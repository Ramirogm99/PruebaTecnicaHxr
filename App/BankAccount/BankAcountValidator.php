<?php

namespace BankAccount;

use App\Entity\BankAccount;
use App\BankAccountExtractorInterface;
use Exception;

class BankAccountValidator extends BankAccountExtractorInterface
{
    /**
     * @param string $account is the account to validate
     * @return boolean true if the account has the supposed size and false if not
     */
    public function ValidAccountSize(string $account): bool
    {

        if (strlen($account) >= 20 && strlen($account) < 42) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @param BankAccount $account recieves a BankAccount object
     * @return BankAccount $account returns a BankAccount object which has the iban now
     */
    public function IBANCalc(BankAccount $account): object
    {

        $account->iban = "ES" . $account->controlDigit . " " . $account->organization . " " . $account->office . " " . $account->controlDigit . " " . $account->accountNumber;
        return $account;
    }
    /**
     * @param string $string recieves the account in a String 
     * @return BankAccount $bankAccount returns an object BankAccount with the account
     */
    public function StringConversor($string): object
    {
        //ES CODIGO PAIS
        //00 CODIGO DE CONTROL
        //0000 OFICINA
        //0000000000 NUMERO DE CUENTA
        //ES66 2100 0418 4012 3456 7891
        //ES66 2100 0418 40 1234567891
        str_replace(" ", "", $string);
        str_replace(".", "", $string);
        $bankAccount = new BankAccount();
        if (substr($string, 0, 2) == "ES") {
            $bankAccount->organization = substr($string, 4, 4);
            $bankAccount->office = substr($string, 8 , 4);
            $bankAccount->controlDigit = substr($string, 2, 2);
            $bankAccount->accountNumber = substr($string, 14, 10);
            $bankAccount->swift = substr($string, 24, 8);
        }
        else{
            $bankAccount->organization = substr($string, 2, 4);
            $bankAccount->office = substr($string, 6 , 4);
            $bankAccount->controlDigit = substr($string, 0, 2);
            $bankAccount->accountNumber = substr($string, 12, 10);
            $bankAccount->swift = substr($string, 22, 8);
        }
        return $bankAccount;
    }
    /**
     * @param BankAccount $bankAccount = Is an object of the BankAccount class which is recieved as a parameter in the function which is validated
     * @return boolean false If the account is not correct or has an incorrect value and true if the account is correct
     */
    public function ValidBankAccount(BankAccount $bankAccount): bool
    {
        $bankAccount2 = $this->IBANCalc($bankAccount);
        if ($bankAccount->iban >= 20 && $bankAccount->iban < 42 && $bankAccount->iban == $bankAccount2->iban) {
            if (strlen($bankAccount->organization) == 4 && strlen($bankAccount->office) == 4 && strlen($bankAccount->controlDigit) == 2 && strlen($bankAccount->accountNumber) == 10) {
                foreach ($bankAccount as $item) {
                    if($item == "ES"){
                        continue;
                    }else{
                        if (ctype_digit($item)) {
                                return false;
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * @param string $account = Is a string which is recieved as a parameter in the function which is validated
     * @return boolean false If the account is not correct or has an incorrect value and true if the account is correct
     */
    public function isValidAccount(string $account): bool
    {
        if ($this->ValidAccountSize($account)) {
            $bankAccount = $this->StringConversor($account);
            if ($this->ValidBankAccount($bankAccount)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * @param string $account = Is a string which is recieved as a parameter in the function which is validated
     */
    public function extractBankAccount(string $account): BankAccount
    {
        try{
            if($this->isValidAccount($account)){
                $bankAccount = $this->StringConversor($account);
                return $bankAccount;
            }
            else{
                throw new Exception("The account is not valid");
            }
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

}
