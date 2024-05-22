<?php

include 'classes/fpdf.php';
include 'classes/ean13.php';
include 'classes/rpdf.php';
include 'classes/cellfit.php';
include 'classes/wordwrap.php';

// border debugging 1=on, 0=off, 'custom'=preset values
$borders = 0;

// Umlaute
$utf = 'UTF-8';
$win = 'windows-1252';

// date time lang
$today = date('d.M.Y');

// Font
$font = 'Helvetica';
$headerFontSize = 20;
$absfontsize = 7;
$vermfontsize = 10;
$anschriftFontSize = 10;
$infofontsize = 8;



$gruss = 'Mit freundlichen Gruessen';

/// Adressdaten GET
// Absender
$aName = $_GET['aname'] ?? '';
$aStrasse = $_GET['astr'] ?? '';
$aHausNr = $_GET['ahsnr'] ?? '';
$aPLZ = $_GET['aplz'] ?? '';
$aOrt = $_GET['aort'] ?? '';

// header = bk
$header = $aName;

// Vermerk
$vermerk = ' '; // 
// Empfänger
$eName = $_GET['ename'] ?? '';
$eStrasse = $_GET['estr'] ?? '';
$eHausNr = $_GET['ehsnr'] ?? '';
$ePLZ = $_GET['eplz'] ?? '';
$eOrt = $_GET['eort'] ?? '';

/// InfoBox
// Zeichen
$infoIhrZeichen = $_GET['usign'] ?? '';
$infoIhreNachrichtVom = $_GET['udate'] ?? '';
$infoUnserZeichen = $_GET['isign'] ?? '';
$infoUnsereNachrichtVom = $_GET['idate'] ?? '';
// InfoAbsender
$infoName = $_GET['iname'] ?? $aName;
$infoTelefon = $_GET['iphone'] ?? '';
$infoTelefax = $_GET['ifax'] ?? '';
$infoEmail = $_GET['imail'] ?? '';
//$testthis = $_GET['today'];
$fliesstext = $_GET['text'] ?? '';
$infoDatum = (strlen($_GET['today']) > 0 ? date('d.m.Y', strtotime($_GET['today'])) : date('d.m.Y', strtotime($today)));

if (strlen($aName) > 0) {
    $test = $aName;
} else {
    '';
}
// Inhalt
$absender =
    (strlen($aName) > 0 ? $aName : '') .
    (strlen($aName) > 0 && strlen($aStrasse) > 0 ? ', ' : '') .
    (strlen($aStrasse) > 0 ? $aStrasse : '') .
    (strlen($aStrasse) > 0 && strlen($aHausNr) > 0 ? ' ' : '') .
    (strlen($aHausNr) > 0 ? $aHausNr : '') .
    (strlen($aHausNr) > 0 && strlen($aPLZ) > 0 ? ', ' : '') .
    (strlen($aPLZ) > 0 ? $aPLZ : '') .
    (strlen($aPLZ) > 0 && strlen($aOrt) > 0 ? ' ' : '') .
    (strlen($aOrt) > 0 ? $aOrt : '');


$header = iconv($utf, $win, $header);
$absender = iconv($utf, $win, $absender);
$vermerk = iconv($utf, $win, $vermerk);


/* $infoBoxZeichen = $infoIhrZeichen . "\n" . $infoIhreNachrichtVom . "\n" . $infoUnserZeichen . "\n" . $infoUnsereNachrichtVom; */

$infoBoxName = $infoName . "\n" . $infoTelefon . "\n" . $infoTelefax . "\n" . $infoEmail . "\n" . $infoDatum;


$textfontsize = 11;
$text = 'Sehr geehrte Damen und Herren,'."\n\n" . $fliesstext;

$footerFontSize = 8;
$footerContent = (strlen($absender) > 0 ? $absender : '') . (strlen($absender) > 0 && strlen($infoTelefon) > 0 ? ', ' : '') . (strlen($infoTelefon) > 0 ? $infoTelefon : '') . (strlen($infoTelefon) > 0 && strlen($infoEmail) > 0 ? ', ' : '') . (strlen($infoEmail) > 0 ? $infoEmail : '');

class MyPDF extends Wordwrap
{
    public function AbsText($x, $y, $text)
    {
        $this->SetXY($x, $y);
        $this->Cell(0, 0, $text);
    }
}

const FPDF_FONTPATH = 'font';

$pdf = new MyPDF();
// Seitenränder links, oben, rechts
$pdf->SetMargins(0, 0, 0);

// Seite hinzufügen // P = Portrait  /  L = Landscape
$pdf->AddPage('P');
$pdf->SetTitle('Din 5008');
$pdf->SetFont($font);
$pdf->SetTextColor(0, 0, 0); // RGB

// header
$pdf->SetFontSize($headerFontSize);
$pdf->SetXY(15, 0);
$pdf->Cell(105, 27, $header, ($borders == 'custom' ? 0 : $borders), 0, 'C');

/// Anschrift BOX
$pdf->SetXY(20, 27);
$pdf->Cell(85, 45, '', ($borders == 'custom' ? 1 : $borders));
// Rücksendeangabe
$pdf->SetFontSize($absfontsize);
$pdf->SetXY(25, 27);
$pdf->Cell(80, 5, $absender, ($borders == 'custom' ? 0 : $borders));
// Zusatz- und Vermerkzone
$pdf->SetFontSize($vermfontsize);
$pdf->SetXY(25, 32);
$pdf->CellFit(80, 12.7, $vermerk, 1, 0, 'L', false, '', true, false);
// Anschriftzone
$pdf->SetFontSize($anschriftFontSize);
$pdf->SetXY(25, 44.7);
$pdf->MultiCell(80, (27.3 / 6), '' . "\n" . $eName . "\n" . $eStrasse . "\n" . $eOrt, 1);

// Faltemarke 1
$pdf->SetDrawColor(99, 99, 99);
$pdf->Line(0, 87, 5, 87);
$pdf->SetDrawColor(0, 0, 0);
// Infobox
$pdf->SetFontSize($infofontsize);
$pdf->SetXY(125, 32);
$pdf->MultiCell(75, 5, (strlen($infoIhrZeichen) > 0 ? 'Ihr Zeichen: ' . $infoIhrZeichen : '') . "\n" . (strlen($infoIhreNachrichtVom) > 0 ? 'Ihre Nachricht Vom: ' . $infoIhreNachrichtVom : '') . "\n" . (strlen($infoUnserZeichen) > 0 ? 'Unser Zeichen: ' . $infoUnserZeichen : '') . "\n" . (strlen($infoUnsereNachrichtVom) > 0 ? 'Unsere Nachricht vom: ' . $infoUnsereNachrichtVom : ''));

$pdf->SetXY(125, 57);
$pdf->MultiCell(75, 5, (strlen($infoName) > 0 ? 'Name:' : '') . "\n" . (strlen($infoTelefon) > 0 ? 'Telefon:' : '') . "\n" . (strlen($infoTelefax) > 0 ? 'Telefax:' : '') . "\n" . (strlen($infoEmail) > 0 ? 'Email:' : '') . "\n" . (strlen($infoDatum) > 0 ? 'Datum:' : ''));
$pdf->SetXY(140, 57);
$pdf->MultiCell(75, 5, $infoBoxName);


// Fliesstext
$pdf->SetLeftMargin(25);
$pdf->SetRightMargin(20);
$pdf->SetFontSize($textfontsize);
$pdf->SetXY(25, (87 + 8.46));
$pdf->Write(5, $text);
$pdf->Write(5, "\n" . "\n" . $gruss);
$pdf->Write(5, "\n" . "\n" . $aName);

// footer
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(25);
$pdf->SetRightMargin(20);
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetFontSize($footerFontSize);
$pdf->SetXY(25, 288);
$pdf->Cell(165, 10, $footerContent, 0, 0, 'C');





$pdf->Output();
