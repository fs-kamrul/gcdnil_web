<?php

namespace Modules\KamrulDashboard\Packages\fpdf;

class KDPDF extends FPDF {
    protected static $headerText = '';

    // Static method to set header text
    public static function setHeaderText($text) {
        self::$headerText = $text;
    }

    // Static method to get header text
    public static function getHeaderText() {
        return self::$headerText;
    }

    function Header() {
        $this->SetFont('Arial', 'B', 12);  // Using the double colon to call static method
        $this->Cell(0, 10, $this->getHeaderText(), 0, 1, 'C');  // Using the double colon and static method
    }
    function TextArea($x, $y, $width, $height, $border, $text) {
        if($x != -1) {
            $this->SetXY($x, $y);
        }
        $this->MultiCell($width, $height, $text, $border, 'L');
    }
    function Footer() {
//        $this->SetY(-15);
//        $this->Cell(0, 5, 'certificate_number' , 1, 1,'C');
        // This function remains empty to disable the footer
    }
}
