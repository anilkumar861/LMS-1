<?php
session_start();
require_once 'Library.php';
$db=connectToDB();
?>
<?php
echo '<html>
<head>';
echo '<link rel="stylesheet" type="text/css" media="screen" href="css/selfleavehistory.css" />
<script type="text/javascript">  
	$("#loadingmessage").show();
        $("document").ready(function(){
	    $("#loadingmessage").hide();
            $(".table-1 tr:odd").addClass("odd");
            $(".table-1 tr:not(.odd)").hide();
            $(".table-1 tr:first-child").show();
            $(".table-1 tr.odd").click(function(){
	            $(this).next("tr").toggle();
	            $(this).find(".arrow").toggleClass("up");
            }); 
		
		$( "#tabs" ).tabs();
		
          });
   </script>
</head>
<body>

<div id="loadingmessage" style="display:none">
     <img align="middle" src="images/loading.gif"/>
</div>';

$sql=$db->query("SELECT DISTINCT YEAR(startdate) as year FROM empleavetransactions where empid='".$_SESSION['u_empid']."' order by year desc");
$distinctYears=array(); 
$leaveCount=$db->countRows($sql);
if($leaveCount == 0) {
	echo "<div id='tabs'><ul><div id='Info'><tr><td>No Data Available</td></tr></div></ul></div>";
} else {
	echo '<div id="tabs">
                <ul>';
}
for($i=0;$i<$db->countRows($sql);$i++)
{
	$row=$db->fetchArray($sql);
	echo "<li><a href='#".$row['year']."'>".$row['year']."</a></li>";
	array_push($distinctYears,$row['year']);
}
echo "</ul>";
foreach ($distinctYears as $year) {
	echo "<div id='".$year."'>";
	echo '<h3 align=\"center\"><u>Approved/Cancelled Leaves</u></h3><br><br>';
	
	# Display Approved leaves based on month wise
	$months = array("01"=>"Jan", "02"=>"Feb", "03"=>"Mar", "04"=>"Apr", "05"=>"May", "06"=>"June", "07"=> "July", "08"=>"Aug", "09"=>"Sept","10"=>"Oct","11"=>"Nov", "12"=>"Dec");
	echo "<table id='table-2' ><tr>";
	foreach ($months as $monthID => $monthName) {
		echo "<th>$monthName</th>";
	}
	echo "</tr><tr>";
	foreach ($months as $monthID => $monthName) {
		$startDayInMonth="$year-$monthID-01";
		$EndDayInMonth="$year-$monthID-31";
		$query="select SUM(count) as noDays from perdaytransactions where date between '".$startDayInMonth."' and '".$EndDayInMonth."' and empid='".$_SESSION['u_empid']."' and status='Approved'";
		$getApprovedLeavesInMonth=$db->query($query);
		$getApprovedLeavesInMonthRow=$db->fetchArray($getApprovedLeavesInMonth);
		$numOfDays=(float)$getApprovedLeavesInMonthRow['noDays'];
		if ($numOfDays <= 0) {
			echo "<td>0</td>";
		} else {
			echo "<td>".$numOfDays."</td>";
		}
		
	}
	echo "</tr></table>";
		
	
	$sql=$db->query("select * from empleavetransactions where empid='".$_SESSION['u_empid']."' and startDate between '".$year."-01-01' and '".$year."-12-31' and
					(approvalstatus='Approved' or approvalstatus='Cancelled' or approvalstatus='Deleted') order by startDate");
	
	$onlyApprovedLeaves=$db->query("select * from empleavetransactions where empid='".$_SESSION['u_empid']."' and startDate between '".$year."-01-01' and '".$year."-12-31' and
					(approvalstatus='Approved') order by startDate");
	$totalCount=0;
	for($j=0;$j<$db->countRows($onlyApprovedLeaves);$j++)
	{
		$row=$db->fetchArray($onlyApprovedLeaves);
		$totalCount=$totalCount+$row['count'];
	}
	$splLeave = "";
	echo "<table class=\"table-1\" width='70%'>
			<tr>
				<th width='20%'>Start Date</th>
				<th width='20%'>End Date</th>
				<th>Count</th>
				<th width='40%'>Reason</th>
				<th width='40%'>Status</th>
				<th width='40%'>Comments</th>
				<th></th>
			</tr>";
	
	for($i=0;$i<$db->countRows($sql);$i++)
	{
		$row=$db->fetchArray($sql);
		echo '<tr>';
		echo '<td>'.$row['startdate'].'</td>';
		echo '<td>'.$row['enddate'].'</td>';
		echo '<td>'.$row['count'].'</td>';
		echo '<td>'.$row['reason'].'</td>';
		echo '<td>'.$row['approvalstatus'].'</td>';
		echo '<td>'.$row['approvalcomments'].'</td>';
		echo '<td><div class="arrow"></div></td></tr>';
		$tid=$row['transactionid'];
		$sql1=$db->query("select * from perdaytransactions where transactionid='".$tid."'");
		echo '<tr>
					<td colspan="6">
					<table>
						<tr>
						<th>Date</th>
						<th>Leave Type</th>
						<th>Shift</th>
						</tr>';
		while($row1=$db->fetchArray($sql1)) 
		{
			$leavetype = $row1['leavetype'];
			$Day = $row1['date'];
			echo '<tr></tr><tr><td>'.$row1['date'].'</td>';
			echo '<td>'.$row1['leavetype'].'</td>';
			echo '<td>'.$row1['shift'].'</td>';
			echo '</tr>';
		}
		echo "<tr></tr><tr></tr>";
		echo '</table>';
		echo '</td></tr><tr></tr>';
		
	}
	echo "<tr></tr>";
	echo "<tr></tr><tr>
			<td colspan=7><b style='float:right'>
				Total Approved leaves in ".$year." = ".$totalCount."
			<b></td>
		 </tr>";
				
	echo "</table>";
	echo "</div>";
}
	echo "</body>";
	echo "</html>";
?>



