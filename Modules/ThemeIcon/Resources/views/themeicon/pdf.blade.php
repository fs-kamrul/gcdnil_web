

<?php
$line_height = 15;

Fpdf::AddPage();
Fpdf::SetFont('Arial','B',15);
Fpdf::Cell(75);
Fpdf::Cell(40,10,getSetting('site_name', 'site_setting'),1,0,'C');
Fpdf::Ln(20);

Fpdf::SetFont('Courier', '', 18);
Fpdf::Cell(50, $line_height, 'Name:',0);
Fpdf::Cell(140, $line_height, $themeicon->name,0,1);
Fpdf::Cell(50, $line_height, 'Status:',0);
Fpdf::Cell(140, $line_height, array_status_disign_name($themeicon->status),0,1);
Fpdf::Output();
exit();
?>
