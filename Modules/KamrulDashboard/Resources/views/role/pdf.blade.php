

<?php
$line_height = 15;
$line_height_1 = 10;
$line_height_row = 95;//63.33;//47.5

Fpdf::AddPage();
Fpdf::SetFont('Arial','B',15);
Fpdf::Cell(75);
Fpdf::Cell(40,10,getSetting('site_name', 'site_setting'),1,0,'C');
Fpdf::Ln(20);

Fpdf::SetFont('Courier', '', 18);
Fpdf::Cell(50, $line_height, 'Name:',0);
Fpdf::Cell(140, $line_height, $role->name,0,1);
Fpdf::Cell(50, $line_height, 'Status:',0);
Fpdf::Cell(140, $line_height, array_status_disign_name($role->status),0,1);
Fpdf::Cell(190, $line_height, 'Permissions:',0,1);
$i=0;
foreach ($role->permission as $key=>$value){
    $i++;
    if($i == 2){
        Fpdf::Cell($line_height_row, $line_height_1, $value->name,1,1);
        $i = 0;
    }else{
        Fpdf::Cell($line_height_row, $line_height_1, $value->name,1,0);
    }
}
Fpdf::Output();
exit();
?>
