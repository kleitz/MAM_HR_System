<?PHP

if(!isset($_SESSION))
 session_start();

if (file_exists("connection.xml")) 
{
$xml = simplexml_load_file("connection.xml");
}
else if(file_exists("model/connection.xml")) 
{
$xml = simplexml_load_file("model/connection.xml");
}
else if(file_exists("../model/connection.xml")) 
{
$xml = simplexml_load_file("../model/connection.xml");
}
else
{
  echo "Failed to open XML";
  exit(0);
}

//echo $xml->getName() . "<br />";
$con = array();
$company1 = str_replace(' ', '12345', $_SESSION['company_name']);
$company = $company1;

foreach($xml->children() as $child)
{
  if($child->getName() == $company)
  {
  //echo "\n".$child->getName();
   foreach($child->children() as $child1)
   {
        if($child1 == ' ')
		{
		  $child1 = str_replace($child1, '',' ');
		}
		array_push($con, $child1);
   }
   //echo $child1->getName() . ": " . $child1 . "<br />";
  $server = "$con[0]";
  $_SESSION['server'] = $server;
  $uname = "$con[1]";
  $_SESSION['uname'] = $uname;
  $password = "$con[2]";
  $_SESSION['password'] = $password;
  //echo $server;
  mysql_connect($server, $uname, $password);
  $dbname = "$con[3]";
  $_SESSION['dbname'] = $dbname;
  mysql_select_db($dbname) or die("Unable to connect db");
  //echo $child->getName() . ": " . $child . "<br />";
  }
 }

CLASS Model {
 
     VAR $db;
	 public $result;
	 
	  FUNCTION Model() {
          $this->db = MYSQL_CONNECT ($_SESSION['server'], $_SESSION['uname'], $_SESSION['password'])
           or DIE ("Unable to connect to Database Server");
 
          MYSQL_SELECT_DB ($_SESSION['dbname'], $this->db) or DIE ("Could not select database");
     }
 
     FUNCTION query($sql) {
          $result = MYSQL_QUERY ($sql, $this->db) or DIE ("Invalid query: " . MYSQL_ERROR());
          RETURN $result;
     }
	 
    FUNCTION fetch($sql) {
          $data = ARRAY();
          $result = $this->query($sql);
 
          WHILE($row = MYSQL_FETCH_ASSOC($result)) {
               $data[] = $row;
          }
               RETURN $data;
     }
     ///////////////////////////
     FUNCTION getone($sql) {
     $result = $this->query($sql);
 
     IF(MYSQL_NUM_ROWS($result) == 0)
          $value = FALSE;
     ELSE
          $value = MYSQL_RESULT($result, 0);
          RETURN $value;
     }
     ///////////////////////////
	
	
	public function add_personal_info($emp_no, $first_name, $middle_name, $last_name, $gender, $date_of_birth, $marital_status, $blood_group, $place_of_origin, $nationality, $permanent_addr_1, $permanent_addr_2, $permanent_addr_3, $permanent_city, $permanent_state, $permanent_country, $present_addr_1, $present_addr_2, $present_addr_3, $present_city,$present_state, $present_country,$residential_phone_no, $mobile_no, $emergency_contact_no, $emergency_contact_person, $email_id,$present_pin_code,$permanent_pin_code, $emp_code, $punching_code)
	{
	//echo "in insert";
	if($emp_no!='' && $first_name!='' && $last_name!='' && $emp_code!='') 
	{
	$date =date('Y/m/d');
	
	$sq_emp_code = mysql_query("select emp_code from empl_master where emp_code='$emp_code'");
	if(mysql_num_rows($sq_emp_code)>0)
	{
	  echo "Can not duplicate Employee Code, please enter another Employee Code";
	  exit(0);
	}
	
	 $sq = "insert into empl_master values ('$emp_no', '', '$emp_code', '$punching_code', '$first_name', '$middle_name', '$last_name', '$gender', '$date_of_birth', '$marital_status', '$blood_group', '$place_of_origin', '$nationality', '$permanent_addr_1', '$present_addr_2' ,'$permanent_addr_3','$permanent_city','$permanent_pin_code','$permanent_state','$permanent_country','$present_addr_1','$present_addr_2','$present_addr_3','$present_city','$present_pin_code','$present_state','$present_country','$residential_phone_no','$mobile_no','$emergency_contact_no','$emergency_contact_person','$email_id','$date','$_SESSION[txt_login_name]','','')";
	
	$sq1 = mysql_query("insert into comp_details     	values('$emp_no','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','$_SESSION[txt_login_name]','','')");
	
 $sq2 = mysql_query("insert into experience values('$emp_no','1','','','','','','','$_SESSION[txt_login_name]','','')");
 
 $sq3 = mysql_query("insert into qualification values('$emp_no','1','','','','','','','','$_SESSION[txt_login_name]','','')");
 
 $sq4 = mysql_query("insert into family_info values('$emp_no','','','','','','','','','','','', '', '', '$_SESSION[txt_login_name]','','')");
	 
	 $res = $this->query($sq);
	
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Employee added successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	public function update_personal_info($emp_no, $first_name, $middle_name, $last_name, $gender, $date_of_birth, $marital_status, $blood_group, $place_of_origin, $nationality, $permanent_addr_1, $permanent_addr_2, $permanent_addr_3, $permanent_city, $permanent_state, $permanent_country, $present_addr_1, $present_addr_2, $present_addr_3, $present_city,$present_state, $present_country,$residential_phone_no, $mobile_no, $emergency_contact_no, $emergency_contact_person, $email_id,$present_pin_code,$permanent_pin_code, $emp_code, $punching_code)
	{
	//echo "in insert";
	if($emp_no!='' && $first_name!='' && $last_name!='' && $emp_code!='') 
	{
		$date =date('Y/m/d');
		
		$sq_emp_code = mysql_query("select emp_code from empl_master where emp_code='$emp_code' and employee_no!='$emp_no'");
		if(mysql_num_rows($sq_emp_code)>0)
		{
		  echo "This employee code already exists";
		  exit(0);
		}
	
	 $sq = "update empl_master set first_name ='$first_name', middle_name ='$middle_name', last_name ='$last_name',gender ='$gender', birth_date='$date_of_birth', marital_status ='$marital_status', blood_group ='$blood_group', place_of_origin ='$place_of_origin', nationality ='$nationality', permanent_addr_1 ='$permanent_addr_1', permanent_addr_2 ='$permanent_addr_2', permanent_addr_3 ='$permanent_addr_3', permanent_city ='$permanent_city',permanent_state ='$permanent_state',	permanent_country='$permanent_country',present_addr_1='$present_addr_1',present_addr_2='$present_addr_2',present_addr_3='$present_addr_3',present_city='$present_city',present_country='$present_country',present_state='$present_state',residence_phone_no='$residential_phone_no',mobile_no='$mobile_no',emergency_contact_no='$emergency_contact_no',emergency_contact_person='$emergency_contact_person',email_id='$email_id',present_pin_code='$present_pin_code',permanent_pin_code='$permanent_pin_code', updated_on='$date',updated_by='$_SESSION[txt_login_name]', emp_code='$emp_code', punching_code='$punching_code' where employee_no='$emp_no'";
	 
	 $date =date('Y/m/d');
	
	 
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Employee updated successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	
	
	
	
	public function add_company_info($emp_no, $date_of_joining, $comp_change_eff_date, $designation, $grade, $basic, $hra, $special, $conveyance,$lta, $pf_applicable, $prof_tax_applicable, $esi_applicable, $bank_branch_name, $account_no, $gratuity_applicable, $tds_applicable, $pension_fund_applicable,$pf_no, $pf_date,$pf_uan_no, $pf_uan_date,$dearness_pay, $da, $gross_salary, $ctc, $emp_type,$emp_cat,$date_confirm,$date_sep,$type_sep,$remark_sep,$salary_on_joining,$mode_of_payment, $lic_acc_1, $lic_amt_1, $lic_acc_2, $lic_amt_2, $loan_acc_1, $loan_amt_1, $loan_acc_2, $loan_amt_2, $lic_id_1, $lic_id_2, $lic_gratuity_1, $lic_gratuity_2, $loan_id_1, $loan_id_2, $loan_gratuity_1, $loan_gratuity_2, $grant_type, $department)
	{
	//echo "in insert";
	if($emp_no!='' && $date_of_joining!='') 
	{
	$date =date('Y/m/d');
	$sql = mysql_query("delete from comp_details where employee_no='$emp_no'");
	
	
	 $sq = "insert into comp_details values ('$emp_no','$date_of_joining', '$comp_change_eff_date', '$designation', '$grade', '$bank_branch_name', '$account_no', '$basic', '$hra' ,'$special','$conveyance','$lta','$pf_applicable','$prof_tax_applicable','$esi_applicable','$tds_applicable','$gratuity_applicable','$pension_fund_applicable','$pf_no','$pf_date','$pf_uan_no','$pf_uan_date','$dearness_pay','$da','$gross_salary','$ctc','$emp_type','$emp_cat','$date_confirm','$date_sep','$type_sep','$remark_sep','$salary_on_joining','$mode_of_payment', '$lic_acc_1','$lic_id_1', '$lic_gratuity_1', '$lic_amt_1', '$lic_acc_2', '$lic_id_2', '$lic_gratuity_2', '$lic_amt_2', '$loan_acc_1', '$loan_id_1','$loan_gratuity_1', '$loan_amt_1', '$loan_acc_2', '$loan_id_2', '$loan_gratuity_2', '$loan_amt_2', '$grant_type', '$department', '$date','$_SESSION[txt_login_name]','','')";
	
	
	if($grade!='select')
	{
	$sq3 = mysql_query("insert into emp_comp_master values('$emp_no','$date','$_SESSION[txt_login_name]','','')");
	$sq4 = mysql_query("insert into attendance values('$emp_no','','','','','','','','','')");
	$sq5 = mysql_query("insert into recovery values('$emp_no','','','','','','','','','','','','','')");
	$sq1 = mysql_query("select * from grade_comp_master where grade='$grade'");
	while($r = mysql_fetch_assoc($sq1))
	{
	  $sq2 = mysql_query("insert into emp_comp_master_lines values('$emp_no', '$r[comp_code]', '$comp_change_eff_date', '$r[amount]')");
	}
	}
	 
	 $res = $this->query($sq);
	
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Company Info added successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	public function update_company_info($emp_no,$date_of_joining, $comp_change_eff_date, $designation, $grade, $basic, $hra, $special, $conveyance,$lta, $pf_applicable, $prof_tax_applicable, $esi_applicable, $bank_branch_name, $account_no, $gratuity_applicable, $tds_applicable, $pension_fund_applicable,$pf_no, $pf_date,$pf_uan_no, $pf_uan_date,$dearness_pay, $da, $gross_salary, $ctc, $emp_type,$emp_cat,$date_confirm,$date_sep,$type_sep,$remark_sep,$salary_on_joining,$mode_of_payment, $lic_acc_1, $lic_amt_1, $lic_acc_2, $lic_amt_2, $loan_acc_1, $loan_amt_1, $loan_acc_2, $loan_amt_2, $lic_id_1, $lic_id_2, $lic_gratuity_1, $lic_gratuity_2, $loan_id_1, $loan_id_2, $loan_gratuity_1, $loan_gratuity_2, $grant_type,$department)
	{
	//echo "in insert";
	if($emp_no!='' && $date_of_joining!='' ) 
	{
		$date =date('Y/m/d');
		
		
		$sq_employment_details = mysql_query("select * from comp_details where employee_no='$emp_no'");
		while($r_emp_details = mysql_fetch_assoc($sq_employment_details))
		{
		  if($r_emp_details['grade'] != $grade)
		  {
		     $sq_emp_comp = mysql_query("select * from emp_comp_master where employee_no='$emp_no'");
			 $num_r = mysql_num_rows($sq_emp_comp);
			 if($num_r == 0)
			 {
	$sq3 = mysql_query("insert into emp_comp_master values('$emp_no','$date','$_SESSION[txt_login_name]','','')");
	$sq4 = mysql_query("insert into attendance values('$emp_no','','','','','','','','','')");
	$sq5 = mysql_query("insert into recovery values('$emp_no','','','','','','','','','','','','','')");
	$sq1 = mysql_query("select * from grade_comp_master where grade='$grade'");
	while($r = mysql_fetch_assoc($sq1))
	{
	  $sq2 = mysql_query("insert into emp_comp_master_lines values('$emp_no', '$r[comp_code]', '$comp_change_eff_date', '$r[amount]')");
	}
			   
			 }
			 else
			 {
			 
	$sq_del = mysql_query("delete from emp_comp_master_lines where employee_no='$emp_no'");
	 $sq1 = mysql_query("select * from grade_comp_master where grade='$grade'");
	while($r = mysql_fetch_assoc($sq1))
	{
	  $sq2 = mysql_query("insert into emp_comp_master_lines values('$emp_no', '$r[comp_code]', '$comp_change_eff_date', '$r[amount]')");
	}
			 
			 }
		  }
		}
		
		
	 $sq = "update comp_details set joining_date  ='$date_of_joining', comp_change_eff_date ='$comp_change_eff_date', designation ='$designation',grade ='$grade', basic='$basic', hra ='$hra', special ='$special', conveyance ='$conveyance', lta ='$lta', pf_applicable ='$pf_applicable', prof_tax_applicable ='$prof_tax_applicable', esi_applicable ='$esi_applicable', bank_branch_name ='$bank_branch_name',bank_account_no ='$account_no',	tds_applicable='$tds_applicable',gratuity_applicable='$gratuity_applicable',pension_fund_applicable 	='$pension_fund_applicable',pf_number='$pf_no',pf_date='$pf_date',pf_uan='$pf_uan_no',pf_uan_date='$pf_uan_date',dearness_pay='$dearness_pay',da='$da',gross_salary='$gross_salary',ctc='$ctc',emp_type='$emp_type',emp_cat='$emp_cat',date_of_confirm='$date_confirm' ,date_of_sepration='$date_sep', 	type_of_sep='$type_sep',remark_for_sepration='$remark_sep',salary_on_joining='$salary_on_joining',mode_of_payment='$mode_of_payment',updated_on='$date',updated_by='$_SESSION[txt_login_name]',  lic_acc_no_1='$lic_acc_1', lic_amt_1='$lic_amt_1', lic_acc_no_2='$lic_acc_2', lic_amt_2='$lic_amt_2', loan_acc_no_1='$loan_acc_1', loan_amt_1='$loan_amt_1', loan_acc_no_2='$loan_acc_2', loan_amt_2='$loan_amt_2', lic_id_no_1='$lic_id_1', lic_id_no_2='$lic_id_2', lic_gratuity_no_1='$lic_gratuity_1', lic_gratuity_no_2='$lic_gratuity_2', loan_id_no_1='$loan_id_1', loan_id_no_2='$loan_id_2', loan_gratuity_no_1='$loan_gratuity_1', loan_gratuity_no_2='$loan_gratuity_2', grant_type='$grant_type', department='$department' where employee_no='$emp_no'";
	 
	 $date =date('Y/m/d');
	 $total_lic = $lic_amt_1 + $lic_amt_2;
	 $total_loan = $loan_amt_1 + $loan_amt_2;
	 mysql_query("update emp_comp_master_lines set amount ='$total_lic',comp_change_eff_date='$date' where employee_no='$emp_no' and comp_code='D0008'");
	 mysql_query("update emp_comp_master_lines set amount ='$total_loan',comp_change_eff_date='$date' where employee_no='$emp_no' and comp_code='D0007'");
	 if($grade!='select')
	{
	$sq3 = mysql_query("insert into emp_comp_master values('$emp_no','$date','$_SESSION[txt_login_name]','','')");
	$sq4 = mysql_query("insert into attendance values('$emp_no','','','','','','','','','')");
	$sq5 = mysql_query("insert into recovery values('$emp_no','','','','','','','','','','','','','')");
	$sq1 = mysql_query("select * from grade_comp_master where grade='$grade'");
	while($r = mysql_fetch_assoc($sq1))
	{
	  $sq2 = mysql_query("insert into emp_comp_master_lines values('$emp_no', '$r[comp_code]', '$comp_change_eff_date', '$r[amount]')");
	}
	}
	 
	 
	
	 
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Company Info updated successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	public function add_education_info($emp_no, $sr_no, $degree_title, $subject, $year_of_passing, $university, $state, $country)
	{
	
	if($emp_no!='' ) 
	{
	$count = sizeof($sr_no);
	for($s=0;$s<$count;$s++)
	{
		if($sr_no[$s]=='' || $degree_title[$s]=='' || $subject[$s]=='' || $year_of_passing[$s]=='' || $university[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	$date =date('Y/m/d');
	$count = sizeof($sr_no);
	$sql = mysql_query("delete from qualification where employee_no='$emp_no'");
	for($s=0;$s<$count;$s++)
		{
		if($sr_no[$s]!='' || $degree_title[$s]!='' || $subject[$s]!='' || $year_of_passing[$s]=='' || $university[$s]=='')
			{ 	
	 $sq = mysql_query("insert into qualification values ('$emp_no','$sr_no[$s]', '$degree_title[$s]', '$subject[$s]', '$year_of_passing[$s]', '$university[$s]', '$state[$s]', '$country[$s]','$date','$_SESSION[txt_login_name]','','')");
			}
	 }
	 
	
	
	 if(!$sq)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	
	   
	  echo "Education Info added successfully!!!";
	 
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
public function update_education_info($emp_no,$sr_no, $degree_title, $subject, $year_of_passing, $university, $state, $country)
	{
	//echo "in insert";
	if($emp_no!='') 
	{
	
	$count = sizeof($sr_no);
	for($s=0;$s<$count;$s++)
		{
		if($sr_no[$s]=='' || $degree_title[$s]=='' || $subject[$s]=='' || $year_of_passing[$s]=='' || $university[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
		$date =date('Y/m/d');
	 $sq = "update  qualification set sr_no  ='$sr_no', degree_title ='$degree_title', subject ='$subject',year_of_passing ='$year_of_passing', university='$university', state ='$state', country ='$country', updated_on='$date',updated_by='$_SESSION[txt_login_name]' where employee_no='$emp_no'";
	 
	 $date =date('Y/m/d');
	
	 
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Education Info updated successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	public function add_experience($emp_no,$sr_no, $from_period, $upto_period, $company_name, $designation, $role_details)
	{
	//echo "in insert";
	if($emp_no!=''  ) 
	{
	
	$count = sizeof($sr_no);
	for($s=0;$s<$count;$s++)
		{
		if($sr_no[$s]=='' || $from_period[$s]=='' || $upto_period[$s]=='' || $company_name[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	$date =date('Y/m/d');
	$count = sizeof($sr_no);
	
	$sql = mysql_query("delete from experience where employee_no='$emp_no'");
	
	for($s=0;$s<$count;$s++)
		{
		if($sr_no[$s]!='' || $from_period[$s]!='' || $upto_period[$s]!='' || $company_name[$s]=='')
			{
	 			
	 $sq = mysql_query("insert into experience values ('$emp_no','$sr_no[$s]','$from_period[$s]','$upto_period[$s]','$company_name[$s]','$designation[$s]', '$role_details[$s]','$date','$_SESSION[txt_login_name]','','')");
	}
	}
	 
	 
	
	 if(!$sq)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Experience added successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	public function update_experience($emp_no,$sr_no, $from_period, $upto_period, $company_name, $designation, $role_details)
	{
	//echo "in insert";
	if($emp_no!='') 
	{
		$date =date('Y/m/d');
	 $sq = "update experience set sr_no  ='$sr_no', from_period ='$from_period', upto_period ='$upto_period',company_name ='$company_name', designation='$designation', role_details ='$role_details',updated_on='$date',updated_by='$_SESSION[txt_login_name]' where employee_no='$emp_no'";
	 
	 $date =date('Y/m/d');
	
	 
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Experience updated successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	
	public function add_family_info($emp_no,$spouse_Name, $spouse_contact_no, $no_of_family_member, $no_of_dependents,$name1,$relation1,$age1,$gaurdian1,$name2,$relation2,$age2,$gaurdian2)
	{
	//echo "in insert";
	if($emp_no!='' && $spouse_Name!='' ) 
	{
	$date =date('Y/m/d');
	 $sql = mysql_query("delete from family_info where employee_no='$emp_no'");
	 $sq = "insert into family_info values ('$emp_no','$spouse_Name','$spouse_contact_no','$no_of_family_member','$no_of_dependents','$name1','$relation1','$age1','$gaurdian1','$name2','$relation2','$age2','$gaurdian2','$date','$_SESSION[txt_login_name]','','')";
	
	 
	 $res = $this->query($sq);
	
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Family Info added successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	public function update_family_info($emp_no,$spouse_Name, $spouse_contact_no, $no_of_family_member, $no_of_dependents,$name1,$relation1,$age1,$gaurdian1,$name2,$relation2,$age2,$gaurdian2)
	{
	//echo "in insert";
	if($emp_no!='' && $spouse_Name!='') 
	{
		$date =date('Y/m/d');
	 $sq = "update family_info set spouse_Name  ='$spouse_Name', spouse_contact_no ='$spouse_contact_no', no_of_members ='$no_of_family_member',no_of_dependents ='$no_of_dependents',name1='$name1',relation1='$relation1',age1='$age1',gaurdian_name1='$gaurdian1',name2='$name2',relation2='$relation2',age2='$age2',gaurdian_name2='$gaurdian2',updated_on='$date',updated_by='$_SESSION[txt_login_name]' where employee_no='$emp_no'";
	 
	 $date =date('Y/m/d');
	
	 
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Family Info updated successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else

	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	
	
	
	
	public function add_user_role($emp_no,$role)
	{

	if($emp_no!=''  ) 
	{
	$count = sizeof($emp_no);
	for($s=0;$s<$count;$s++)
		{
		if($emp_no[$s]=='' || $role[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	$count = sizeof($emp_no);
	
	for($s=0;$s<$count;$s++)
		{
	if($emp_no[$s]!='')
	{
	 			
	 $sq = mysql_query("insert into user_roles values ('$emp_no[$s]','$role[$s]')");
	}
	}
	 
	 if(!$sq)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Employee Role added successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	
	public function add_user($emp_no, $password,$role)
	{

	if($emp_no!=''  ) 
	{
	$count = sizeof($emp_no);
	for($s=0;$s<$count;$s++)
		{
		if($emp_no[$s]=='' || $password[$s]=='' || $role[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	$count = sizeof($emp_no);
	
	for($s=0;$s<$count;$s++)
		{
	if($emp_no[$s]!='')
	{
	 			
	 $sq = mysql_query("insert into user values ('$emp_no[$s]','$password[$s]','$role[$s]')");
	}
	}
	 
	 if(!$sq)
	 {
	 $value = FALSE;
	echo "Duplicate User";
	}
      ELSE
	  {	  
	  echo "User added successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
public function changepassword($uname, $currentpass, $changepass, $confirmpass)
	{
	if($uname!='' && $currentpass!=''  &&  $changepass!='' && $confirmpass!='')
	{
	//echo "in insert";
	 $sq = mysql_query("select * from user where user_name ='$uname' and password='$currentpass'");
	 if($row = mysql_fetch_assoc($sq))
	 {
	 
	   if($changepass == $confirmpass)
	   {
	   $sq1 = "update user set password='$changepass' where user_name ='$uname' and password='$currentpass'";
	    $res = $this->query($sq1);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {
	  echo "Password Changed successfully!!";
	   $value = TRUE;
	   RETURN $value;
	  }

	   }
	   else
	   {
	     echo "Confirm Password";
	   }
	 }
	 else
	 {
	   echo "You have entered wrong password";
	 }
	}
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
		
	
	
	public function change_user_role($emp_id,$role)
	{
	//echo "in insert";
	if($emp_id!='') 
	{
	
	 $sq = "update user set role  ='$role' where user_name='$emp_id'";
	 
	
	
	 
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Employee Role updated successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}
	
	
	
	public function addinfo($a, $b, $c, $d, $address4, $e, $f, $g, $h, $i, $j, $k, $m, $n, $o, $p, $q, $r, $s, $t, $u, $v, $w, $x, $commissionorate, $pla_ac_no, $sign1, $sign2, $sign3)
	{
	//echo "in insert";
	if($a!='')
	{
	 

	$sq_delete = mysql_query("delete from company_info");
	
	$a = str_replace("'", "''", $a);
	
	 $sq = "insert into company_info values ('$a', '$b', '$c', '$d', '$address4', '$e', '$f', '$g', '$h', '$i', '$j', '$k', '$m', '$n','$o', '$p', '$q', '$r', '$s', '$t', '$u','$v','$w','$x','$commissionorate','$pla_ac_no','$sign1', '$sign2', '$sign3')";

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Information added successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}	
	
	
	
public function updateinfo($a, $b, $c, $d, $address4, $e, $f, $g, $h, $i, $j, $k, $m, $n, $o, $p, $q, $r, $s, $t, $u,$v,$w,$x,$commissionorate,$pla_ac_no, $sign1, $sign2, $sign3)
	{
	//echo "in insert";
	if($a!='')
	{
	 	
	  $sq = "update company_info set address1='$b', address2='$c', address3='$d', address4='$address4', city='$e', pin_code='$f', state='$g', country='$h', phone_number='$i', landline='$j', email='$k', alternate_email='$m', vat_no='$n', cst_no='$o', service_tax_no='$p', exicise_regn_no='$q', accessee_code='$r', certificate_no='$s', rate_of_duty='$t', income_tax_no='$u', pan_no ='$v', excise_range='$w', excise_div='$x', commissionorate='$commissionorate', pla_ac_no='$pla_ac_no', signature1='$sign1', signature2='$sign2', signature3='$sign3' where name='$a'";

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Information updated successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}	
	
	public function add_compensation_heads($comp_code,$code_name, $code_desc,$when_to_pay, $pf_Compute, $pt_Compute, $esi_Compute)
	{
	//echo "in insert";
	if($comp_code!='' && $code_name!='' )
	{
	
	 $sq = "insert into comp_head values ('$comp_code','$code_name','$code_desc','$when_to_pay','$pf_Compute','$pt_Compute','$esi_Compute','','$_SESSION[txt_login_name]','','')";

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Compensation Heads Info added Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}	
	
	
	public function update_compensation_heads($comp_code,$code_name, $code_desc,$when_to_pay, $pf_Compute, $pt_Compute, $esi_Compute)
	{
	//echo "in insert";
	if($comp_code!='' && $code_name!='' )
	{
	
	 $sq = "update comp_head set comp_name='$code_name',code_descr='$code_desc',pay_when='$when_to_pay',pf_compute='$pf_Compute',pt_compute 	='$pt_Compute',esi_Compute='$esi_Compute',updated_by='$_SESSION[txt_login_name]' where comp_code='$comp_code'";

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Compensation Heads Info Updated Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}	
	
	
public function add_emp_compensation($emp_code, $comp_code, $comp_change_eff_date, $amount)
	{
	//echo "in insert";
	if($emp_code!='select')
	{
	
	 $tdate = date('Y/m/d');
	 $count=0;
	 $sq_new=mysql_query("select * from emp_comp_master where employee_no='$emp_code'");
	 $num_row_new=mysql_num_rows($sq_new);
	 
	 if($num_row_new==0)
	 {
	 
	 $sq = mysql_query("insert into emp_comp_master values ('$emp_code','$tdate','$_SESSION[txt_login_name]','','')");
	
	 }
     $arrlen = sizeof($comp_code);
	  for($s=0;$s<$arrlen;$s++)
	{
		if($comp_code[$s]=='select' || $comp_change_eff_date[$s]=='' || $amount[$s]=='' )
			{
			 echo "Required fields can not be left blank..";
			 exit(0); 
			}
	}
     for($i=0;$i<$arrlen;$i++)
	 {
	 
	$sq_new_lines=mysql_query("select * from emp_comp_master_lines where employee_no='$emp_code' and comp_code='$comp_code'");
	 $num_row_new_lines=mysql_num_rows($sq_new_lines);
	 
	 if($num_row_new_lines==0)
	 {
	

	   $sq1 = mysql_query("insert into emp_comp_master_lines values('$emp_code', '$comp_code[$i]', '$comp_change_eff_date[$i]', '$amount[$i]')");
	   
	   
	   $count = 1;
	 }
	 }
	 

	// $res = $this->query($sq1);
	 if($count!=1)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Employee Compensation Info added Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		


public function update_emp_compensation($emp_code, $comp_code, $comp_change_eff_date, $amount)
	{
	
	$arrlen = sizeof($comp_code);
	  for($s=0;$s<$arrlen;$s++)
	{
		if($comp_code[$s]=='select' || $comp_change_eff_date[$s]=='' || $amount[$s]=='' )
			{
			 echo "Required fields can not be left blank..";
			 exit(0); 
			}
	}
	//echo "in insert";
	if($emp_code!='' && $comp_code!='' )
	{
	
	// $sq = "update emp_comp_master set employee_no='$emp_code',comp_change_eff_date='$comp_change_eff_date',amount 	='$amount',updated_by='$_SESSION[txt_login_name]' where comp_code='$comp_code'";

	$tdate = date('Y-m-d H:i:s');
	 $arrlen = sizeof($comp_code);
	 for($i=0;$i<$arrlen;$i++)
	 {
       $sq3 = mysql_query("select * from emp_comp_master_lines where comp_code='$comp_code[$i]' and employee_no='$emp_code'");
	   while($r3 = mysql_fetch_assoc($sq3))
	   {
	    if($r3['amount'] != $amount[$i]  ||  $comp_change_eff_date[$i] != $r3['comp_change_eff_date'])
		{
	   		$sq2 = mysql_query("insert into empl_comp_log values('','$emp_code','$comp_code[$i]','$tdate','$r3[amount]','$amount[$i]')");
		}
	   }
	   $sq1 = mysql_query("update emp_comp_master_lines set comp_change_eff_date='$comp_change_eff_date[$i]', amount='$amount[$i]' where comp_code='$comp_code[$i]' and employee_no='$emp_code'");
	   
	  
	 }

	 //$res = $this->query($sq1);
	 if(!$sq1)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Employee Compensation Info updated Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		


public function add_grade_wise_compensation($grade, $compe_code, $amounts)
	{
	
	$count = sizeof($compe_code);
	for($s=0;$s<$count;$s++)
	{
		if($compe_code[$s]=='' || $amounts[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	//echo "in insert";
	if($grade!='' && $compe_code!='')
	{
	$tdate = date('Y-m-d');
	$count = sizeof($compe_code);
	for($i=0;$i<$count;$i++)
	{
	 	$sq = mysql_query("insert into grade_comp_master values ('$grade', '$compe_code[$i]', '$amounts[$i]', '$tdate', '$_SESSION[txt_login_name]', '', '')");
    }
	 if(!$sq)
	 {
	 	$value = FALSE;
		echo "ERROR";
	 }
      ELSE
	  {	  
	  echo "Grade Wise Comensation Info added Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		
	
	
	public function update_grade_wise_compensation($grade,$compe_code, $amounts)
	{
	$count = sizeof($compe_code);
	for($s=0;$s<$count;$s++)
	{
		if($compe_code[$s]=='' || $amounts[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	
	//echo "in insert";
	if($grade!='' && $compe_code!='' )
	{
	
	$count = sizeof($compe_code);
	$tdate = date('Y-m-d');
	for($i=0;$i<$count;$i++)
	{
	 $sq = mysql_query("update grade_comp_master set amount='$amounts[$i]', updated_by='$_SESSION[txt_login_name]', updated_on='$tdate' where comp_code='$compe_code[$i]' and grade='$grade'");
	 }

	
	 if(!$sq)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Grade Wise Comensation Info Updated Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		

	
	public function add_month_control($month_no,$month_avtive, $no_days,$per_day_divisor,$da_index, $hra_index, $bonus_index)
	{
	//echo "in insert";
	if($month_no!='' && $month_avtive!='' && $no_days!='' && $per_day_divisor!='')
	{
	
	if($month_avtive == 'Y')
	{
	   $sq_check = mysql_query("select * from month_control where month_active='Y'");
	   if($r_check = mysql_fetch_assoc($sq_check))
	   {
	     echo "Two months can not be active at a Time";
		 exit(0);
	   }
	}
	 $sq = "insert into month_control values ('$month_no','$month_avtive','$no_days','$per_day_divisor','$da_index','$hra_index','$bonus_index', '','$_SESSION[txt_login_name]','','','')";

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Month Control Info added Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		
	
	public function update_month_control($month_no,$month_avtive, $no_days,$per_day_divisor,$da_index,$hra_index, $bonus_index)
	{
	//echo "in insert";
	if($month_no!='' && $month_avtive!='' && $no_days!='' && $per_day_divisor!='')
	{
	
	if($month_avtive == 'Y')
	{
	   $sq_check = mysql_query("select * from month_control where month_active='Y' and month_no!='$month_no'");
	   if($r_check = mysql_fetch_assoc($sq_check))
	   {
	     echo "Two months can not be active at a Time";
		 exit(0);
	   }
	}
	
	 $sq = "update month_control set month_active='$month_avtive',no_days='$no_days',per_day_divisor='$per_day_divisor',da_index='$da_index', hra_index='$hra_index', bonus_index='$bonus_index', updated_by='$_SESSION[txt_login_name]' where  month_no='$month_no'";

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Month Control Info Updated Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		
	

	
public function add_attendance($empl_no,$month_nob, $per_day_for_month, $holidays, $paid_leaves, $unpaid_leaves, $adj_days,$other_Hrs,$leave_encash_days, $suspention_days,$income_tax)
	{
	
	$count = sizeof($empl_no);
	for($s=0;$s<$count;$s++)
	{
		if($empl_no[$s]=='select' || $month_nob[$s]=='select' || $per_day_for_month[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	//echo "in insert";
	
	$tdate = date('Y-m-d');
	$count = sizeof($empl_no);
	for($i=0;$i<$count;$i++)
	{
  
		
		$sq = mysql_query("insert into attendance values ('$empl_no[$i]', '$month_nob[$i]', '$per_day_for_month[$i]', '$holidays[$i]', '$paid_leaves[$i]', '$unpaid_leaves[$i]', '$suspention_days[$i]', '$adj_days[$i]', '$other_Hrs[$i]', '$leave_encash_days[$i]', '$tdate', '$_SESSION[txt_login_name]', '', '')");
		
		//$sq = mysql_query("insert into attendance values ('$empl_no[$i]', '$month_nob[$i]', '$per_day_for_month[$i]', '$holidays[$i]', '$paid_leaves[$i]', '$unpaid_leaves[$i]', '$suspention_days[$i]', '$adj_days[$i]', '$other_Hrs[$i]', '$leave_encash_days[$i]', '$tdate', '$_SESSION[txt_login_name]', '', '')");
		$sq1 = mysql_query("update emp_comp_master_lines set amount='$income_tax[$i]' where comp_code='D0004' and employee_no='$empl_no[$i]'");
    }
	 if(!$sq or !$sq1)
	 {
	 	$value = FALSE;
		echo "ERROR";
	 }
      ELSE
	  {	  
	  echo "Attendance Info added Successfully!!!...";
	   $value = TRUE;
	   RETURN $value;
	  }
	  
	}		
	
	
	
	
	
	
	
	
	public function update_attendance($empl_no,$month_nob, $per_day_for_month, $holidays, $paid_leaves, $unpaid_leaves, $adj_days,$other_Hrs,$leave_encash_days, $suspention_days,$income_tax)
	{
	
	$count = sizeof($empl_no);
	for($s=0;$s<$count;$s++)
	{
		if($empl_no[$s]=='select' || $month_nob[$s]=='')
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	//echo "in insert";
	
	$tdate = date('Y-m-d');
	$count = sizeof($empl_no);
	for($i=0;$i<$count;$i++)
	{
  
		
		$sq =mysql_query("update attendance set pay_days='$per_day_for_month[$i]', adj_days ='$adj_days[$i]', ot_hrs='$other_Hrs[$i]', holidays='$holidays[$i]', paid_leaves='$paid_leaves[$i]', unpaid_leaves='$unpaid_leaves[$i]',  leave_encash_days ='$leave_encash_days[$i]', suspention_days='$suspention_days[$i]', updated_by='$_SESSION[txt_login_name]', updated_on='$tdate' where employee_no ='$empl_no[$i]' and month_no='$month_nob[$i]'");
		
		$sq1 = mysql_query("update emp_comp_master_lines set amount='$income_tax[$i]' where comp_code='D0004' and employee_no='$empl_no[$i]'");
    }
	 if(!$sq or !$sq1)
	 {
	 	$value = FALSE;
		echo "ERROR";
	 }
      ELSE
	  {	  
	  echo "Attendance Info Updated Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  
	}		
	
	
	
	
	
	
	
	
	public function add_recovery($emple_no,$recovery_title, $total_amount,$no_of_installments,$installment_amount_per_salary,$amount_balance_after_recovery,$compen_code,$recovery_status,$remark_any)
	{
	//echo "in insert";
	if($emple_no!='' && $recovery_title!='' && $total_amount!='' && $no_of_installments!='' && $installment_amount_per_salary!='' && $compen_code!='select')
	{
	$tdate = date('Y/m/d');
	 $sq = "insert into recovery values ('$emple_no','$recovery_title','$total_amount','$no_of_installments','$installment_amount_per_salary','$amount_balance_after_recovery','$compen_code','$recovery_status','$remark_any','$no_of_installments','$tdate','$_SESSION[txt_login_name]','','')";

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Recovery Info added Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		

public function update_recovery($emple_no, $recovery_title, $total_amount, $no_of_installments, $installment_amount_per_salary,$amount_balance_after_recovery, $compen_code,$recovery_status,$remark_any)
	{
	//echo "in insert";
	if($emple_no!='' && $recovery_title!='' && $total_amount!='' && $no_of_installments!='')
	{
	$tdate = date('Y/m/d');
	
	$amount_balance_after_recovery = round($amount_balance_after_recovery, 2);
	
	if($recovery_status == 'Foreclosed')
	{
		$sq_recov = mysql_query("select * from recovery where employee_no='$emple_no' and recov_title='$recovery_title'");
		while($r_recov = mysql_fetch_assoc($sq_recov))
		{
		     $remark_any = $remark_any." Foreclosed when Balance amount is ".$r_recov['balance_amount'];
		}
	}
	 
	 $sq_update = mysql_query("update recovery set recov_title='$recovery_title', total_amount='$total_amount', no_of_installments 	='$no_of_installments', inst_amount='$installment_amount_per_salary', balance_amount='$amount_balance_after_recovery', comp_code='$compen_code', recov_status='$recovery_status', remarks='$remark_any', updated_by='$_SESSION[txt_login_name]', updated_on='$tdate' where employee_no='$emple_no' and recov_title='$recovery_title'");

	
	 if(!$sq_update)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Recovery Info Updated Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}	
	
	
	
	
	public function add_batch($batch_no, $month_no, $remark, $employee_number, $comp_code, $adjustment_amount, $remark_any)
	{
	//echo "in insert";
	if($batch_no!='' && $batch_no!='select')
	{
	 $date =date('Y/m/d');
	 $sq = "insert into batch_hdr values('$batch_no','$month_no','$remark','$date','$_SESSION[txt_login_name]','','')";
      
	  
     $count = sizeof($employee_number);
	 for($s=0;$s<$count;$s++)
	{
		if($employee_number[$s]=='select' || $comp_code[$s]=='select' || $adjustment_amount[$s]=='' )
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
     for($i=0;$i<$count;$i++)
	  {
	    $sq1 = mysql_query("insert into batch_dtls values('$batch_no', '$employee_number[$i]', '$comp_code[$i]', '$adjustment_amount[$i]', '$remark_any[$i]', '$date', '$_SESSION[txt_login_name]', '', '')");
	  }
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Batch added Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}		
	
	
	
	public function update_batch($batch_no, $month_no, $remark, $employee_number, $comp_code, $adjustment_amount, $remark_any)
	{
	//echo "in insert";
	if($batch_no!='')
	{
	$count = sizeof($employee_number);
	 for($s=0;$s<$count;$s++)
	{
		if($employee_number[$s]=='select' || $comp_code[$s]=='select' || $adjustment_amount[$s]=='' )
			{
			 echo "Required fields can not be left blank";
			 exit(0); 
			}
	}
	 $date =date('Y/m/d');
	 $sq = "update batch_hdr set month_no='$month_no',remark='$remark',updated_on='$date',updated_by='$_SESSION[txt_login_name]'  where batch_no='$batch_no'"; 
	 
	 $count = sizeof($employee_number);
     for($i=0;$i<$count;$i++)
	  {
	    $sq1 = mysql_query("update batch_dtls set comp_code='$comp_code[$i]', adj_amount='$adjustment_amount[$i]', remark_for_adj='$remark_any[$i]' where batch_no='$batch_no' and employee_no='$employee_number[$i]'");
	  }

	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Batch updated Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}	
	
	
	
	
	public function add_grade($grade, $desc)
	{
	//echo "in insert";
	if($grade!='')
	{
	$sq_duplicate = mysql_query("select * from grade_master where grade='$grade'");
	if($r_duplicate = mysql_fetch_assoc($sq_duplicate))
	{
	  echo "Grade you have entered already exists..";
	  exit(0);
	}
	  $sq = "insert into grade_master values('$grade', '$desc')";
	 $res = $this->query($sq);
	 if(!$res)
	 {
	 $value = FALSE;
	echo "ERROR";
	}
      ELSE
	  {	  
	  echo "Grade Added Successfully!!!";
	   $value = TRUE;
	   RETURN $value;
	  }
	  }
	  else
	  {
	    echo "Required fields can not be left blank";
	  }
	}	
	
	
     public function add_leave($doc_no,$doc_date,$emp_no,$leave_type,$attendance_no,$leave_application_number,$registration_no,$application_date,$designation,$received_date,$from_date,$from_day, $to_date,$to_day,$total_leave,$stock_type,$updated_by,$leave_status,$remark)
	{	
		$date = date('Y-m-d');
				
		$count = mysql_num_rows(mysql_query("select doc_no from leave_management"))+1;
		$code = 'LA'.$count;
		
		mysql_query("insert into leave_management values ('$code','$doc_date','$emp_no','$leave_type','$attendance_no','$leave_application_number','$registration_no', '$application_date','$designation','$received_date', '$from_date','$from_day','$to_date','$to_day','$total_leave','$stock_type','$updated_by','$leave_status','$remark')");
		
		$res_current_leaves = mysql_fetch_assoc(mysql_query("select leavedays_onhand from balanced_leaves where employee_no='$emp_no' and leave_short_code='$leave_type'"));
		$bal_leaves =  $res_current_leaves['leavedays_onhand'] - $total_leave;
		//echo ' - '.$bal_leaves.' - '.$res_current_leaves['leavedays_onhand'].' - '.$total_leave;
		mysql_query("update balanced_leaves set leavedays_onhand='$bal_leaves', last_issue_date='$date' where employee_no='$emp_no' and leave_short_code='$leave_type'");
		
		$days = $this-> getDatesBetween2Dates($from_date, $to_date);
		//echo $total_leave;
		
		$count = 0;
		
		foreach($days as $key => $value)
		{		
			//echo "date ".$days;
			
			if ( $days[$count] == $from_date &&  $from_day =='Half Day' )
			{
				mysql_query("insert into leaves_transaction values ('','$date','$days[$count]','$emp_no','$leave_type','LA','0.5','$code')");		
			}
			else if ($days[$count] == $to_date &&  $to_day == 'Half Day')
			{
				mysql_query("insert into leaves_transaction values ('','$date','$days[$count]','$emp_no','$leave_type','LA','0.5','$code')");
			}
			else
			{
				mysql_query("insert into leaves_transaction values ('','$date','$days[$count]','$emp_no','$leave_type','LA','1','$code')");
			}
			
		$count++;
		}
		
		echo "Leave Added Successfully!!!";
		
		mysql_close($this->db);
	}	
	
	public function getDatesBetween2Dates($startTime, $endTime) 
	{
		$day = 86400;
		$format = 'Y-m-d';
		$startTime = strtotime($startTime);
		$endTime = strtotime($endTime);
		$numDays = round(($endTime - $startTime) / $day) + 1;
		$days = array();
			
		for ($i = 0; $i < $numDays; $i++) {
			$days[] = date($format, ($startTime + ($i * $day)));
		}
			
		return $days;
	}
	
	public function update_leave($emp_no,$attendance_no,$leave_application_number, $registration_no, $application_date, $designation, $from_date, $to_date, $month,$total_leave, $cl,$fl,$el,$ml,$sp,$unpaid_leaves,$absent_days,$remark)
	{	
		$date = date('Y-m-d');
		$sq = mysql_query("update leave_management set total_leaves = '$total_leave', cl = '$cl', fl = '$fl',el = '$el', ml = '$ml', sp = '$sp', unpaid_leave = '$unpaid_leaves', absent_days = '$absent_days', remark = '$remark' where leave_application_no='$leave_application_number'");		
		if(!$sq)
		{
			echo "Error";
		}
		else
		{
			echo "Leave Updated Successfully!!!";
		}		
		mysql_close($this->db);		
	}	
	
	
	
	
	public function cancel_leave($attendance_no,$leave_application_number, $registration_no, $emp_no, $application_date, $designation, $from_date, $to_date, $leave_status, $total_leav)
	{	
	
	   	$date = date('Y-m-d');
		$sq = mysql_query("update leave_management set leave_status = '$leave_status' where leave_application_no='$leave_application_number'");	
		
	
			$short_code = mysql_fetch_assoc(mysql_query("select leave_short_code from leave_management where leave_application_no='$leave_application_number'"));
			
					
			$res_leavedays = mysql_fetch_assoc(mysql_query("select leavedays_onhand from balanced_leaves where employee_no='$emp_no' and leave_short_code='$short_code[leave_short_code]'"));
			// $res_leavedays = mysql_fetch_assoc(mysql_query("select leavedays_onhand from balanced_leaves where employee_no='1' and leave_short_code='cl'"));
			
			$res_leavedays_trans = mysql_fetch_assoc(mysql_query("select leave_days from leaves_transaction where employee_no='$emp_no' and leave_short_code='$short_code[leave_short_code]' and trans_type='LA'"));
			
			$tot_days =  mysql_fetch_assoc(mysql_query("select total_days from leave_management where leave_application_no='$leave_application_number'"));
	        
			
			$deposit = $res_leavedays['leavedays_onhand'] + $tot_days['total_days'];
		    
			//$addleves = $res_leavedays_trans['leave_days'] + $tot_days['total_days'];
			
			$addleves = $tot_days['total_days'];
		
		mysql_query("update balanced_leaves set leavedays_onhand='$deposit' where employee_no='$emp_no' and leave_short_code='$short_code[leave_short_code]'");
		
		//mysql_query("insert into  leaves_transaction values(leave_days='$addleves' employee_no='$emp_no' and leave_short_code='$short_code[leave_short_code]')");
		$days = $this-> getDatesBetween2Dates($from_date, $to_date);
		$count = 0;
		foreach($days as $key => $value)
		{	
		
		if($total_leav>=1){
			$a = 1;
			}
			else{
			$a = 0.5;
			}
		mysql_query("insert into leaves_transaction values ('','$date','$application_date','$emp_no','$short_code[leave_short_code]','LC','$a','$leave_application_number')");
		//insert into leaves_transaction values ('','2014-07-07','','1','cl','LA','1','1')	
		$total_leav = $total_leav - 1;
			$count++;
		}
			
		if(!$sq)
		{
			echo "Error";
		}
		else
		{
		   $_SESSION['flag']=="false";
			echo "Leave Cancelled Successfully!!!";
		}		
		mysql_close($this->db);		
		
	}	
	
	
	
	
	
	
	
	
	
	
	
public function add_leave_attendance($emp_no,$month, $no_day_month, $week_off, $working_days, $present_days, $paid_days, $unpaid_days,$absent_days, $suspen_days,$encashment_days,$remark)
{	
	
		date_default_timezone_set('Asia/Calcutta');
		$date = date('Y-m-d H:i:s A');
		
		/*list($year,$month) = preg_split('[-]', $month);
		$pre_month = $month - 1;
		$prev_date = "$year-$pre_month-26";
		$curr_date = "$year-$month-27";*/
		//date(
		$size = sizeof($emp_no);
		$count = mysql_num_rows(mysql_query("select employee_no from month_attendance"))+1;
		$sq ='';
		$check = 0;
		for($i=0;$i<$size;$i++)
		{		
				list($year,$month1) = preg_split('[-]', $month[$i]);
				//$pre_month = $month1 - 1;
				if ($month1 > 1)
				{
					 $pre_month = $month1 - 1;
					 //$year1 = $year-1;
					 //echo "  ".$year1 . "<br>";
					 //echo " ".$pre_month."<br>";
				}
				else
				{
					$pre_month = 12;
					$year = $year-1;
				}
				//$prev_date = "$year-$pre_month-26";
				if ($pre_month <10)
				{
					$prev_date = "$year-0$pre_month-26";
				}
				else
				{
					$prev_date = "$year-$pre_month-26";
     			}
				
				//echo "model month1 ".$month1;
				//echo "model prev date ".$prev_date;
				if($present_days[$i] == ($working_days[$i] - $paid_days[$i] - $unpaid_days[$i]-$absent_days[$i]-$suspen_days[$i]) && ($working_days[$i] == $no_day_month[$i]-$week_off[$i]) )
				{
					$curr_date = "$year-$month1-25";
				  
				  $check = mysql_num_rows(mysql_query("select employee_no from month_attendance where employee_no='$emp_no[$i]' and month='$month[$i]'"));
				  
				  if($check == 1)
				  {
					mysql_query("delete from month_attendance where employee_no='$emp_no[$i]' and month='$month[$i]'");
					//echo "Deleted Existing record"."\\n";
					//$count--;
				  }
				  $sq = mysql_query("insert into month_attendance values ('$count','$emp_no[$i]','$month[$i]','$prev_date','$curr_date',' $no_day_month[$i]',' $week_off[$i]',' $working_days[$i]',' $present_days[$i]',' $paid_days[$i]',' $unpaid_days[$i]','$absent_days[$i]','$suspen_days[$i]','$encashment_days[$i]','$remark[$i]','$date','$_SESSION[txt_login_name]')");			  
				  //echo "\\nAdded New record"."\\n";
			   $count++;
			   }
			   else
			   {
			   $sq_emp = mysql_query("select * from empl_master where employee_no = ".$emp_no[$i]);
               while($r_emp = mysql_fetch_assoc($sq_emp))
               {
                  $trimmed_first_name = explode(" ", $r_emp['first_name']);
                  echo " Atendance not added for employee no "."$emp_no[$i] $r_emp[last_name] $trimmed_first_name[1] $r_emp[middle_name]  ";
               }
				echo "  -Please click 'Update Employee attendance' and update attendance for these employees";
    			//echo "Check if following calcualtions are corect";
				//echo "\\n (Present Days = Working days - Present Days -Paid Leaves - Unpaid Leaves - Absent Days - Suspension Days)".PHP_EOL."\r\n";
				//echo "Working days = Days in Month - Weekly Off"."\r\n";
				//echo "\\n Atendance not added for employee".$emp_no[$i]."\r\n";
			   }
		}
		
		if(!$sq)
		{
			echo "Error";
		}
		else
		{
			echo "Attendance Added Successfully!!!";
		}
		
		mysql_close($this->db);		
	}

	public function update_leave_attendance($emp_no,$month, $no_day_month, $week_off, $working_days, $present_days, $paid_days, $unpaid_days,$absent_days, $suspen_days,$encashment_days,$remark)
{	
	
		date_default_timezone_set('Asia/Calcutta');
		$date = date('Y-m-d H:i:s A');
		
		/*list($year,$month) = preg_split('[-]', $month);
		$pre_month = $month - 1;
		$prev_date = "$year-$pre_month-26";
		$curr_date = "$year-$month-27";*/
		//date(
		$size = sizeof($emp_no);
		$count = mysql_num_rows(mysql_query("select employee_no from month_attendance"))+1;
		$sq ='';
		$check = 0;
		for($i=0;$i<$size;$i++)
		{		
				list($year,$month1) = preg_split('[-]', $month[$i]);
				//$pre_month = $month1 - 1;
				if ($month1 > 1)
				{
					 $pre_month = $month1 - 1;
					 //$year1 = $year-1;
					 //echo "  ".$year1 . "<br>";
					 //echo " ".$pre_month."<br>";
				}
				else
				{
					$pre_month = 12;
					$year = $year-1;
				}
				//$prev_date = "$year-$pre_month-26";
				if ($pre_month <10)
				{
					$prev_date = "$year-0$pre_month-26";
				}
				else
				{
					$prev_date = "$year-$pre_month-26";
     			}
				
				//echo "model month1 ".$month1;
				//echo "model prev date ".$prev_date;
				if(($present_days[$i] == ($working_days[$i] - ($paid_days[$i] + $unpaid_days[$i]+$absent_days[$i]+$suspen_days[$i])) ) && ($working_days[$i] == $no_day_month[$i]-$week_off[$i]) )
				{
					$curr_date = "$year-$month1-25";
				  
				  $check = mysql_num_rows(mysql_query("select employee_no from month_attendance where employee_no='$emp_no[$i]' and month='$month[$i]'"));
				  
				  if($check == 1)
				  {
					mysql_query("delete from month_attendance where employee_no='$emp_no[$i]' and month='$month[$i]'");
					//echo "Deleted Existing record"."\\n";
					//$count--;
				  }
				  $sq = mysql_query("insert into month_attendance values ('$count','$emp_no[$i]','$month[$i]','$prev_date','$curr_date',' $no_day_month[$i]',' $week_off[$i]',' $working_days[$i]',' $present_days[$i]',' $paid_days[$i]',' $unpaid_days[$i]','$absent_days[$i]','$suspen_days[$i]','$encashment_days[$i]','$remark[$i]','$date','$_SESSION[txt_login_name]')");			  
				  //echo "\\nAdded New record"."\\n";
			   $count++;
			   }
			   else
			   {
			   $sq_emp = mysql_query("select * from empl_master where employee_no = ".$emp_no[$i]);
               while($r_emp = mysql_fetch_assoc($sq_emp))
               {
                  $trimmed_first_name = explode(" ", $r_emp['first_name']);
                  echo " Atendance not added for employee no "."$emp_no[$i] $r_emp[last_name] $trimmed_first_name[1] $r_emp[middle_name]";
               }

				//echo "\\nAtendance not updated for employee no ".$emp_no[$i];
				//echo "\\n Check if following calcualtions are corect";
				//echo "\\n Present Days = Working days - Paid Leaves - Unpaid Leaves - Absent Days - Suspension Days)";
				//echo "\\n Working days = Days in Month - Weekly Off";
				//echo "\\n Atendance not updated for employee".$emp_no[$i];
			   }
		}
		
		if(!$sq)
		{
			echo "Error";
		}
		else
		{
			echo "Attendance Updated Successfully!!!";
		}
		
		mysql_close($this->db);		
	}
	
	//public function add_leave_transfer_type($employee_name,$transfer_from, $leaves_transfer, $transfer_to,$current_cl,$current_fl, $current_el,$current_ml,$current_sp,$current_total_leaves,$created_date)
	public function add_leave_transfer_type($employee_name,$transfer_from, $leaves_transfer, $transfer_to,$leaveArray,$currentLeaveCodeArray, $current_total_leaves,$created_date)
	{	
		    $count = mysql_num_rows(mysql_query("select trans_no from leaves_transaction"))+1;
			
		    $res_deposit = mysql_fetch_assoc(mysql_query("select leavedays_onhand from balanced_leaves where employee_no='$employee_name' and leave_short_code='$transfer_to'"));
			$res_withdrow = mysql_fetch_assoc(mysql_query("select leavedays_onhand from balanced_leaves where employee_no='$employee_name' and leave_short_code='$transfer_from'"));
			$deposit = $res_deposit['leavedays_onhand'] + $leaves_transfer ;
			$withdrow = $res_withdrow['leavedays_onhand'] - $leaves_transfer ;
			$date = date('Y-m-d');
			mysql_query("update balanced_leaves set leavedays_onhand='$deposit', last_receipt_date='$date' where employee_no='$employee_name' and leave_short_code='$transfer_to'");
			mysql_query("update balanced_leaves set leavedays_onhand='$withdrow', last_issue_date='$date' where employee_no='$employee_name' and leave_short_code='$transfer_from'");
			
			mysql_query("insert into leaves_transaction values ('','$created_date','','$employee_name','$transfer_to','Conv-LA','$leaves_transfer','')");
			mysql_query("insert into leaves_transaction values ('','$created_date','','$employee_name','$transfer_from','Conv-LA','-$leaves_transfer','')");
			//echo "add ".$deposit;
			//echo "sub ".$withdrow;
			//echo "update balanced_leaves set leavedays_onhand='$deposit' where employee_no='$employee_name' and leave_short_code='$transfer_to'";
			//echo "update balanced_leaves set leavedays_onhand='$withdrow' where employee_no='$employee_name' and leave_short_code='$transfer_from'";
        for($i=0;$i<sizeof($leaveArray);$i++)
		{		
			mysql_query("insert into leaves_transfer values ('$employee_name','$transfer_from','$leaves_transfer','$transfer_to','$currentLeaveCodeArray[$i]','$leaveArray[$i]','$created_date')");			
		}
		
		
	  echo "Leave Transfered Successfully!!!";
		
		
		mysql_close($this->db);		
	}
	
	
	//public function add_employee_leaves($emp_no,$clArray, $flArray, $elArray,$mlArray,$spArray, $paid_leaves,$unpaid_leaves)
	public function add_employee_leaves($emp_no,$leaveArray,$leaveCodeArray,$count_type)	
	{	
		$date = date('Y-m-d');		
		$size = sizeof($emp_no);
		$leaves_count = $count_type;
		//print_r($leaveArray);
		//echo $leaves_count ;
		//$count = mysql_num_rows(mysql_query("select employee_no from balanced_leaves"))+1;
				
		/*for($i=0;$i<$size;$i++)
		{	
			
			for($a=0;$a<$leaves_count;$a++)
			{	
		  		 mysql_query("insert into balanced_leaves values ('$emp_no[$i]','$leaveCodeArray[$a]','$leaveArray[$a]','','','$_SESSION[txt_login_name]','$date')");
			}
		   $count++;
		}*/
		
		$temp = 0;
		for($i=0;$i<$size;$i++)
		{
		   $sq_leaves_exists = mysql_query("select * from balanced_leaves where employee_no='$emp_no[$i]'");
	  
		   if(mysql_num_rows($sq_leaves_exists))

		   {	$a = $leaves_count * $i;
      		    //echo "$a Before loop value ". $a ."\\n";
		        $Leave_array_Size =   $leaves_count * ($i+1);
				//echo "Leave_array_Size ---- ". $Leave_array_Size ."\\n";
		   		//for($a=0;$a<$leaves_count;$a++)
				for($a;$a<$Leave_array_Size;$a++)	
				{	
					if($leaveArray[$a]>0)
					{
					$res_leaves_exists = mysql_fetch_assoc(mysql_query("select * from balanced_leaves where employee_no='$emp_no[$i]' and leave_short_code='$leaveCodeArray[$a]'"));					
					$temp =	$res_leaves_exists['leavedays_onhand'] + $leaveArray[$a];
					
					mysql_query("update balanced_leaves set leavedays_onhand='$temp',last_receipt_date='$date' where employee_no='$emp_no[$i]' and leave_short_code='$leaveCodeArray[$a]'");
					mysql_query("insert into leaves_transaction values ('','$date','$date','$emp_no[$i]','$leaveCodeArray[$a]','LD','$leaveArray[$a]','')");
					$count = mysql_num_rows(mysql_query("select doc_no from leave_management"))+1;
					$code = 'LD'.$count;
					mysql_query("insert into leave_management values ('$code','$date','$emp_no[$i]','$leaveCodeArray[$a]','','','','','','','','','','','$leaveArray[$a]','LD','$_SESSION[txt_login_name]','','')");					
					}
				}			
			}
			else
			{
				$a = $leaves_count * $i;
      		    //echo "$a Before loop value ". $a ."\\n";
		        $Leave_array_Size =   $leaves_count * ($i+1);
				//echo "Leave_array_Size ---- ". $Leave_array_Size ."\\n";
		   		//for($a=0;$a<$leaves_count;$a++)
				for($a;$a<$Leave_array_Size;$a++)	
				{	
					if($leaveArray[$a]>0)
					{
					 mysql_query("insert into balanced_leaves values ('$emp_no[$i]','$leaveCodeArray[$a]','$leaveArray[$a]','','','$_SESSION[txt_login_name]','$date')");
					 mysql_query("insert into leaves_transaction values ('','$date','$date','$emp_no[$i]','$leaveCodeArray[$a]','LD','$leaveArray[$a]','')");
					 $count = mysql_num_rows(mysql_query("select doc_no from leave_management"))+1;
					 $code = 'LD'.$count;
					 mysql_query("insert into leave_management values ('$code','$date','$emp_no[$i]','$leaveCodeArray[$a]','','','','','','','','','','','$leaveArray[$a]','LD','$_SESSION[txt_login_name]','','')");					
					}				
				}			
			}
		}
		
		echo "Leave Added Successfully!!!";
		
		mysql_close($this->db);		
	}
	
	
	
	
	public function remove_employee_leaves($emp_no,$leaveArray,$leaveCodeArray,$count_type)	
	{	
		$date = date('Y-m-d');		
		$size = sizeof($emp_no);
		$leaves_count = $count_type;
		//print_r($leaveArray);
		//echo $leaves_count ;
		//$count = mysql_num_rows(mysql_query("select employee_no from balanced_leaves"))+1;
				
		/*for($i=0;$i<$size;$i++)
		{	
			
			for($a=0;$a<$leaves_count;$a++)
			{	
		  		 mysql_query("insert into balanced_leaves values ('$emp_no[$i]','$leaveCodeArray[$a]','$leaveArray[$a]','','','$_SESSION[txt_login_name]','$date')");
			}
		   $count++;
		}*/
		
		$temp = 0;
		for($i=0;$i<$size;$i++)
		{
		   $sq_leaves_exists = mysql_query("select * from balanced_leaves where employee_no='$emp_no[$i]'");
	  
		   if(mysql_num_rows($sq_leaves_exists))

		   {	$a = $leaves_count * $i;
      		    //echo "$a Before loop value ". $a ."\\n";
		        $Leave_array_Size =   $leaves_count * ($i+1);
				//echo "Leave_array_Size ---- ". $Leave_array_Size ."\\n";
		   		//for($a=0;$a<$leaves_count;$a++)
				for($a;$a<$Leave_array_Size;$a++)
				{	
				//echo "$a value in Loop". $a ."\\n";
					if($leaveArray[$a]>0)
					{
						$res_leaves_exists = mysql_fetch_assoc(mysql_query("select * from balanced_leaves where employee_no='$emp_no[$i]' and leave_short_code='$leaveCodeArray[$a]'"));					
						$temp =	$res_leaves_exists['leavedays_onhand'] - $leaveArray[$a];
					
						mysql_query("update balanced_leaves set leavedays_onhand='$temp',last_receipt_date='$date' where employee_no='$emp_no[$i]' and leave_short_code='$leaveCodeArray[$a]'");
						mysql_query("insert into leaves_transaction values ('','$date','$date','$emp_no[$i]','$leaveCodeArray[$a]','MD','$leaveArray[$a]','')");
						$count = mysql_num_rows(mysql_query("select doc_no from leave_management"))+1;
						$code = 'MD'.$count;
						mysql_query("insert into leave_management values ('$code','$date','$emp_no[$i]','$leaveCodeArray[$a]','','','','','','','','','','','$leaveArray[$a]','MD','$_SESSION[txt_login_name]','','')");					
					}
				}			
			}
			else
			{
    			$a = $leaves_count * $i;
      		    //echo "$a Before loop value ". $a ."\\n";
		        $Leave_array_Size =   $leaves_count * ($i+1);
				//echo "Leave_array_Size ---- ". $Leave_array_Size ."\\n";
				//for($a=0;$a<$leaves_count;$a++)
				for($a;$a<$Leave_array_Size;$a++)
				{	
					if($leaveArray[$a]>0)
					{
					 mysql_query("insert into balanced_leaves values ('$emp_no[$i]','$leaveCodeArray[$a]','$leaveArray[$a]','','','$_SESSION[txt_login_name]','$date')");
					 mysql_query("insert into leaves_transaction values ('','$date','$date','$emp_no[$i]','$leaveCodeArray[$a]','MD','$leaveArray[$a]','')");
					 $count = mysql_num_rows(mysql_query("select doc_no from leave_management"))+1;
					 $code = 'MD'.$count;
					 mysql_query("insert into leave_management values ('$code','$date','$emp_no[$i]','$leaveCodeArray[$a]','','','','','','','','','','','$leaveArray[$a]','MD','$_SESSION[txt_login_name]','','')");					
					}
				}			
			}
		}
		
		echo "Leaves Removed Successfully!!!";
		
		mysql_close($this->db);		
	}
	
	
	
	
	
	
	
	public function add_leave_encashment_form($emp_no,$currentelArray,$balancedelArray,$totalelArray)	
	{	
		$date = date('Y-m-d');	
		$from_year= date('Y')-1;
		$to_year=date('Y');	
		$size = sizeof($emp_no);
	    $from_date='2014-03-31';
		$to_date='2015-04-01';
		$count =0;
		$trans_no = 0;
		for($i=0;$i<$size;$i++)
		{		
		$count = mysql_num_rows(mysql_query("select encash_id from leave_encashment"))+1;
		$id1 = 'LE'.$count;
		$trans_no = mysql_num_rows(mysql_query("select trans_no from leaves_transaction"))+1;
		
		$el_current = mysql_fetch_assoc(mysql_query("select leavedays_onhand from balanced_leaves where employee_no='$emp_no[$i]' and leave_short_code='el'"));
		
		$el_encash = $el_current['leavedays_onhand']-$totalelArray[$i];
		
		mysql_query("update balanced_leaves set leavedays_onhand ='$el_encash' where (employee_no='$emp_no[$i]' and leave_short_code='el') and (updated_date between '2014-03-31' and '2015-04-01')");
		//mysql_query("update balanced_leaves set leavedays_onhand ='$el_encash' where (employee_no='$emp_no[$i]' and leave_short_code='el') and (updated_date between '$from_year-03-31' and '$to_year-04-01')");		

		
		mysql_query("insert into leave_encashment values ('$id1','$emp_no[$i]','$currentelArray[$i]','$balancedelArray[$i]','$totalelArray[$i]','$from_date','$to_date','$_SESSION[txt_login_name]','$date')");
		
		mysql_query("insert into leaves_transaction values ('$trans_no','$date','','$emp_no[$i]','el','LE','$totalelArray[$i]','$id1')");


		
        $count++;
		}
		
		echo "Leave encashed Successfully!!!";
		
		mysql_close($this->db);	
	}
	
		
}
?>
 	
	
		

 
		





 

 
