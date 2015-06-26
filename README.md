# Invoice Painter Bundle

This Symfony2 bundle has the simple purpose of helping your application generate PDF invoices.
It doesn't concern itself with logic relating to your pricing or payment system, this work is
still performed by your application.

# Installation and configuration

Composer.json

``` json
{
    ...
    "require": {
        "realtyhub/invoice-painter-bundle": "dev-master"
    }
}
```

AppKernel.php

``` php
<?php

public function registerBundles()
{
    $bundles = array(
        // ...
        new FOS\UserBundle\FOSUserBundle(),
    );
}
```


config.yml

``` yml
realtyhub_invoice_painter:
    currency_symbol: "dollar" #supported options 'dollar', 'pound', 'euro', 'yen'
    tax_short_name: "TAX" #Can be any string you like, such as "VAT" or "GST"
```



# Basic Usage

``` php
//Inside controller file
use Realtyhub\InvoicePainterBundle\Entity\InvoicePainterDataContainer;
use Realtyhub\InvoicePainterBundle\Entity\InvoicePainterItem;

class DefaultController extends Controller
{    
    public function invoiceTestAction()
    {
        $invoiceData = new InvoicePainterDataContainer();
    
        $invoiceData->setInvoiceDate( new \DateTime() );
        $invoiceData->setTaxNumber( '200 122 492' );
        $invoiceData->setInvoiceNumber( 'INV00034' );
    
    
        $invoiceData->addClientNameLine('Your clients name');
        $invoiceData->addClientNameLine('or clients business name');
    
        $invoiceData->addClientAddressLine('89 Green Road');
        $invoiceData->addClientAddressLine('Melbourne, VIC');
        $invoiceData->addClientAddressLine('Australia');
        $invoiceData->addClientAddressLine('3000');
    
        $invoiceData->addCompanyNameLine('Your Company Name');
        $invoiceData->addCompanyNameLine('Another line of your company name');
    
        $invoiceData->addCompanyAddressLine('920 Smith Street');
        $invoiceData->addCompanyAddressLine('Sydney, NSW');
        $invoiceData->addCompanyAddressLine('Australia');
        $invoiceData->addCompanyAddressLine('2000');
    
        $invoiceData->addInvoiceItem( InvoicePainterItem::createFromParams(1499, 0.2, 'Dell Laptop', new \DateTime() ) );
        $invoiceData->addInvoiceItem( InvoicePainterItem::createFromParams(119, 0.2, 'Canon Computer Printer', new \DateTime() ) );
        $invoiceData->addInvoiceItem( InvoicePainterItem::createFromParams(6, 0.2, 'A4 printer paper', new \DateTime() ) );
    
        return $this->forward('realtyhub_invoice_painter:paintAction', array('invoiceData' => $invoiceData));
    
    }

```

# TODOs

* Set some default values for config.yml.
* in config.yml, force the currency symbol to be a valid option.




