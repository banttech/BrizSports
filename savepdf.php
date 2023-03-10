<?
session_start();
$html=$_SESSION['savepdf'];

include("MPDF/mpdf.php");

$mpdf=new mPDF('utf-8', 'A4-l', '10', 'Arial', 10, 10, 10, 10, 5, 5); 
$mpdf->charset_in = 'utf-8';

$mpdf->simpleTables = true;
$mpdf->packTableData = true;
$keep_table_proportions = TRUE;
$mpdf->shrink_tables_to_fit=1;

$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;

$stylesheet = file_get_contents('savepdf.css');

$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html,2);

$mpdf->Output();
exit;

//echo $html;

?>