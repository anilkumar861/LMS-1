<?php
session_start();
require_once 'Library.php';
$db=connectToDB();
?>
<html>
<head>
<script type="text/javascript">
$("document").ready(function() {
	$(".radio").css("width","20px");
	$('#detailed_form').submit(function() { 
	    $.ajax({ 
	        data: $(this).serialize(),
	        type: $(this).attr('method'), 
	        url: $(this).attr('action'), 
	        success: function(response) { 
	            $('#loadhrsection').html(response);
	        }
			});
			return false; 
	});
	$('#applyLeaveForTeam').submit(function() { 
	    $.ajax({ 
	        data: $(this).serialize(),
	        type: $(this).attr('method'), 
	        url: $(this).attr('action'), 
	        success: function(response) { 
	            $('#loadhrsection').html(response);
	        }
			});
			return false; 
	});
	$('#applyLeaveForTeamConfirmation').submit(function() { 
			$('#loadingmessage').show();
			$("#applyLeaveForTeamConfirmationSubmit").hide();
		    $.ajax({ 
		        data: $(this).serialize(),
		        type: $(this).attr('method'), 
		        url: $(this).attr('action'), 
		        success: function(response) { 
		        	$('#loadingmessage').hide();
		            $('#loadhrsection').html(response);
		        }
				});
				return false; 
    });
	$("#inoutdetails").click(function(){
		$("#loadhrsection").load('Employeeinoutdetails.php?inoutdetails=1');
	});
	$("#Allinoutdetails").click(function(){
                $("#loadhrsection").load('Employeeinoutdetails.php?Allinoutdetails=1');
        });
	$("#brief").click(function(){
		$("#loadhrsection").load('hr.php?briefreport=1');
	});
	$("#detailed").click(function(){
		$("#loadhrsection").load('hr.php?detailedreport=1');
	});
	
	$("#new_emp").click(function(){
		$("#loadhrsection").load('newuser.php?userlinks=1');
	});
	$("#hrmodifyempapprovedleaves").click(function(){
		$("#loadhrsection").load('modifyempapprovedleaves.php?role=hr');
	});
	$("#hronbehalfempapply").click(function(){
		$("#loadhrsection").load('hrapplyleaveforall.php?getEmp=1');
	});
	$("#addextrawfh").click(function(){
		
		$("#loadhrsection").load('wfhhours/manageraddwfhforemp.php?role=hr');
	});
	$("#viewextrawfh").click(function(){
		$("#loadhrsection").load('wfhhours/managerviewwfhform.php?role=hr&viewform=1');
	});
	//$("#modifyextrawfhHR").click(function() {
	    // hidealldiv('loadhrsection');
		   //  $("#loadhrsection").load('wfhhours/modifyExtrawfhhour.php?role=hr');
		//});
	$("#approveextrawfhHR").click(function() {
	     hidealldiv('loadhrsection');
		     $("#loadhrsection").load('wfhhours/approveEmpExtrawfhhour.php?role=hr&approveview=1');
		});
	$("#hrApproveEmpLeave").click(function() {
		$("#loadhrsection").load('approveEmpLeave.php?role=hr');
	});
	$("#applyspl").click(function(){
		$("#loadhrsection").load('hr.php?applyspl=1');
	});
	$("#applyforteam").click(function(){
		$("#loadhrsection").load('hr.php?applyforteam=1');
	});
	$("#reApply").click(function(){
		$("#loadhrsection").load('hr.php?applyspl=1');
	});
	$("#viewbalanceleaves").click(function(){
		$("#loadhrsection").load('hr.php?viewbalanceleaves=1');
	});
	$("#empList").change(function(){
		if($("#empList").val()=="Choose") {
			$("#empidRow").hide();
			$("#trfromdate").hide();
			$("#trtodate").hide();
			$("#trleavetype").hide();
			$("#option").hide();
			$("#defaultdays").hide();
			$("#reason").hide();
			$("#splsubmit").hide();
		} else {
			$("#employeeid").val($("#empList").val());
			$("#empidRow").show();
			$("#trfromdate").show();
			$("#trtodate").show();
			$("#trleavetype").show();
		}
	});
	$("#noofdays").spinner(
			{ min: 0 },
			{ max: 100 }
	);
	$("#splleave").change(function(){
		if($("#splleave").val()=="Choose") {
			$("#defaultdays").hide();
			$("#option").hide();
			$("#reason").hide();
			$("#splsubmit").hide();
		} else {
			$("#option").show();
			$("#option input").width(25)
			$("#defaultdays").show();
			$("#reason").show();
			$("#splsubmit").show();
			$("#splleavename").val($("#splleave option:selected").html());
			val=$("#splleave").val().split(" ")[0];
			sel=$("#splleave").val().split(" ")[1];
			if (sel.match(/DAY/gi)) {
				$("#noofdays").spinner("value", val);
				$("#days").prop("checked",true);
				$("#labeloption").html(sel);
			}
			if (sel.match(/WEEK/gi)) {
				$("#noofdays").spinner("value", val);
				$("#weeks").prop("checked",true)
				$("#labeloption").html(sel);
			}
		}
	});
	$('input[name=selectoption]:radio').change(function(){
		$("#labeloption").html($('input[name=selectoption]:radio:checked').val());
	});

  	$("#applysplLeave").validate({
  	    rules: {
  	    	employeeid: "required",
  	    	fromDate: "required"
  	    },
  	    messages: {
  	    	employeeid: "Pleasse choose Employee",
  	    	fromDate: "Please specify From Date"
  	    },
  	    submitHandler: function() {
  			$.ajax({ 
	        data: $('#applysplLeave').serialize(), 
	        type: $('#applysplLeave').attr('method'), 
	        url:  $('#applysplLeave').attr('action'), 
	        success: function(response) { 
	            $('#loadhrsection').html(response); 
	        }
			});
			return false;
  	  }
  	  });
  	$("#confirmSplLeave").submit(function() {
	    $.ajax({
	        data: $(this).serialize(),
	        type: $(this).attr('method'), 
	        url: $(this).attr('action'), 
	        success: function(response) { 
	            $("#loadhrsection").html(response);
	        }
			});
			return false; 
	});
 });

$(function() {
	$('#fromDate').datepicker({
		changeMonth: true,
		changeYear: true,
		buttonImage: 'js/datepicker/datepickerImages/calendar.gif',
		dateFormat: 'yy-mm-dd',
		showButtonPanel: true,
		showOn: 'both',
		yearRange: '-100:+0',
		buttonImageOnly: true
		
		});
});
 </script>
<style type="text/css">
#applyspl,#applyforteam {
	cursor: pointer;
}
#inoutdetails, #Allinoutdetails ,#viewbalanceleaves {
	cursor: pointer;
}
#addextrawfh{
	cursor: pointer;
}
#viewextrawfh{
	cursor: pointer;
}
#approveextrawfhHR{
	cursor: pointer;
}
label { width: 12em; float: left; }
label.error { float: none; color: red; padding-left: .5em; vertical-align: top; }
p { clear: both; }
#teambalance {
text-align: left;
color: black;
position: absolute;
left: 1000px;
}
</style>
<?php 
$getCalIds = array("detailfromDate","detailtoDate","applyforteamfromDate","applyforteamtoDate");
$calImg=getCalImg($getCalIds);
echo $calImg;
?>
</head>
<body>
<?php
function confirmSplLeave($transactionid,$empid,$fromDate,$toDate,$leavetype,$daysList,$totalDays,$reason){
		global $db;
		$query="insert into `empleavetransactions` (`transactionid` ,`empid` ,`startdate` ,
				`enddate` ,`count`,`reason`,`approvalstatus`,`approvalcomments`)VALUES ('" . $transactionid . "','".$empid."',
				 '" .$fromDate. "', '" . $toDate . "',0,
					 '" .$reason. "','Approved','Approved by HR(".$_SESSION['u_fullname'].")')"; 

		$result = $db -> query($query);
		for($i=0;$i<sizeof($daysList);$i++) {
			$perdayquery="Insert into `perdaytransactions` (`transactionid` ,`empid` ,`date` ,`leavetype`,`shift`)
							  values('" . $transactionid . "','" .$empid. "','".$daysList[$i]."','".$leavetype."','')";
			$perdayresult = $db -> query($perdayquery);
		}
		if($leavetype=="Compensation Leave") {
			$getBalanceLeaves="select balanceleaves from `emptotalleaves` where empid='".$empid."'";
			$balanceLeavesresult = $db -> query($getBalanceLeaves);
			$row=$db->fetchAssoc($balanceLeavesresult);
			$newBalanceLeaves=$totalDays+$row['balanceleaves'];
			$updateBalanceLeavesQuery="update `emptotalleaves` set balanceleaves=$newBalanceLeaves where empid=".$empid;
			$updateResult = $db -> query($updateBalanceLeavesQuery);
		}	
		
		if($result) {
				echo "<table id='table-2'>
						<tr>
							<td>Employee Name</td>
							<td>".getempName($empid)."</td>
						</tr>";
						foreach (array_keys($daysList) as $key) {
							echo "<tr>
									<td>$daysList[$key]</td>
									<td>$leavetype</td>
									</tr>";
						}
						echo "
						<tr>
							<td>Status</td>
							<td>Approved by ".$_SESSION['u_fullname']."</td>
						</tr>
					</table>";
				echo "<script>alert('".$leavetype." is approved for ".getempName($empid)."')</script>";
		}
}
if(isset($_REQUEST['hrlinks']))
{
	echo "<u>HR Jobs</u>";
	echo "<ul>";
	echo "<li><a id='new_emp'>Add/Edit Employee Details </a></li><br>";
	echo "<li><a id='hronbehalfempapply'>Apply Leave on behalf of Employee</a></li><br>";
	echo "<li><a id='hrApproveEmpLeave'>Approve Employee Leaves</a></li><br>";
	echo "<li><a id='hrmodifyempapprovedleaves'>Modify Empoloyee Approved Leaves</a></li><br>";
	echo "<li><a id='inoutdetails'>Add Employee Inout Details</a></li><br>";
	echo "<li><a id='Allinoutdetails'>Add Inout Details for All Employees</a></li><br>";
	echo "<li><a id='viewbalanceleaves'>View Balance Leaves for Employee</a></li>";
	echo "</ul>";
	echo "<u>Apply special leave for Employee</u>";
	echo "<ul>";
	echo "<li><a id='applyspl'>Apply special Leave</a></li><br>";
	echo "<li><a id='applyforteam'>Apply Leave for Team</a></li><br>";
	echo "</ul>";
	echo "<u>Apply Extra WFH hour for Employee</u>";
	echo "<ul>";
	echo "<li><a id='addextrawfh'>Add Extra WFH Hour</a></li><br>";
	echo "</ul>";
	echo "<u>Approve/Delete Extra WFH for Employee</u>";
	echo "<ul>";
	//echo "<li><a id='modifyextrawfhHR'>Modify Extra Work from Home Hour</a></li></br>";
	echo "<li><a id='approveextrawfhHR'>Approve/Cancel Extra WFH Hour</a></li><br>";
	echo "<li><a id='viewextrawfh'>View/Modify Extra WFH Hour</a></li><br>";
	echo "</ul>";
	echo "<u>HR Reports</u>";
	echo "<ul>";
	echo "<li><a id='brief'>Employee Leaves [Brief Report]</a></li><br>";
	echo "<li><a id='detailed'>Employee Leaves [Detailed Report]</a></li><br>";
	echo "</ul>";
}

if(isset($_REQUEST['briefreport']))
{
	$query="SELECT emp.empname as name,emptotalleaves.balanceleaves,emptotalleaves.carryforwarded FROM emp, emptotalleaves WHERE emp.empid = emptotalleaves.empid";
	// Add link: Export to Excel
	echo("<div style='font-weight:bold'>Export:&nbsp;".
        "<a href = 'csv.php?export1=1&query=".urlencode($query).
        "' title = 'Export as CSV'>".
        "<img src='images/excel.gif' alt='Export as CSV'/></a></div>");
	$result=$db->query($query);
	echo "<table id='table-2'>
	  <tbody>
	  <tr>
	  	<td>Emp Name</td>
	  	<td>Balance Leaves</td>
	  </tr>";
	for($i=0;$i<$db->countRows($result);$i++)
	{
		$row=$db->fetchAssoc($result);
		echo "<tr><td>".$row['name']."</td>";
		echo "<td>".($row['balanceleaves']+$row['carryforwarded'])."</td></tr>";
	}
	echo "</tbody></table>";
	echo "<br><br>";
}
if(isset($_REQUEST['detailedreport']))
{
	echo "<form id='detailed_form' method='POST' action='hr.php?detailedreport=1&response=1'>
		  <table id='table-2'>
		  <tbody>
		  <tr>
		  <td><label for='fromDate'>From Date:</label></td>
    	  <td><input type='text' name='fromDate' id='detailfromDate' size='20' /></td></tr>
		  <tr><td><label for='toDate'>To Date:	</label></td>
    	  <td><input type='text' name='toDate' id='detailtoDate' size='20' /></td></tr>
		  <tr><td><label>Select Team:</label></td>
    	  <td><SELECT name='team_select' id='teamName'>
		  	<option>choose</option>";
	$teamresult=$db->query("select distinct(dept) from emp");
	for($y=0;$y<$db->countRows($teamresult);$y++)
	{
		$teamrow=$db->fetchAssoc($teamresult);
		echo '<option>'.$teamrow['dept'].'</option>';
	}
	echo "<option>All</option></select></td></tr>
	<tr>
	<td colspan=\"3\" align='center'><input class='submit' type='submit' name='submit' value='Submit'/></td>
	</tr></tbody>
	</table></form>";
	if(isset($_REQUEST['response']))
	{
		$startdate=$_REQUEST['fromDate'];
		$enddate=$_REQUEST['toDate'];
		$team=$_REQUEST['team_select'];
		 echo '<script>
                $("#detailfromDate").val("'.$startdate.'");    
                $("#detailtoDate").val("'.$enddate.'");
		$("#teamName").val("'.$team.'");
                </script>';
		echo "<h3><u><center>Detailed Reeport from $startdate to $enddate for $team.</center><u></h3><br>";
		if($team=="All")
		{
			$query2="SELECT * FROM emp WHERE state='Active' and empid IN (SELECT DISTINCT (empid) AS empid
				FROM `empleavetransactions` WHERE approvalstatus = 'Approved' AND startdate BETWEEN '".$startdate."'
				AND '".$enddate."')";
		}
		else {
		$query2="SELECT * FROM emp WHERE dept = '".$team."' and state='Active'";
		}
		// Add link: Export to Excel
		echo("<div style='font-weight:bold'>Export:&nbsp;".
        "<a href = 'csv.php?export2=1&dept=".$team."&startdate=".$_REQUEST['fromDate']."&enddate=".$_REQUEST['toDate']."&query=".urlencode($query2).
        "' title = 'Export as CSV'>".
        "<img src='images/excel.gif' alt='Export as CSV'/></a></div>");
		$result2=$db->query($query2);
		echo "<table id='table-2'>
	  <tbody>";
		for($x=0;$x<$db->countRows($result2);$x++)
		{
			$row2=$db->fetchAssoc($result2);
			$query3="SELECT empname FROM `emp` WHERE empid=".$row2['empid'];
			$result3=$db->query($query3);
			$row3=$db->fetchAssoc($result3);
			$result6=$db->query("SELECT balanceleaves,carryforwarded FROM `emptotalleaves` WHERE empid=".$row2['empid']);
			$row6=$db->fetchAssoc($result6);	
		    echo "<tr><th>".$row3['empname']."(".$row2['empid'].")
		    <a id='teambalance'>Balance Leaves: ".($row6['balanceleaves']+$row6['carryforwarded'])."</a></th></tr>";
			$query4="SELECT empleavetransactions.empid,  empleavetransactions.startdate, empleavetransactions.enddate, empleavetransactions.count,
		    empleavetransactions.reason FROM  empleavetransactions WHERE empleavetransactions.empid =".$row2['empid']." and approvalstatus = 'Approved' 
			AND startdate BETWEEN '".$startdate."' AND '".$enddate."'";
			echo "<tr><td><table id='table-2'>
			    <tbody>
			    <tr>
			  	<td>Start Date</td>
			  	<td>End Date</td>
			  	<td>Days Taken</td>
			  	<td>Reason</td>
			    </tr>";
			$result4=$db->query($query4);
			$allCount=0;
			for($i=0;$i<$db->countRows($result4);$i++)
			{
				$row4=$db->fetchAssoc($result4);
				$allCount=$allCount+$row4['count'];
				echo "<tr><td>".$row4['startdate']."</td>";
				echo "<td>".$row4['enddate']."</td>";
				echo "<td>".$row4['count']."</td>";
				echo "<td>".$row4['reason']."</td></tr>";
			}
			echo"<tr><td colspan=4><b style='float:right'>Total Approved leaves = ".$allCount."</b></td></tr>";
			echo "</tbody></table></td></tr>";
		}
	}
}

if(isset($_REQUEST['applyspl']))
{
	if(isset($_REQUEST['update'])) {
		if(isset($_REQUEST['confirm'])){
			$daysList=array();
			$leavetype="";
			foreach (array_keys($_REQUEST) as $key) {
				if(substr($key, 0, 4 ) === "Date") {
					list($x,$date) = explode('/',$key);
					array_push($daysList,$date);
					$leavetypeTmp=$_REQUEST[$key];
                                        if (is_array($leavetypeTmp)) {
                                                $key=key($leavetypeTmp);
                                                $leavetype=$leavetypeTmp[$key];
                                        } else {
						$leavetype=$leavetypeTmp;
					}
				}
			}
			confirmSplLeave($_REQUEST['tid'],$_REQUEST['empid'],$_REQUEST['fromDate'],$_REQUEST['toDate'],$leavetype,$daysList,$_REQUEST['count'],urldecode($_REQUEST['reason']));
		} else {
		$tid=generate_transaction_id();
		$fromDate=$_REQUEST['fromDate'];
		if(strtoupper($_REQUEST['selectoption'])=="DAYS") {
			$toDate=date('Y-m-d', strtotime($fromDate. ' +'.($_REQUEST['noofdays']-1).'  days'));
			$totalDays=$_REQUEST['noofdays'];
		}
		if(strtoupper($_REQUEST['selectoption'])=="WEEKS") {
			$toDate=date('Y-m-d', strtotime($fromDate. ' +'.$_REQUEST['noofdays'].'  week'));
			$toDate=date('Y-m-d', strtotime($toDate. ' -1  days'));
			$totalDays=($_REQUEST['noofdays']*7);
			
		}
		$reason=str_replace('\'','\\\'',$_REQUEST['reason']);
		$numOfDays=RegleavesCal($fromDate,$toDate,$_REQUEST['employeeid']);
		$count=0;
		echo "<form name='confirmSplLeave' id='confirmSplLeave' method='POST' action='hr.php?applyspl=1&update=1&confirm=1'>";
		echo"<table id=table-2>";
		for($j=0;$j<sizeof($numOfDays);$j++) 
		{
			if(substr( $numOfDays[$j] , 0, 2 ) === "20" )
			{				
				echo "<tr><td> $numOfDays[$j]  </td>";
				echo "<td><input type ='text' name='Date".$count."/".$numOfDays[$j]."' value ='".$_REQUEST['splleavename']."'  readonly=true/></td> </tr>";
				$count++;	
				
			} else {
				echo "<td colspan='2' align='center'> $numOfDays[$j]  </td>";
				echo '</tr>';
			}
		}	
		if($count==0) {
			echo "<tr><td colspan='2'><font color='red'>Leave is already approved/Pending on selected days.
					Please reapply leave.";
			echo "<tr><td><input type='button' name='reApply' id='reApply' value='Re-Apply' /></td>
				</tr></table>";
		}
		elseif($count<$totalDays) {
			echo "<tr><td colspan='2'><font color='red'>You have selected $totalDays days of ".$_REQUEST['splleavename'].". 
			Out of which ".($totalDays-$count)." days are already in approved/Pending state or weekends/holidays. 
			So, remaining $count days you are applying for (".$_REQUEST['splleavename'].") leave.</font></td></tr>";
		
			echo "<tr><td> Do you still want to confirm the leave?</td>
				<td><input type='submit' name='submit' value='Yes' />
				<input type='button' name='reApply' id='reApply' value='No' /></td>
				</tr></table>";
		} else {
			echo "<tr>
				<td><input type='button' name='reApply' id='reApply' value='Cancel'/></td>
				<td><input type='submit' name='submit' value='Apply'/></td>
				</tr></table>";
		}
		echo "<input type = hidden name ='tid' value = '$tid'/> ";
		echo "<input type = hidden name ='count' value = '$count'/> ";
		echo "<input type = hidden name ='fromDate' value ='$fromDate'/> ";
		echo "<input type = hidden name ='toDate' value ='$toDate'/> ";
		echo "<input type = hidden name ='empid' value ='".$_REQUEST['employeeid']."'/> ";
		echo "<input type = hidden name ='reason' value ='".urlencode($reason)."'/> ";
		
		echo "</form>";
		}
	} else {
	echo "<form name='applysplLeave' id='applysplLeave' method='POST' action='hr.php?applyspl=1&update=1' accept-charset='UTF8'>
		 	<table id='table-2'>
			<tr>
				<td><label for='empList'>Select Employee:</label></p></td>
				<td><p><SELECT id= 'empList' name='empList'>
							<option value='Choose' selected> Choose Employee </option>";
							global $db;
							$sql = $db->query("SELECT distinct(empname),empid FROM emp where state='Active' order by empname asc");
							for ($i=0;$i<$db->countRows($sql);$i++)
							{
								$result = $db->fetchArray($sql);
								echo "<option value='".$result['empid']."'>".$result['empname']."</option>";	
							}
							
							
						echo "</SELECT></p></td>		
			</tr>
			<tr style='display:none' id='empidRow'>
				<td><p class='empid'><label for='empid'>Emp Id:</label></p></td>
         		<td><p class='empid'><input type='text' id='employeeid' name='employeeid' readonly/></p></td>
        	</tr>
        	<tr style='display:none' id='trfromdate'>
			<td><p><label for='fromDate'>From Date:</label></p></td>
    		<td><p><input type='text' name='fromDate' id='fromDate' size='20' class='required' readonly='true'/></p></td>
    	</tr>
    	<tr style='display:none' id='trleavetype'>
				<td><label for='splleave'>Select Leave Type:</label></p></td>
				<td><p><SELECT id= 'splleave' name='splleave'>
							<option value='Choose' selected> Choose Leave Type </option>";
							global $db;
							$sql = $db->query("SELECT * FROM hrsplleaves order by leavetype asc");
							for ($i=0;$i<$db->countRows($sql);$i++)
							{
								$result = $db->fetchArray($sql);
								echo "<option value='".$result['default']."'>".$result['leavetype']."</option>";	
							}
							
							
						echo "</SELECT></p></td>		
			</tr>
			<tr style='display:none' id='option'>
				<td></td>
				<td>
				<input type='radio' name='selectoption' value='days' checked id='days'>days</input>
				<input type='radio' name='selectoption' value='weeks' id='weeks'>Weeks</input>
				</td>
			</tr>
			<tr style='display:none' id='defaultdays'>
				<td><p><label for='defaultdays'>Number of Days:	</label></p></td>
    			<td>
    				<input id='noofdays' readonly='true' name='noofdays'/>
    				<span id='labeloption'>days</span>
    			</td>
     		</tr>
			<tr style='display:none' id='reason'>
				<td><p><label for='reason'>Reason:</label></p></td>
    			<td><p><textarea id='reason' rows='7' cols='30'  class='required' name='reason'></textarea></p></td>
			</tr>
			<tr style='display:none' id='splsubmit' >
				<td></td>
	   			<td><p><input class='submit' type='submit' name='submit' value='Submit' /></p></td>
    		</tr>
    		<tr style='display:none'>
    			<td><p><input type='text' name='splleavename' id='splleavename' size='20' readonly='true'/></p></td>
    		</td>
       	</table>
       	</form>";
	}
}

if(isset($_REQUEST['applyforteam']))
{
	 ### Get Departments
        $querydept = "SELECT distinct(dept) FROM `emp` ORDER BY dept ASC";
        $resultdept = $db -> query($querydept);
         ## Department name
        if($resultdept) {
                while ($row = mysql_fetch_assoc($resultdept)) {
                        $department = $department . '<option value="' . $row["dept"] . '">';
                        $department = $department . $row["dept"];
                        $department = $department . '</option>';
                }
                $department = $department . '<option value="ALL">';
                $department = $department . "ALL";
                $department = $department . '</option>';
        }
	
	echo "<form id='applyLeaveForTeam' method='POST' action='hr.php?applyLeaveForTeam=1'>";
	echo "<table id='table-2'>";
	echo "<tr>";
	echo "<td><label for='selectTeam'>Apply Leave For: </label></td>";
	echo "<td><select name='applyforteamselectedoption'>";
	echo "<option value='allFemale'>All Female</option>";
	echo "<option value='allMale'>All Male</option>";
	echo "$department";  
	echo "</select></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><label for='applyforteamfromDate'>Date:</label></td>";
	echo "<td><input type='text' name='applyforteamfromDate' id='applyforteamfromDate' size='20' /></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><p><label for='applyforteamDay'>Select Day:</label></p></td>";
	echo "<td><input type='radio' class='radio' name='applyforteamRadio' value='applyforteamFullDay' checked> Full Day<br>";
	echo "<input type='radio' class='radio' name='applyforteamRadio' value='applyforteamHalfDay'> Half Day<br>";
	echo "<input type='radio' class='radio' name='applyforteamRadio' value='applyforteamWFH'> WFH</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><p><label for='applyforteamreason'>Reason:</label></p></td>";
    echo "<td><p><textarea rows='7' cols='30'  class='required' name='applyforteamreason'></textarea></p></td></tr>";
    echo "<tr><td></td><td><input type='submit' name='applyforteamsubmit' value='Apply Leave' /></td></tr>";
	echo "</table>";
	echo "</form>";
			
}

if(isset($_REQUEST['applyLeaveForTeam'])) {
	echo "<form id='applyLeaveForTeamConfirmation' method='POST' action='hr.php?applyLeaveForTeamConfirmation=1'>";
	echo "<table id='table-2'>";
	echo "<tr>";
	echo "<td><b>From Date:</b></td>";
	echo "<td><input type='text' name='applyLeaveForTeamConfirmationFromDate' value='".$_REQUEST['applyforteamfromDate']."' size='20' readonly/></td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td><b>Reason:</b></td>";
	echo "<td><textarea rows='7' cols='30'  class='required' name='applyLeaveForTeamConfirmationReason' readonly>".$_REQUEST['applyforteamreason']."</textarea></p></td>";
	echo "</tr>";
	if(isset($_REQUEST['applyforteamRadio']) &&  $_REQUEST['applyforteamRadio']=="applyforteamFullDay") {
		echo "<tr>";
		echo "<td><b>Selected Day:<b></td>";
		echo "<td><input type='text' name='applyLeaveForTeamConfirmationDay' value='FullDay' size='20' readonly/></td>";
		echo "</tr>";
	}
	if(isset($_REQUEST['applyforteamRadio']) &&  $_REQUEST['applyforteamRadio']=="applyforteamHalfDay") {
		echo "<tr>";
		echo "<td><b>Select Day:<b></td>";
		echo "<td><input type='text' name='applyLeaveForTeamConfirmationDay' value='HalfDay' size='20' readonly/><br>";
		echo "<input type='radio' class='radio' name='applyLeaveForTeamConfirmationRadioDay' value='firstHalf' checked> First Half<br>";
		echo "<input type='radio' class='radio' name='applyLeaveForTeamConfirmationRadioDay' value='secondHalf'> Second Half</td>";
		echo "</tr>";
	}
	if(isset($_REQUEST['applyforteamRadio']) &&  $_REQUEST['applyforteamRadio']=="applyforteamWFH") {
		echo "<tr>";
		echo "<td><b>Selected Day:<b></td>";
		echo "<td><input type='text' name='applyLeaveForTeamConfirmationDay' value='WFH' size='20' readonly/><br>";
		echo "<input type='radio' class='radio' name='applyLeaveForTeamConfirmationRadioDay' value='FullDay' checked> Full day WFH<br>";
		echo "<input type='radio' class='radio' name='applyLeaveForTeamConfirmationRadioDay' value='firstHalf' checked> First Half<br>";
		echo "<input type='radio' class='radio' name='applyLeaveForTeamConfirmationRadioDay' value='secondHalf'> Second Half</td>";
		echo "</tr>";
	}
	echo "<tr>";
	echo "<td><b>Select Mailing Option:</b></td>";
	//echo "<td><input type='radio' class='radio' name='applyLeaveForTeamConfirmationOption' value='sendMailWhole' checked> Send Mail as a Whole<br>";
	echo "<td><input type='radio' class='radio' name='applyLeaveForTeamConfirmationOption' value='sendMailSingle' checked> Send Mail Individually</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<th colspan=2>Apply Leave for following employees. Unselect employee if he/she is not included in below list.</th>";
	echo "</tr>";
	if($_REQUEST['applyforteamselectedoption']=='allFemale') {
		$sql = $db->query("SELECT emp.empname, emp.empid as empempid, empprofile.empid as empprofileempid, empprofile.gender FROM emp,empprofile where emp.empid=empprofile.empid and empprofile.gender='F' order by empname asc");
	} elseif($_REQUEST['applyforteamselectedoption']=='allMale') {
		$sql = $db->query("SELECT emp.empname, emp.empid as empempid, empprofile.empid as empprofileempid, empprofile.gender FROM emp,empprofile where emp.empid=empprofile.empid and empprofile.gender='M' order by empname asc");
	} elseif ($_REQUEST['applyforteamselectedoption']=='ALL')  {
                $sqlQuery="SELECT emp.empname, emp.empid as empempid FROM emp where emp.state='Active' order by empname asc";
		$sql = $db->query($sqlQuery);
        } else {
                $dept=$_REQUEST['applyforteamselectedoption'];
                $sqlQuery="SELECT emp.empname, emp.empid as empempid FROM emp where  emp.dept=\"$dept\"  and emp.state='Active' order by empname asc";
                $sql = $db->query($sqlQuery);
        }

	if($db->countRows($sql)) {
		 while($row=$db->fetchArray($sql)) {
		 	echo "<tr><td><input type='checkbox' name='applyforteamempConfirmationCheck[]' value='".$row['empempid']."' checked></td><td>".$row['empname']."<br></td></tr>";
		 }
	} else {
		echo "No employees are present with selected criteria.";
	}
	echo "<tr><td></td><td><input type='submit' id='applyLeaveForTeamConfirmationSubmit' name='applyLeaveForTeamConfirmationSubmit' value='Confirm Leave' /></td></tr>";
	echo "</form>";
	echo "</table>";
	echo "<div id='loadingmessage' style='display:none'>
			<img align='middle' src='images/loading.gif'/>
		</div>";
}

if(isset($_REQUEST['applyLeaveForTeamConfirmation'])) {
	if($_REQUEST['applyforteamempConfirmationCheck']) {
		$successfulEmps = array();
		$notSuccessfulEmpsMsg= array();
		$successfulEmpsMsg= array();
		foreach ($_REQUEST['applyforteamempConfirmationCheck'] as $empid) {
			$alreadyPresent=0;
			$query1="SELECT * from `perdaytransactions` where `date`='".$_REQUEST['applyLeaveForTeamConfirmationFromDate']."' and `empid`='".$empid."'";
			$sql = $db->query($query1);
			if($db->countRows($sql) > 0) {
				$row = $db->fetchArray($sql);
				$query2="SELECT * from `empleavetransactions` where `transactionid`='".$row['transactionid']."' and (`approvalstatus`='Approved' or `approvalstatus`='Pending')";
				$queryEmpLeaveTransactionTable=$db->query($query2);
				if($db->countRows($queryEmpLeaveTransactionTable) > 0) {
					$alreadyPresent=1;
				}
			}
			if($alreadyPresent) {
				# Get the transaction id and check in empleavetransaction table, if the transaction is pending or apoorved
				array_push($notSuccessfulEmpsMsg,"<td>".getempName($empid)." has already applied leave on ".$_REQUEST['applyLeaveForTeamConfirmationFromDate']."</td>");				
			} else {
				# Insert the transaction for each employee
				$transaction_id = generate_transaction_id();
				if($_REQUEST['applyLeaveForTeamConfirmationDay']=="FullDay") {
					$leavetype="FullDay";
					$shift="";
				} elseif($_REQUEST['applyLeaveForTeamConfirmationDay']=="HalfDay") {
					$leavetype="HalfDay";
					if($_REQUEST['applyLeaveForTeamConfirmationRadioDay']=="firstHalf") {
						$shift="firstHalf";
					} else {
						$shift="secondHalf";
					}
				} elseif($_REQUEST['applyLeaveForTeamConfirmationDay']=="WFH") {
					$leavetype="WFH";
					if($_REQUEST['applyLeaveForTeamConfirmationRadioDay']=="firstHalf") {
						$shift="firstHalf";
					} else {
						$shift="secondHalf";
					}
				}
				$query = "INSERT INTO`empleavetransactions` (`transactionid` ,`empid` ,`startdate` ,`enddate` ,`count`,`reason`,`approvalstatus`,`approvalcomments`) ".
						"VALUES ('".$transaction_id."','".$empid."','".$_REQUEST['applyLeaveForTeamConfirmationFromDate']."',".
						"'".$_REQUEST['applyLeaveForTeamConfirmationFromDate']."', '0', '".addslashes($_REQUEST['applyLeaveForTeamConfirmationReason'])."',".
						"'Approved','Approved By HR (".$_SESSION['u_fullname'].")')";
				$result1=$db->query($query);
				$perdayquery = "Insert into `perdaytransactions` (`transactionid` ,`empid` ,`date` ,`leavetype`,`shift`,`compoffreason`)
							  values('".$transaction_id."','".$empid."','".$_REQUEST['applyLeaveForTeamConfirmationFromDate']."','".$leavetype."','".$shift."','".addslashes($_REQUEST['applyLeaveForTeamConfirmationReason'])."')";
				 $result2=$db->query($perdayquery);
				if($result1 && $result2) {
					array_push($successfulEmps, $empid);
					array_push($successfulEmpsMsg,"<td>".getempName($empid)."</td>");
					if($_REQUEST['applyLeaveForTeamConfirmationOption'] == "sendMailSingle") {
						# Send Mail
						$cmd = '/usr/bin/php -f sendmail.php ' . $transaction_id . ' ' . $empid . ' ApproveLeave hr '.$_SESSION['u_empid'].'>> /dev/null &';
						exec($cmd);
					}
				}
			}
		}
		if(isset($notSuccessfulEmpsMsg) && sizeof($notSuccessfulEmpsMsg)>0) {
			echo "<table id='table-2'>";
			echo "<caption>Leave is not applied for the following list of employees</caption>";
			foreach($notSuccessfulEmpsMsg as $msg) {
				echo "<tr>".$msg."</tr>";
			}
			echo "</table>";
		}
		
		if(isset($successfulEmpsMsg) && sizeof($successfulEmpsMsg)>0) {
			echo "<hr>";
			echo "<table id='table-2'>";
			echo "<caption>Leave applied for the following list of employees successfully</caption>";
			foreach($successfulEmpsMsg as $msg) {
				echo "<tr>".$msg."</tr>";
			}
			echo "</table>";
		}
	//	if(isset($successfulEmps) && sizeof($successfulEmps)>0) {
	//		if($_REQUEST['applyLeaveForTeamConfirmationOption'] == "sendMailWhole") {
	//			# Send mail as a whole
	//			$cmd = '/usr/bin/php -f sendmail.php ' . $transaction_id . ' ' . $empid . ' ApproveLeave hr '.$_SESSION['u_empid'].' >> /dev/null &';
	//			exec($cmd);
	//		}
	///	}
	}
}

if(isset($_REQUEST['viewbalanceleaves']))
{
	echo "<table id='table-2'>";
	echo "<tr>";
	echo "<th>Sr. No.</th>";
	echo "<th>Employee Name</th>";
	echo "<th>Emp ID</th>";
	echo "<th>Carry Forwarded Leaves</th>";
	echo "<th>Balance Leaves in present year</th>";
	echo "<th>Used Leaves in present year</th>";
	echo "<th>Carry forwarded + Balance Leaves in present year</th>";
	echo "</tr>";
	global $db;
	$sql = $db->query("SELECT empname, emp.empid, carryforwarded, balanceleaves FROM emp,emptotalleaves where emp.empid=emptotalleaves.empid order by empname asc");
	for ($i=0;$i<$db->countRows($sql);$i++)
	{
		$result = $db->fetchArray($sql);
		echo "<tr>";
		echo "<td>".($i+1)."</td>";
		echo "<td>".$result['empname']."</td>";
		echo "<td align=center>".$result['empid']."</td>";
		echo "<td align=center>".$result['carryforwarded']."</td>";
		echo "<td align=center>".$result['balanceleaves']."</td>";
		echo "<td align=center>".(25-$result['balanceleaves'])."</td>";
		echo "<td align=center>".($result['carryforwarded']+$result['balanceleaves'])."</td>";
		echo "</tr>";
	}
	echo "</table>";
}

?>
</body>
</html>
