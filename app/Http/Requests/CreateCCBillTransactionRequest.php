<?php

namespace App\Http\Requests;

class CreateCCBillTransactionRequest
{
    /**
     * @var integer
     */
    private $clientAccnum;

    /**
     * @var integer
     */
    private $clientSubacc;

    /**
     * @var float
     */
    private $initialPrice;

    /**
     * @var integer
     */
    private $initialPeriod;

    /**
     * @var float
     */
    private $recurringPrice;

    /**
     * @var integer
     */
    private $recurringPeriod;

    /**
     * @var integer
     */
    private $rebills;

    /**
     * @var integer
     */
    private $currencyCode;

    /**
     * @var boolean
     */
    private $lifeTimeSubscription;

    /**
     * @var boolean
     */
    private $createNewPaymentToken;

    /**
     * @var array
     */
    private $passThroughInfo;

    /**
     * Converts this object instance in json
     * @return false|string
     */
    public function toJson(){
        return json_encode(get_object_vars($this), true);
    }

    /**
     * CreateCCBillTransactionRequest constructor.
     */
    public function __construct()
    {
        $this->passThroughInfo = [];
    }

    /**
     * @return int
     */
    public function getClientAccnum()
    {
        return $this->clientAccnum;
    }

    /**
     * @param int $clientAccnum
     */
    public function setClientAccnum($clientAccnum)
    {
        $this->clientAccnum = $clientAccnum;
    }

    /**
     * @return int
     */
    public function getClientSubacc()
    {
        return $this->clientSubacc;
    }

    /**
     * @param int $clientSubacc
     */
    public function setClientSubacc($clientSubacc)
    {
        $this->clientSubacc = $clientSubacc;
    }

    /**
     * @return float
     */
    public function getInitialPrice()
    {
        return $this->initialPrice;
    }

    /**
     * @param float $initialPrice
     */
    public function setInitialPrice($initialPrice)
    {
        $this->initialPrice = $initialPrice;
    }

    /**
     * @return int
     */
    public function getInitialPeriod()
    {
        return $this->initialPeriod;
    }

    /**
     * @param int $initialPeriod
     */
    public function setInitialPeriod($initialPeriod)
    {
        $this->initialPeriod = $initialPeriod;
    }

    /**
     * @return float
     */
    public function getRecurringPrice()
    {
        return $this->recurringPrice;
    }

    /**
     * @param float $recurringPrice
     */
    public function setRecurringPrice($recurringPrice)
    {
        $this->recurringPrice = $recurringPrice;
    }

    /**
     * @return int
     */
    public function getRecurringPeriod()
    {
        return $this->recurringPeriod;
    }

    /**
     * @param int $recurringPeriod
     */
    public function setRecurringPeriod($recurringPeriod)
    {
        $this->recurringPeriod = $recurringPeriod;
    }

    /**
     * @return int
     */
    public function getRebills()
    {
        return $this->rebills;
    }

    /**
     * @param int $rebills
     */
    public function setRebills($rebills)
    {
        $this->rebills = $rebills;
    }

    /**
     * @return int
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param int $currencyCode
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
    }

    /**
     * @return bool
     */
    public function isLifeTimeSubscription()
    {
        return $this->lifeTimeSubscription;
    }

    /**
     * @param bool $lifeTimeSubscription
     */
    public function setLifeTimeSubscription($lifeTimeSubscription)
    {
        $this->lifeTimeSubscription = $lifeTimeSubscription;
    }

    /**
     * @return bool
     */
    public function isCreateNewPaymentToken()
    {
        return $this->createNewPaymentToken;
    }

    /**
     * @param bool $createNewPaymentToken
     */
    public function setCreateNewPaymentToken($createNewPaymentToken)
    {
        $this->createNewPaymentToken = $createNewPaymentToken;
    }
}
