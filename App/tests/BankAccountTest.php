<?php
use PHPUnit\Framework\TestCase;
use App\Entity\BankAccount;
use BankAccount\BankAccountValidator;

class BankAccountTest extends TestCase
{
    public function test_validaccountsize() : void
    {
        $bankaccountvalidator = new BankAccountValidator();
        $this->assertEquals(true, $bankaccountvalidator->ValidAccountSize("ES6621000418401234567891"));

    }
    public function test_ibancalc() : void
    {
        $bankaccountvalidator = new BankAccountValidator();
        $bankaccount = new BankAccount();
        $bankaccount->organization = "2100";
        $bankaccount->office = "0418";
        $bankaccount->controlDigit = "40";
        $bankaccount->accountNumber = "1234567891";
        $bankaccount->swift = "12345678";
        $bankaccount->iban = "ES6621000418401234567891";
        $this->assertEquals($bankaccount->iban, $bankaccountvalidator->IBANCalc($bankaccount));

    }
    public function test_stringcorversion() : void
    {
        $bankaccountvalidator = new BankAccountValidator();
        $bankaccount = new BankAccount();
        $bankaccount->organization = "2100";
        $bankaccount->office = "0418";
        $bankaccount->controlDigit = "40";
        $bankaccount->accountNumber = "1234567891";
        $bankaccount->swift = "12345678";
        $bankaccount->iban = "ES6621000418401234567891";
        $this->assertEquals($bankaccount, $bankaccountvalidator->StringConversor("ES6621000418401234567891"));


    }
    public function test_validbankaccount() : void
    {
        $bankaccountvalidator = new BankAccountValidator();
        $bankaccount = new BankAccount();
        $bankaccount->organization = "2100";
        $bankaccount->office = "0418";
        $bankaccount->controlDigit = "40";
        $bankaccount->accountNumber = "1234567891";
        $bankaccount->swift = "12345678";
        $bankaccount->iban = "ES6621000418401234567891";
        $this->assertEquals(true, $bankaccountvalidator->ValidBankAccount($bankaccount));


    }
    public function test_isvalidaccount() : void
    {
        $bankaccountvalidator = new BankAccountValidator();
        $this->assertEquals(true, $bankaccountvalidator->IsValidAccount("ES6621000418401234567891"));

    }
    public function test_extractbankaccount() : void
    {
        $bankaccountvalidator = new BankAccountValidator();
        $bankaccount = new BankAccount();
        $bankaccount->organization = "2100";
        $bankaccount->office = "0418";
        $bankaccount->controlDigit = "40";
        $bankaccount->accountNumber = "1234567891";
        $bankaccount->swift = "12345678";
        $bankaccount->iban = "ES6621000418401234567891";
        $this->assertEquals($bankaccount, $bankaccountvalidator->ExtractBankAccount("ES6621000418401234567891"));
    }
}
