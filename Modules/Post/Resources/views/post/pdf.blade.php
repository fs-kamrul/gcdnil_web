

<?php

$line_height = 15;
$line_width = 140;

Fpdf::AddPage();
Fpdf::SetFont('Arial','B',15);
Fpdf::Cell(75);
Fpdf::Cell(40,10,getSetting('site_name', 'site_setting'),1,0,'C');
Fpdf::Ln(20);

Fpdf::SetFont('Courier', '', 18);
Fpdf::Cell(50, $line_height, 'Name:',0);
Fpdf::Cell($line_width, $line_height, $post->name,0,1);
if($post->header_title) {
    Fpdf::Cell(50, $line_height, 'Header Title:', 0);
    Fpdf::Cell($line_width, $line_height, $post->header_title, 0, 1);
}
if($post->header_title) {
    Fpdf::Cell(50, $line_height, 'Tag Line:', 0);
    Fpdf::Cell($line_width, $line_height, $post->tag_line, 0, 1);
}
Fpdf::Cell(50, $line_height, 'Status:',0);
Fpdf::Cell($line_width, $line_height, array_status_disign_name($post->status),0,1);
if($post->description) {
    Fpdf::Cell(50, $line_height, 'Description:', 0);
    Fpdf::TextArea(-1, 10, $line_width, $line_height-7, 0, $post->description);
}
Fpdf::Output();
exit();
?>
