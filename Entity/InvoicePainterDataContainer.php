<?php

namespace Realtyhub\InvoicePainterBundle\Entity;

class InvoicePainterDataContainer
{

    protected $clientNameLines;

    protected $clientAddressLines;

    protected $invoiceDate;

    protected $invoiceNumber;

    protected $taxShortName;

    protected $taxNumber;

    protected $companyNameLines;

    protected $companyAddressLines;

    protected $invoiceItems;

    public function __construct()
    {
        $this->clientNameLines = array();
        $this->clientAddressLines = array();
        $this->companyNameLines = array();
        $this->companyAddressLines = array();
        $this->invoiceItems = array();
    }

    /**
     * @param array $clientAddressLines
     */
    public function addClientAddressLine($clientAddressLine)
    {
        $this->clientAddressLines[] = $clientAddressLine;
    }

    /**
     * @return array
     */
    public function getClientAddressLines()
    {
        return $this->clientAddressLines;
    }

    /**
     * @param array $clientNameLines
     */
    public function addClientNameLine($clientNameLine)
    {
        $this->clientNameLines[] = $clientNameLine;
    }

    /**
     * @return array
     */
    public function getClientNameLines()
    {
        return $this->clientNameLines;
    }

    /**
     * @param array $companyAddressLines
     */
    public function addCompanyAddressLine($companyAddressLine)
    {
        $this->companyAddressLines[] = $companyAddressLine;
    }

    /**
     * @return array
     */
    public function getCompanyAddressLines()
    {
        return $this->companyAddressLines;
    }

    /**
     * @param array $companyNameLines
     */
    public function addCompanyNameLine($companyNameLine)
    {
        $this->companyNameLines[] = $companyNameLine;
    }

    /**
     * @return array
     */
    public function getCompanyNameLines()
    {
        return $this->companyNameLines;
    }

    /**
     * @param mixed $invoiceDate
     */
    public function setInvoiceDate(\DateTime $invoiceDate)
    {
        $this->invoiceDate = $invoiceDate;
    }

    /**
     * @return mixed
     */
    public function getInvoiceDate()
    {
        return $this->invoiceDate;
    }

    /**
     * @param array $invoiceItems
     */
    public function addInvoiceItem(InvoicePainterItem $invoiceItem)
    {
        $this->invoiceItems[] = $invoiceItem;
    }

    /**
     * @return array
     */
    public function getInvoiceItems()
    {
        return $this->invoiceItems;
    }

    /**
     * @param mixed $invoiceNumber
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
    }

    /**
     * @return mixed
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * @param mixed $taxNumber
     */
    public function setTaxNumber($taxNumber)
    {
        $this->taxNumber = $taxNumber;
    }

    /**
     * @return mixed
     */
    public function getTaxNumber()
    {
        return $this->taxNumber;
    }

    /**
     * @param mixed $taxShortName
     */
    public function setTaxShortName($taxShortName)
    {
        $this->taxShortName = $taxShortName;
    }

    /**
     * @return mixed
     */
    public function getTaxShortName()
    {
        return $this->taxShortName;
    }


    public function getTotalAmountEx()
    {
        $total = 0;

        foreach ($this->invoiceItems as $item)
        {
            $total += $item->getAmountEx();
        }

        return $total;
    }

    public function getTotalAmountInc()
    {
        $total = 0;

        foreach ($this->invoiceItems as $item)
        {
            $total += $item->getAmountInc();
        }

        return $total;
    }

    public function getTotalTax()
    {
        return $this->getTotalAmountInc() - $this->getTotalAmountEx();
    }

}