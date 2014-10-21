<?php

namespace Realtyhub\InvoicePainterBundle\Entity;

class InvoicePainterItem
{

    protected $date = null;

    protected $description = null;

    protected $taxRate = null;

    protected $amountEx = null;

    protected $amountInc = null;


    static public function createFromParams($amountEx, $taxRate, $description, \DateTime $date)
    {
        $obj = new self;

        $obj->setAmountEx($amountEx);
        $obj->setTaxRate($taxRate);
        $obj->setDescription($description);
        $obj->setDate($date);

        return $obj;
    }

    static public function createFromInterface(InvoicePainterItemInterface $invoicePainterItemInterface)
    {
        $obj = new self;

        $obj->setAmountEx($invoicePainterItemInterface->getInvoicePainterAmountEx());
        $obj->setTaxRate($invoicePainterItemInterface->getInvoicePainterTaxRate());
        $obj->setDescription($invoicePainterItemInterface->getInvoicePainterDescription());
        $obj->setDate($invoicePainterItemInterface->getInvoicePainterDate());

        return $obj;
    }


    /**
     * @param mixed $amountEx
     */
    public function setAmountEx($amountEx)
    {
        $this->amountEx = $amountEx;
    }

    /**
     * @return mixed
     */
    public function getAmountEx()
    {
        if ($this->amountEx === null)
        {   //amountEx has not been set, but lest see if we can calculate it
            if ($this->amountInc === null || $this->taxRate === null)
            {
                throw new \Exception('Attempting to get amountEx, but it is null, and there is not enough information to calculate it');
            }

            $this->amountEx = $this->amountInc / (1 + $this->taxRate);
        }

        return $this->amountEx;
    }

    /**
     * @param mixed $amountInc
     */
    public function setAmountInc($amountInc)
    {
        $this->amountInc = $amountInc;
    }

    /**
     * @return mixed
     */
    public function getAmountInc()
    {
        if ($this->amountInc === null)
        {   //amountInc has not been set, but lest see if we can calculate it
            if ($this->amountEx === null || $this->taxRate === null)
            {
                throw new \Exception('Attempting to get amountInc, but it is null, and there is not enough information to calculate it');
            }

            $this->amountInc = $this->amountEx * (1 + $this->taxRate);
        }

        return $this->amountInc;
    }

    /**
     * @param mixed $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $taxRate
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }




}