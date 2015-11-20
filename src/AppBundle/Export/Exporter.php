<?php
namespace AppBundle\Export;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Exporter\Handler;
use Exporter\Source\SourceIteratorInterface;
use Exporter\Writer\CsvWriter;
use Exporter\Writer\JsonWriter;
use Exporter\Writer\XlsWriter;
use Exporter\Writer\XmlWriter;
use fpdf\FPDF;
use RuntimeException;
use Sonata\AdminBundle\Export\Exporter as Base_Exporter;
use Symfony\Component\HttpFoundation\StreamedResponse;


class Exporter extends Base_Exporter{
    
    private $originType = array("xls","xml","json","csv");
            
    public function getResponse($format, $filename, SourceIteratorInterface $source)
    {
        switch ($format) {
            case 'xls':
                $writer      = new XlsWriter('php://output');
                $contentType = 'application/vnd.ms-excel';
                break;
            case 'xml':
                $writer      = new XmlWriter('php://output');
                $contentType = 'text/xml';
                break;
            case 'json':
                $writer      = new JsonWriter('php://output');
                $contentType = 'application/json';
                break;
            case 'csv':
                $writer      = new CsvWriter('php://output', ',', '"', '', true, true);
                $contentType = 'text/csv';
                break;
            case 'pdf':
                $pdf = new FPDF();
                $pdf->AddPage(); 
                $pdf->SetFont('Arial','B',16); 
                foreach($source as $row)
                {
                    foreach($row as $key=>$col){
                        $pdf->Cell(40,6,$key,1);
                    }
                    $pdf->Ln();
                    foreach($row as $key=>$col){
                        $pdf->Cell(40,6,$col,1);
                    }
                    $pdf->Ln();
                } 
                $pdf->Output($filename, 'D');
                break;
            default:
                throw new RuntimeException('Invalid format');
        }
        if(!in_array($format, $this->originType)){
            return new \Symfony\Component\HttpFoundation\Response();
        }else{
            $callback = function () use ($source, $writer) {
            $handler = Handler::create($source, $writer);
            $handler->export();
            };

            return new StreamedResponse($callback, 200, array(
                'Content-Type'        => $contentType,
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            ));
        }
        
        
    }
    
}