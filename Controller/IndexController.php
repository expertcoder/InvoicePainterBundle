<?php


namespace Realtyhub\InvoicePainterBundle\Controller;

use Realtyhub\InvoicePainterBundle\Entity\InvoicePainterDataContainer;
use Slik\DompdfBundle\Wrapper\DompdfWrapper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\EngineInterface;

class IndexController
{

    protected $templating;
    protected $dompdf;
    protected $defaultTaxShortName;

    public function __construct(EngineInterface $templating, DompdfWrapper $dompdf, $defaultTaxShortName)
    {
        $this->templating = $templating;
        $this->dompdf = $dompdf;
        $this->defaultTaxShortName = $defaultTaxShortName;
    }

    public function paintAction(InvoicePainterDataContainer $invoiceData)
    {

        if ($invoiceData->getTaxShortName() === null)
        {
            $invoiceData->setTaxShortName($this->defaultTaxShortName);
        }


        $html = $this->renderView(
            'RealtyhubInvoicePainterBundle::invoice.html.twig',
            array(  'invoiceData' => $invoiceData )
        );

        // Generate the pdf
        $this->dompdf->getpdf($html);

        $pdfContents = $this->dompdf->output();


        return new Response(
            $pdfContents,
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'.$this->generateDownloadFileName($invoiceData).'"'
            )
        );

    }

    /**
     * adapted from Symfony/Bundle/FrameworkBundle/Controller/Controller
     */
    public function renderView($view, array $parameters = array())
    {
        return $this->templating->render($view, $parameters);
    }

    protected function generateDownloadFileName(InvoicePainterDataContainer $invoiceData)
    {
        return 'invoice_'.$invoiceData->getInvoiceNumber().'_'.$invoiceData->getInvoiceDate()->format('Y-m-d').'.pdf';
    }
}