<?php
error_reporting(E_ALL);

//date_default_timezone_set('Europe/London');

/** PHPExcel */
require_once '../Classes/PHPExcel.php';

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");



function number_to_words($number)
{
    if ($number > 999999999)
    {
       throw new Exception("Number is out of range");
    }

   /* $Gn = floor($number / 1000000);  /* Millions (giga) 
    $number -= $Gn * 1000000; */
	$crn = floor($number / 10000000);  /* Crores (giga) */
    $number -= $crn * 10000000;
    $Ln = floor($number / 100000);  /* Millions (giga) */
    $number -= $Ln * 100000;
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */
	$cn = round(($number-floor($number))*100); /* Cents */
    $result = ""; 

  /*  if ($Gn)
    {  $result .= number_to_words($Gn) . " Million";  } */
	
		if ($crn)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($crn) . " Crores"; } 

	
	if ($Ln)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($Ln) . " Lacs"; } 

	
    if ($kn)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($kn) . " Thousand"; } 

    if ($Hn)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($Hn) . " Hundred";  } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n)
    {
       if (!empty($result))
       {  $result .= " ";
       } 

       if ($Dn < 2)
       {  $result .= $ones[$Dn * 10 + $n];
       }
       else
       {  $result .= $tens[$Dn];
          if ($n)
          {  $result .= "-" . $ones[$n];
          }
       }
    }

    if ($cn)
    {
       if (!empty($result))
       {  $result .= ' ';
       }
      // $title = $cn==1 ? 'cent ': 'cents';
	   $title = $cn==1 ? '': '';
       $result .= strtolower(number_to_words($cn)).' '.$title;
    }
	
	

    if (empty($result))
    {  $result = "zero"; } 

    return $result;
}



// Add some data
$servername = $_POST['txt_s'];
$usernm = $_POST['txt_u'];
$pas = $_POST['txt_p'];
$db1 = $_POST['txt_db'];

 
mysql_connect("$servername", "$usernm", "$pas") or die("unable to connect server");
mysql_select_db("$db1") or die("unable to connect db");



// Add some data

 $month_no = $_POST['cmb_loan_installment_list_month'];
 $employee_no = array();
 
$sq_name = mysql_query("select * from company_info");
while($row_info = mysql_fetch_assoc($sq_name))
{
$row_info['name'] = str_replace('12345', ' ', $row_info['name']);
$str_address = $row_info['name']." \n".$row_info['address1']." ".$row_info['address2']." ".$row_info['address3']." ".$row_info['address4'].", ".$row_info['city']." ".$row_info['pin_code'];
}
 
 
 
 
 $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A1", $str_address. "\n Month : ".date('M-Y', strtotime($month_no)));
			
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			 
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
 
 
 //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 


$objPHPExcel->setActiveSheetIndex(0)
             ->setCellValue("A2", "Sr. No")
			 ->setCellValue("B2", "Loan Account No.")
			 ->setCellValue("C2", "Name of Employee") 
			 ->setCellValue("D2", "Amount"); 
			 
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D2')->getFont()->setBold(true);

$i = 3;
$j = 1;
$total_amt = 0;

$sq_payroll_details = mysql_query("select employee_no, comp_code, paid_amt from payroll_details where comp_code='D0007' and month_no='$month_no'");
while($r_payroll_details = mysql_fetch_assoc($sq_payroll_details))
{

 
 $sq_empl_master = mysql_query("select first_name, middle_name, last_name from empl_master where employee_no='$r_payroll_details[employee_no]'");
 while($r_empl_master = mysql_fetch_assoc($sq_empl_master))
 {
    $emp_name = $r_empl_master['first_name']." ".$r_empl_master['middle_name']." ".$r_empl_master['last_name'];
 }
 
 $sq_employment_dtls = mysql_query("select * from comp_details where employee_no='$r_payroll_details[employee_no]'");
 while($r_employment_dtls = mysql_fetch_assoc($sq_employment_dtls))
 {
 
    if($r_employment_dtls['loan_acc_no_1'] != '')
	{
    $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $j)
				->setCellValue('B'.$i, $r_employment_dtls['loan_acc_no_1'])
				->setCellValue('C'.$i, $emp_name)
				->setCellValue('D'.$i, $r_employment_dtls['loan_amt_1']);
				
	$total_amt = $total_amt + $r_employment_dtls['loan_amt_1'];
	}
	if($r_employment_dtls['loan_acc_no_2'] != '')
	{
	$i = $i + 1;
	$j = $j + 1;
	
    $objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$i, $j)
				->setCellValue('B'.$i, $r_employment_dtls['loan_acc_no_2'])
				->setCellValue('C'.$i, $emp_name)
				->setCellValue('D'.$i, $r_employment_dtls['loan_amt_2']);
				
	$total_amt = $total_amt + $r_employment_dtls['loan_amt_2'];
	}
				
				
	$i = $i + 1;
	$j = $j + 1;
 }
}


$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('C'.$i, "Total")
				->setCellValue('D'.$i, $total_amt);
				
$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D'.$i)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

$i = $i + 1;

$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$i, "Total Amount in Words: ")
				->setCellValue('C'.$i, number_to_words($total_amt)." Only");

$objPHPExcel->getActiveSheet()->getStyle('B'.$i)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C'.$i)->getFont()->setBold(true);
				


$objPHPExcel->getActiveSheet()->setTitle('Loan Installment List');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));


// Echo memory peak usage


header('Content-type: text/plain');
//open/save dialog box
header('Content-Disposition: attachment; filename="loan_installment_list.xlsx"');
//read from server and write to buffer
readfile("loan_installment_list.xlsx");
// Echo memory peak usage
echo date('H:i:s') . "Done writing file.\r\n";



?>