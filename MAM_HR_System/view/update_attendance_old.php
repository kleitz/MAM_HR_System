﻿<?php include('../model/Model.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
<script src="../calendar/src/js/jscal2.js"></script>
    <script src="../calendar/src/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="../calendar/src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="../calendar/src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="../calendar/src/css/steel/steel.css" />


    <!--
    Created by Artisteer v2.3.0.23326
    Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
    -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title><?php echo $_SESSION['company_name']; ?></title>

    <script type="text/javascript" src="../script.js"></script>
    <script type="text/javascript" src="stmenu.js"></script>
    <link rel="stylesheet" href="../style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" /><![endif]-->
	<script type="text/javascript">
	function loadFile() {
	// Retrieve the FileList object from the referenced element ID
	var myFileList = document.getElementById('upload_file').files;
 
	// Grab the first File Object from the FileList
	var myFile = myFileList[0];
 
	// Set some variables containing the three attributes of the file
	var myFileName = myFile.name;
	var myFileSize = myFile.size;
	var myFileType = myFile.type;
 
	// Alert the information we just gathered
	alert("FileName: " + myFileName + "- FileSize: " + myFileSize + " - FileType: " + myFileType);
 
	// Let's upload the complete file object
	uploadFile(myFile);
}

function uploadFile(myFileObject) {
	// Open Our formData Object
	var formData = new FormData();
 
	// Append our file to the formData object
	// Notice the first argument "file" and keep it in mind
	formData.append('my_uploaded_file', myFileObject);

	// Create our XMLHttpRequest Object
	var xhr = new XMLHttpRequest();
 
	// Open our connection using the POST method
	xhr.open("POST", '../controller/upload_file.php');

	// Send the file
	xhr.send(formData);
}

//////////////////////////////////////////////////////////////////////////table Attendance///////////
 function foo() {

    if( typeof foo.counter == 'undefined' ) {
        foo.counter = 1;
    }
    foo.counter++;
	var table = document.getElementById('empcomptable');
 
            var rowCount = table.rows.length;
			
	for(var i=0; i<rowCount; i++)
	{
		var row = table.rows[i];
	}
	
	row.cells[3].childNodes[0].setAttribute("id", foo.counter);
	row.cells[2].childNodes[0].setAttribute("id", "txt_comp_change_eff_date"+foo.counter);
	}
	
	
        function addRow1(tableID) {
 
            var table = document.getElementById(tableID);
 
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);
 
            var colCount = table.rows[0].cells.length;
 
            for(var i=0; i<colCount; i++) {
 
                var newcell = row.insertCell(i);
 
                newcell.innerHTML = table.rows[0].cells[i].innerHTML;
                //alert(newcell.childNodes);
                switch(newcell.childNodes[0].type) {
                    case "text":
                            newcell.childNodes[0].value = "";
                            break;
                    case "checkbox":
                            newcell.childNodes[0].checked = false;
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            break;
                }
            }foo();
        }
 
        function deleteRow1(tableID) {
            try {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
 
            for(var i=0; i<rowCount; i++) {
                var row = table.rows[i];
                var chkbox = row.cells[0].childNodes[0];
                if(null != chkbox && true == chkbox.checked) {
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
 
            }
            }catch(e) {
                alert(e);
            }
        }
 

function showrecvtitle(str)
{

if (str=="")
{
alert(str);
document.getElementById("txtHint").innerHTML="";
return;
}
if (window.XMLHttpRequest)
{// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
}
else
{// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function()
{
if (xmlhttp.readyState==4 && xmlhttp.status==200)
{
var myTable = document.getElementById('tbltitle');
var tBody = myTable.getElementsByTagName('tbody')[0];
tBody.innerHTML = xmlhttp.responseText;
}
}
xmlhttp.open("GET","showtitle.php?id="+str,true);


xmlhttp.send();
}



/*function validatedays()
{
 var no_of_days = document.getElementById('txt_no_days').value;
 var btn_update = document.getElementById('btn_update_attendance');
 
 var table = document.getElementById('attendancetable');
 var rowCount = table.rows.length;
				
		for(var i=0; i<rowCount; i++) {
             var row = table.rows[i];
			 var working_days = row.cells[3].childNodes[0].value;	
			 var holidays = row.cells[4].childNodes[0].value;
			 var paid_leaves = row.cells[5].childNodes[0].value;
			 var unpaid_leaves = row.cells[6].childNodes[0].value;
			 
			 var total = parseFloat(working_days) + parseFloat(holidays) + parseFloat(paid_leaves) + parseFloat(unpaid_leaves);
			 if(parseFloat(total) != parseFloat(no_of_days))
			 {
			   alert("Wrong Days Entered at Row "+(i+1));
			   btn_update.disabled = true;
			   return false;
			 }
			 else
			 {
			   btn_update.disabled = false;
			 }
		}
}*/

	</script>

</head>
<body>
<div id="art-page-background-simple-gradient">
    </div>
    <div id="art-main">
        <div class="art-Sheet">
            <div class="art-Sheet-tl"></div>
            <div class="art-Sheet-tr"></div>
            <div class="art-Sheet-bl"></div>
            <div class="art-Sheet-br"></div>
            <div class="art-Sheet-tc"></div>
            <div class="art-Sheet-bc"></div>
            <div class="art-Sheet-cl"></div>
            <div class="art-Sheet-cr"></div>
            <div class="art-Sheet-cc"></div>
            <div class="art-Sheet-body">
                <div class="art-Header">
                    <div class="art-Header-png"></div>
                    <div class="art-Header-jpeg"></div>
                    <div class="art-Logo">
					<table><tr><td width="250"><img src="../images/rssIcon1.png"  /></td>
					<td>
                        <h1 id="name-text" class="art-Logo-name"><?php echo $_SESSION['txt_name'];
												  ?></td></tr></table>
                        <!--<div id="slogan-text" class="art-Logo-text">Slogan text</div> -->
						<form name="frm_logout" id="frm_logout" method="post" action="../index.php">
																	<table><tr><td width="1000" style="text-align:right">
						    
							
							<font face="Times New Roman, Times, serif" size="+1" color="#A7380A">
							<?php
						 
						  
						  echo $_SESSION['txt_login_name'];
						  ?></font> <input type="submit" name="btn_logout" id="btn_logout" value="Logout"  style="background-color:#F3D9A5"/>
						 </td></tr></table>
						 </form>
                    </div>
                </div>
                <div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
					
                	<ul class="art-menu">
                		
<?php if($_SESSION['role']=='Admin')
 {
 ?>
 

<li><a href="personal_info.php"><span class="l"></span><span class="r"></span><span class="t"><font>Home</font></span></a>

<li><a href="comp_head_add.php"><span class="l"></span><span class="r"></span><span class="t"><font>Compensations</font></span></a>
<ul>
<li><a href="comp_head_add.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Compensations</font></span></a></li>
<li><a href="update_comp_select.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Update Compensations</font></span></a></li>
</ul>
</li>


<li><a href="grade_comp_add.php"><span class="l"></span><span class="r"></span><span class="t">Grade Compensations</span></a>
<ul>
<li><a href="grade_add.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Grade</font></span></a></li>

<li><a href="grade_comp_add.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Grade Comp.</font></span></a></li>
<li><a href="update_grade_select.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Update Grade Comp.</font></span></a></li>
</ul>
</li>

<li><a href="month_control_add.php"><span class="l"></span><span class="r"></span><span class="t">Month Control</span></a>
<ul>
<li><a href="month_control_add.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Month Control</font></span></a></li>
<li><a href="update_month_control_select.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Update Month Control</font></span></a></li>
</ul>
</li>

<li><a href="batch_add.php"><span class="l"></span><span class="r"></span><span class="t">Batch</span></a>
<ul>
<li><a href="batch_add.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Batch Details</font></span></a></li>
<li><a href="update_batch_select.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Update Batch Details</font></span></a></li>
</ul>
</li>


<li><a href="payroll_emp_comp.php"><span class="l"></span><span class="r"></span><span class="t">Employee Compensations</span></a>
<ul>
<li><a href="payroll_emp_comp.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Emp Comp</font></span></a>
<ul>
<li><a href="search_for_payroll_update.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Update Emp Comp</font></span></a></li>
</ul>
</li>


<li><a href="add_attendance.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Emp Attendance</font></span></a>
<ul>
    <li><a href="update_attendance_select.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Update Emp Attendance</font></span></a></li>

</ul>
</li>

<li><a href="add_recovery.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Add Recovery</font></span></a>
<ul>
    <li><a href="update_recovery_select.php"><span class="l"></span><span class="r"></span><span class="t"><font color="#000000">Update Recovery</font></span></a></li>

</ul>
</li>
</ul>
</li>

<li><a href="payroll_process.php"><span class="l"></span><span class="r"></span><span class="t">Payroll Process</span></a></li>
<li><a href="reports.php"><span class="l"></span><span class="r"></span><span class="t">Reports</span></a></li>
<li><a href="transfer_employees.php"><span class="l"></span><span class="r"></span><span class="t">Move Employees</span></a></li>



       <?php } ?>    
	   
	         	</ul>
                </div>
                <div class="art-contentLayout">
                    <div class="art-content">
                        <div class="art-Post">
                            <div class="art-Post-body">
                        <div class="art-Post-inner">
                                        <h2 class="art-PostHeader">
                                        
                                        </h2>
                                        <div class="art-PostContent">
										
										
										
<center><table width="940"><tr><td><font face="Courier New, Courier, monospace" size="+1" color="#FF6600"><center>Update Attendance</center></font></td></tr></table>
                                 																
<center>
<table width="940" border="1">
<tr style="display:none;"><td colspan="15">
 <INPUT type="button" value="Add Row" onClick="addRow1('attendancetable')" />
 
  <INPUT type="button" value="Delete Row" onClick="deleteRow1('attendancetable')" /></td></tr>
<tr><td width="155"><b><center>Employee No:<font color="#FF0000">*</font></center></b></td><td width="70"><b><center>Month No <font color="#FF0000">*</font></center></b></td><td width="92"><b>Working Days<font color="#FF0000">*</font></b></td><td width="95"><b>Holidays<font color="#FF0000">*</font></b></td><td width="95"><b>Paid Leaves</b></td><td width="95"><b><center>Unpaid Leaves</center></b></td><td width="93"><b>No of adjustment days, from prev month</b></td><td><b>Overtime in Hours for the month</b></td><td><b>No of Days for leave Encashment</b></td></tr>
</table>
<table width="940" id="attendancetable" border="1">
<?php 
	 $i = 1;
	 $s1 = mysql_query("select * from attendance where month_no='$_POST[cmb_month_no]'");
	 while($row1 = mysql_fetch_assoc($s1))
	 {
	 $s2 = mysql_query("select * from empl_master where employee_no ='$row1[employee_no]'");
	 while($row2 = mysql_fetch_assoc($s2))
	 {
	 $month_active_no = '';
     $sq = mysql_query("select * from month_control where month_active='Y'");
     while($r = mysql_fetch_assoc($sq))
     {
     $month_active_no = $r['month_no'];
	 echo '<input type="text" name="txt_no_days" id="txt_no_days" value="'.$r['no_days'].'" style="display:none;" />';
     }
	 if($row1['month_no']==$month_active_no)
	 {
	 echo '<tr>'.'<td style="display:none";>'.'<input type="text" name="txt_comp_code'.$i.'" disabled="disabled" id="txt_comp_code'.$i.'" value="'.$row1['employee_no'].'" size="8"  />'.'</td>'.'<td width="50">'.'<input type="text" name="txt_comp_code'.$i.'" disabled="disabled" id="txt_comp_code'.$i.'" title="'.$row2['first_name'].' '.$row2['middle_name'].' '.$row2['last_name'].'" value="'.$row2['first_name'].' '.$row2['middle_name'].' '.$row2['last_name'].'" size="20" />'.'</td>'.'<td>'.'<input type="text" name="txt_comp_change_eff_date'.$i.'" id="txt_comp_change_eff_date'.$i.'" value="'.$row1['month_no'].'" size="6" disabled />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['pay_days'].'"   />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['holidays'].'"  />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['paid_leaves'].'" />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['unpaid_leaves'].'"  />'.'</td>'.'<td width="150">'.'<input type="text" name="txt_amount'.$i.'" id="txt_amount'.$i.'" value="'.$row1['adj_days'].'" size="10" />'.'</td>'.'<td>'.'<input type="text" name="txt_amount'.$i.'" id="txt_amount'.$i.'" value="'.$row1['ot_hrs'].'" size="10" />'.'</td>'.'<td>'.'<input type="text" name="txt_amount'.$i.'" id="txt_amount'.$i.'" value="'.$row1['leave_encash_days'].'" size="10" />'.'</td>'.'</tr>';
	 
	 $i = $i + 1;
	 }
	 else
	 {
	 echo '<tr>'.'<td style="display:none";>'.'<input type="text" name="txt_comp_code'.$i.'" disabled="disabled" id="txt_comp_code'.$i.'" value="'.$row1['employee_no'].'" size="8"  />'.'</td>'.'<td width="50">'.'<input type="text" name="txt_comp_code'.$i.'" disabled="disabled" id="txt_comp_code'.$i.'" title="'.$row2['first_name'].' '.$row2['middle_name'].' '.$row2['last_name'].'" value="'.$row2['first_name'].' '.$row2['middle_name'].' '.$row2['last_name'].'" size="20" />'.'</td>'.'<td>'.'<input type="text" name="txt_comp_change_eff_date'.$i.'" id="txt_comp_change_eff_date'.$i.'" value="'.$row1['month_no'].'" size="6" disabled />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['pay_days'].'" disabled="disabled"  />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['holidays'].'" disabled="disabled"  />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['paid_leaves'].'" disabled="disabled"  />'.'</td>'.'<td width="60">'.'<input type="text" name="'.$i.'" id="'.$i.'" size="10" value="'.$row1['unpaid_leaves'].'" disabled="disabled"  />'.'</td>'.'<td width="150">'.'<input type="text" name="txt_amount'.$i.'" id="txt_amount'.$i.'" value="'.$row1['adj_days'].'" size="10" disabled="disabled"/>'.'</td>'.'<td>'.'<input type="text" name="txt_amount'.$i.'" id="txt_amount'.$i.'" value="'.$row1['ot_hrs'].'" size="10" disabled="disabled" />'.'</td>'.'<td>'.'<input type="text" name="txt_amount'.$i.'" id="txt_amount'.$i.'" value="'.$row1['leave_encash_days'].'" size="10" disabled="disabled" />'.'</td>'.'</tr>';
	 
	 $i = $i + 1;
	 }
	 }
	 }
	 ?>
</table>
	 </center>
	
	 	 
<?php 
     $month_active_no = '';
     $sq = mysql_query("select * from month_control where month_active='Y'");
     while($r = mysql_fetch_assoc($sq))
     {
     $month_active_no = $r['month_no'];
     }
	 if($_POST['cmb_month_no']==$month_active_no)
	 {
?>	 
<tr><td colspan="5"><center><input type="button" name="btn_update_attendance" id="btn_update_attendance" value="Update" onclick="update_attendance();" /><input type="reset" name="btn_reset" value="Cancel" /></center></td></tr>
<?php 
     }
	 else
	 {
	 ?>
	<tr><td colspan="5"><center><input type="button" name="btn_update_attendance" id="btn_update_attendance" value="Update" onclick="validatedays();update_attendance();" disabled="disabled" /><input type="reset" name="btn_reset" value="Cancel" disabled="disabled" /></center></td></tr>
	 
	 <?php 
	 }
?>     
      
</form>

</table></center>
<center><div id="error5"></div></center>
<script type="text/javascript" src="../js/ajax.js"></script>
<script type="text/javascript" src="../js/jquery-1.4.js"></script>       
                                            <table class="table" width="100%">
                                            	<tr>
                                            		<td width="33%" valign="top">
                                            		<div class="art-Block">
                                            			<div class="art-Block-body">
                                            				<div class="art-BlockHeader">
                                                      <div class="l"></div>
                                            				  <div class="r"></div>
                                            				  <div class="t"><center></center></div>
                                            			  </div>
                                            				<div class="art-BlockContent">
                                            					<div class="art-PostContent">
                                            						
                                            						
                                            					</div>
                                            				</div>
                                            			</div>
                                            		</div>
                                            		</td>
                                            		<td width="33%" valign="top">
                                            		<div class="art-Block">
                                            			<div class="art-Block-body">
                                            				<div class="art-BlockHeader">
                                                      <div class="l"></div>
                                            				  <div class="r"></div>
                                            				  <div class="t"><center></center></div>
                                            			  </div>
                                            				<div class="art-BlockContent">
                                            					<div class="art-PostContent">
                                            						
                                            					</div>
                                            				</div>
                                            			</div>
                                            		</div>
                                            		</td>
                                            		<td width="33%" valign="top">
                                            		<div class="art-Block">
                                            			<div class="art-Block-body">
                                                    <div class="art-BlockHeader">
                                                      <div class="l"></div>
                                            				  <div class="r"></div>
                                            				  <div class="t"><center></center></div>
                                            			  </div>
                                            				<div class="art-BlockContent">
                                            					<div class="art-PostContent">
                                            						
                                            					</div>
                                            				</div>
                                            			</div>
                                            		</div>
                                            		</td>
                                            	</tr>
                                            </table>
                                                
                                        </div>
                                        <div class="cleared"></div>
                        </div>
                        
                        		<div class="cleared"></div>
                            </div>
                        </div>
                        <div class="art-Post">
                            <div class="art-Post-body">
                        <div class="art-Post-inner">
                                        <h2 class="art-PostHeader">
                                            
                                        </h2>
                                        <div class="art-PostContent">
                                            
                                            
                                             
                                                    
                                              
                                            	
                                                
                                        </div>
                                        <div class="cleared"></div>
                        </div>
                        
                        		<div class="cleared"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cleared"></div><div class="art-Footer">
                    <div class="art-Footer-inner">
                        <a href="#" class="art-rss-tag-icon" title="RSS"></a>
                        <div class="art-Footer-text">
                            <br />
                           <p class="art-page-footer">Copyright © 2011-12. All Rights Reserved. Designed & Maintained By<a href="http://www.adikul.com/" target="_blank">&nbsp;Aaditya Software Solutions</a> </p>
                        </div>
                    </div>
                    <div class="art-Footer-background"></div>
                </div>
        		<div class="cleared"></div>
            </div>
        </div>
        <div class="cleared"></div>

    </div>
    
</body>
</html>
