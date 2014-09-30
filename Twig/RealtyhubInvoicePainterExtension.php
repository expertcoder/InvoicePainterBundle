<?php

namespace Realtyhub\InvoicePainterBundle\Twig;

class RealtyhubInvoicePainterExtension extends \Twig_Extension
{

    protected $currencyHtmlEntity;

    public function __construct($currencySymbol)
    {
        $lookup['dollar'] = '&#36;';
        $lookup['pound'] = '&pound;';
        $lookup['euro'] = '&euro;';
        $lookup['yen'] = '&yen;';

        if (array_key_exists(strtolower($currencySymbol), $lookup) )
        {
            $this->currencyHtmlEntity = $lookup[ $currencySymbol ];
        }
        else
        {
            throw new \Exception('Currency symbol not supported, possible options are '.join(',', array_keys($lookup) ) );
        }

    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('money', [$this, 'moneyFilter'], ['is_safe' => ['html'] ]),
            new \Twig_SimpleFilter('percentage', array($this, 'percentageFilter')),
        );
    }

    public function percentageFilter($amount, $decimals = 0)
    {
        $str = round($amount * 100, $decimals);
        return $str.'%';
    }

    public function moneyFilter($amount, $decimals = 2)
    {


        if ($amount < 0)
        {
            $negative = true;
            $str = $amount *  -1;
        }
        else
        {
            $negative = false;
            $str = $amount;
        }

        $str = number_format($str, $decimals, '.', ','); //Note: deliberately not using money_format() as it is lame
        $str = $this->currencyHtmlEntity.$str; //add currency symbol. Note: use of "is_safe" option for this filter to prevent the already escaped html been escaped again

        if ($negative)
        {
            $str= "({$str})";   //negative numbers shown with brackets around them (Accounting standard)
        }

        return $str;
    }

    public function getName()
    {
        return 'realtyhub_invoice_painter_extension';
    }
}