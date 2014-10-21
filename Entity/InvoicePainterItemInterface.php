<?php

namespace Realtyhub\InvoicePainterBundle\Entity;

interface InvoicePainterItemInterface
{
    public function getInvoicePainterAmountEx();

    public function getInvoicePainterTaxRate();

    public function getInvoicePainterDate();

    public function getInvoicePainterDescription();
}