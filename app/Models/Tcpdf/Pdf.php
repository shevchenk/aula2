<?php
namespace App\Models\Tcpdf;
use TCPDF;

class Pdf extends TCPDF
{
    private $fondo=false;
    private $qr=false;
    private $validacion=false;
    private $imageFile;
    private $qrData;

    public function ActivarFondo($imageFile){
        $this->fondo = true;
        $this->imageFile = $imageFile;
    }

    public function ActivarValidacion(){
        $this->validacion = true;
    }

    public function ActivarQR($data){
        $this->qr = true;
        $this->qrData = array(
            'url' => $data['url'],
            'posx' => $data['posx'],
            'posy' => $data['posy'],
            'w' => $data['w'],
            'h' => $data['h'],
            'color' => $data['color']
        );
    }

    public function Header() {
        if( $this->fondo ){
            $bMargin = $this->getBreakMargin();
            $auto_page_break = $this->AutoPageBreak;
            $this->SetAutoPageBreak(false, 0);
            $this->Image($this->imageFile, 0, 0, 298, 210, '', '', '', false, 300, '', false, false, 0);
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
        }

        if( $this->validacion ){
            $bMargin = $this->getBreakMargin();
            $auto_page_break = $this->AutoPageBreak;
            $this->SetAutoPageBreak(false, 0);
            $this->Image('certificado/validacion.png', 0, 85, 280, 80, '', '', '', false, 300, '', false, false, 0);
            $this->SetAutoPageBreak($auto_page_break, $bMargin);
            $this->setPageMark();
        }

        if( $this->qr ){
            $style = array(
                'border' => false,
                'padding' => 0,
                'fgcolor' => $this->qrData['color'],
                'bgcolor' => false
            );
            $this->write2DBarcode(
                $this->qrData['url'], 
                'QRCODE', 
                $this->qrData['posx'], 
                $this->qrData['posy'], 
                $this->qrData['w'], 
                $this->qrData['h'], 
                $style,''
            );
            $this->SetFont('times', 'BI', 11);
            $wt= $this->qrData['posx'] + floor(($this->qrData['w']-18)/2);
            $ht= $this->qrData['posy'] + $this->qrData['h'] - 2;
            $this->Text($wt, $ht, 'QRCODE');
        }
    }
}
