<form action='' method='post'>
    <label>Insert year</label><br/>
    <input type='text' name='year'><br/>
    <label>Insert course</label><br/>
    <input type='text' name='course'>
    <input type="submit" name="Enter" value="Enter">
</form>
<br/>
<br/>

<?php
$months = array ('September','October','November','December','January','February','March','April','May','June','July','August');
$dayInMonths = array (30,31,30,31,31,28,31,30,31,30,31,31);
$day_of_week = JDDayOfWeek(cal_to_jd(CAL_GREGORIAN, '09', '01',(int)$_POST['year']),0);
$course = array (1,2,3,4,5,6);

if (isset($_POST['Enter']))
{
    if ($_POST['year']=='' || $_POST['course']==''){
        echo 'Please, enter year and course'.'<br/>';
    }
}

if (($_POST['year'])%4==3)
    $dayInMonths[5]++;  //весокосный год


$currWeek=1;
$currDay=1;
$i=0;
for ($i=0; $i<12; $i++) {
	echo "$months[$i]</br></br>";
	printFirstWeek();
	printOthersWeek($dayInMonths[$i]);
	echo "</br>";
}



function printFirstWeek(){
	global $currWeek, $day_of_week, $currDay;
	echo "Week ",$currWeek,": ";
	//$currDay=33-$day_of_week;
	for ($i=1; $i<$day_of_week; $i++)
	{
		echo '&nbsp;';
		echo '&nbsp;';
		$currDay++;
	}

	$currDay=1;
	for ($i=$day_of_week; $i<8; $i++)
	{
		echo "$currDay ";
		echo '&nbsp;';
		$currDay++;
		$day_of_week=($day_of_week +1) %7;
	}
	echo "</br>";
}

function printOthersWeek(){
	global $currWeek, $day_of_week, $currDay, $dayInMonths, $i;
	#echo $dayInMonths[$i];
	while (true) 
	{
		$currWeek=($currWeek % 4)+1;
		echo "Week ",$currWeek,": ";
		for ($j=0; $j<7; $j++)
		{
			echo "$currDay ";
			$currDay++;
			$day_of_week=($day_of_week %7) + 1;
			if($currDay>$dayInMonths[$i]) break;
		}
		echo "</br>";
		if($currDay>$dayInMonths[$i]) break;	
	}
}
?>
