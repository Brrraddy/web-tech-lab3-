<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Brrraddy Calendar</title>

        <!-- Styles -->
        <link rel="stylesheet" href="files.css">
	</head>
<body>
<header>
    <div class="block">
	<?php

		//Way of script
		$self = $_SERVER['PHP_SELF'];

		//Check data in URL	
		function set(&$supp,$name,$arg = 'm')
		{
			if(isset($_GET[$name])) 
				$supp = $_GET[$name];
			else
				if ($name != 'num')
					$supp = date($arg);
				else
					$supp = 1;
		}
		
		set($month,'month','m');		
		set($year,'year','Y');
		set($num,'num');							
				
		$Month_r = array(
		"1" => "Январь",
		"2" => "Февраль",
		"3" => "Март",
		"4" => "Апрель",
		"5" => "Май",
		"6" => "Июнь",
		"7" => "Июль",
		"8" => "Август",
		"9" => "Сентябрь",
		"10" => "Октябрь",
		"11" => "Ноябрь",
		"12" => "Декабрь");

		$first = mktime(0, 0, 0, $month, 1, $year);
		$max_days = date('t', $first);
		$date = getdate($first); //возращает колво дней в указ месяце
		$month = $date['mon'];
		$year = $date['year'];
			
		//Creating html part
		$calendar = "
		<div class=\"block\">
		<table width='390px' height='280px' style='border: 1px solid #f8f7f2';>
			<tr style='background: #BF9BDE;'>
				<td colspan='7' class='nav'>
				".$Month_r[$month]." ".$year."			
				</td>
			</tr>
		<tr>
			<td class='dat'>Пн</td>
			<td class='dat'>Вт</td>
			<td class='dat'>Ср</td>
			<td class='dat'>Чт</td>
			<td class='dat'>Пт</td>
			<td class='dat'>Сб</td>
			<td class='dat'>Вс</td>
		</tr>
		<tr>"; 

		//Name of html class
		$class = "";
		$weekday = $date['wday'];

		//In format 
		$weekday = $weekday-1; 
		if($weekday == -1) $weekday=6;
		$day = 1;

		
		if($weekday > 0) 
			$calendar .= "<td colspan='$weekday'> </td>";
		
		//Show with color
		while($day <= $max_days)
		{
			//On new string
			if($weekday == 7) {
				$calendar .= "</tr><tr>";
				$weekday = 0;
			}
	
			//Check today's date
			if($day == date('j') && $month == date('n') && $year == date('Y')) 
				$class = "calend";
			else 																		
				$class = "cal";   														
			
			if(($num == 1) || ($num == 2)) {			
				if(($month == 1) || (($month == 2) && ($day < 9)) || 
					($month == 7) || ($month == 8) || (($month == 6) && ($day > 10)))	 {
						$class = "calend"; 
						$special_days='style="color: cadetblue" ';
					}					
				else 
					$special_days='';
			}
			
			if($num == 3) {		
				if((($month == 12) && ($day > 21)) || (($month == 1) && ($day < 26)) || (($month == 5) && ($day > 18)) || ($month == 6)
					|| ($month == 7) || ($month == 8)) {			 
						$class = "calend"; 
						$special_days='style="color: cadetblue" ';
					}	
				else 
					$special_days='';
			}
			
			if($num == 4) {		
				if((($month == 12) && ($day > 21)) || (($month == 1) && ($day < 26)) || (($month == 3) && ($day > 15)) 
					|| ($month == 4) || ($month == 5) || ($month == 6))	{		 
						$class = "calend"; 
						$special_days='style="color: cadetblue" ';
					}	
				else 
					$special_days='';
			}
				 
			$calendar .= "
				<td class='{$class}'><span ".$special_days.">{$day}</span>
				</td>";
			$day++;
			$weekday++;	
		}

		if($weekday != 7) 
			$calendar .= "<td colspan='" . (7 - $weekday) . "'> </td>";

		//Show the calendar
		echo $calendar . "</tr></table>"; 
		
		$month1 = 9;
		$week = 1;
		$day = 1;
		
		if ($month > 8)
			$year1 = $year;
		else	
			$year1 = $year - 1;
							
		//Searching a week
		while (($month1) != ($month)) {
				
			$first_of_month1 = mktime(0, 0, 0, $month1, 1, $year1);
			$max_days1 = date('t', $first_of_month1);
				
			for($j = 1; $j <=$max_days1; $j++) {
					
				$of_month1 = mktime(0, 0, 0, $month1, $j, $year1);
				$date_info1 = getdate($of_month1);
				$weekday1 = $date_info1['wday'];
												
				if ($weekday1 == 0) 
					$week++;
					
				if ($week == 5)
					$week = 1;
					
				$day++;
			}
			$month1++;
				
			if($month1 == 13) {
				$month1 = 1;
				$year1++;
			}					
		}
				
		$months = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');	
		echo "<form style='float: right; margin-right: 10px;' action='$self' method='get'><p>Год:<select name='year'>";
	
		//Checking a year
		for($i=date('Y'); $i<=(date('Y')+50); $i++) {
			$selected = ($year == $i ? "selected = 'selected'" : '');
			echo "<option value=\"".($i)."\"$selected>".$i."</option>";
		}
			
		echo "</select></p>";
		echo "<p>Месяц:<select name='month'>";
		
		//Checking a month
		for($i=0; $i<=11; $i++) {
			echo "<option value='".($i+1)."'";
			if($month == $i+1) 
				echo "selected = 'selected'";
			echo ">".$months[$i]."</option>";
		}		
		echo "</select></p>";
		
		//Choose a course
		echo "<p>Курс:<select name='num'>";
		for($i=1; $i<5; $i++) {
			$selected = ($num == $i ? "selected = 'selected'" : '');
			echo "<option value=\"".($i)."\"$selected>".$i."</option>";
		}
		echo "</select></p>";
		echo "<input type='submit' value='Перейти'/></form>";
				
		$weekf = $week;	
		for($i=1;$i<5;$i++) {
			$weekf++;
			if($weekf == 5) $weekf = 1;
			switch ($i) {
				case 1: $week2 = $weekf; break;
				case 2: $week3 = $weekf; break;
				case 3: $week4 = $weekf; break;
				case 4: $week5 = $weekf; break;
			}
		}
			
		echo "<p>Недели: ".$week.", ".$week2.", ".$week3.", ".$week4.", ".$week5."</p>";

		//Link on today's data
		if($month != date('m') || $year != date('Y'))
			echo "<a style='float: left; margin-left: 10px; font-size: 12px; padding-top: 5px;' href='".$self."?month=".date('m')."&year=".date('Y')."&num=".$num."'>Перейти к текущей дате</a>";
		echo "</div>"; 
	?>
    </div>
</header>
</body>
</html>