<?php
/****************************
** DATE AND TIME FUNCTIONS **
*****************************/

// soma dois tempos no formato hh:mm:ss
function sum_time($time1, $time2) 
{
	$times = array($time1, $time2);
	$seconds = 0;
	foreach ($times as $time)
	{
		list($hour,$minute,$second) = explode(':', $time);
		$seconds += $hour*3600;
		$seconds += $minute*60;
		$seconds += $second;
	}
	$hours = floor($seconds/3600);
	$seconds -= $hours*3600;
	$minutes  = floor($seconds/60);
	$seconds -= $minutes*60;
	// return "{$hours}:{$minutes}:{$seconds}";
	return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
}

// gives the difference between two dates counting time difference
function calc_days_checkout($date1, $date2, $time_limit=false)
{
	$date2_str = strtotime(substr($date2, 0, strpos($date2, ' ')));
    $date1_str = strtotime(substr($date1, 0, strpos($date1, ' ')));
    $diff = $date2_str - $date1_str;
    $datediff = floor($diff/(60*60*24));
    // adiciona um dia referente ao dia de chegada
    $datediff++;
    // verifica se o cliente paga diária extra
    if ($time_limit)
	{
		$time2 = substr($date2, strpos($date2, ' '));
		$time2 = strtotime($time2);
		$time1 = strtotime($time_limit.':00');
		if ($time2 > $time1)
		{
			$datediff++;
		}
	}
    return $datediff;
}

// gives the difference between two dates without counting time difference
function calc_days($date1, $date2, $time_limit=false)
{
	$date2_str = strtotime($date2);
    $date1_str = strtotime($date1);
    $datediff = $date2_str - $date1_str;
    $datediff = floor($datediff/(60*60*24));
    if ($time_limit)
	{
		$time2 = substr($date2, strpos($date2, ' '));
		$time2 = strtotime($time2);
		$time1 = strtotime($time_limit.':00');
		if ($time1 > $time2)
		{
			$datediff++;
		}
	}
    return $datediff;
}

// gives the difference between two given dates ('Y-m-d H:m:s' format)
function diff_dates($date1, $date2, $details=false)
{
	$date1 = strtotime($date1);
	$date2 = strtotime($date2);
	//$dateDiff = $date1 > $date2 ? $date1 - $date2 : $date2 - $date1;
	$dateDiff = $date1 - $date2;
	$fullDays = floor($dateDiff/(60*60*24));
	//$dateDiff = $date1 > $date2 ? $date1 - $date2 : $date2 - $date1;
	$dateDiff = $date1 - $date2;
	$fullDays = floor($dateDiff/(60*60*24));
	if ($details)// still don't return it
	{
		$fullHours = floor(($dateDiff-($fullDays*60*60*24))/(60*60));
		$fullMinutes = floor(($dateDiff-($fullDays*60*60*24)-($fullHours*60*60))/60);
	}
	return $fullDays;
}

// this little switch-case finds out the correct due date for each month
function due_date($day, $month)
{
	switch ($month)
	{
		case 2:
			$day = $day > 28 ? 28 : $day;
			break;
		case 2:
		case 4:
		case 6:
		case 9:
		case 11:
			$day = $day == 31 ? 30 : $day;
			break;
		default:
			$day = $day;
			break;
	}
	return $day;
}

// formats date to and from the database (consider revision)
function format_date($date, $sep="-", $t=true)
{
    if ($date)
    {
        $date = str_replace("-", "/", $date);
        $time = "";
        if (strstr($date, " "))
        {
            $date_arr = explode(" ", $date);
            $time = $t ? " ".$date_arr[1] : "";
            $date = $date_arr[0];
        }
        $new = explode("/", $date);
        return str_pad($new[2], 2, '0', STR_PAD_LEFT).$sep.str_pad($new[1], 2, '0', STR_PAD_LEFT).$sep.str_pad($new[0], 2, '0', STR_PAD_LEFT).$time;
        return $date;
    }
    return false;
}

// gives a mysql datetime format
function now()
{
	return date("Y-m-d H:i:s");
}

// get someone's age by a given birthdate
function get_age($date)
{
	$age = FALSE;
	if (is_type($date, 'date') && $date != "0000-00-00")
	{
		if (strstr($date, '-'))
		{
			$date = format_date($date);
		}
		$date_a = explode("/", $date);
		$dia = (int)$date_a[0];
		$mes = (int)$date_a[1];
		$ano = (int)$date_a[2];
		$dia_atual = date('d');
		$mes_atual = date('m');
		$ano_atual = date('Y');
		$age = $ano_atual - $ano;
		if ($mes_atual < $mes)
		{
			$age--;
		}
		else if ($mes_atual == $mes && $dia_atual < $dia)
		{
			$age--;
		}
	}
	return $age;
}

function show_date($timestamp)// mysql timestamp
{
	return format_date(substr($timestamp, 0, 10), '/');
}

function show_time($timestamp)// mysql timestamp
{
	return substr($timestamp, 11, 5);
}

function sanitize_date($date)
{
	$date = str_replace('%2F', '/', $date);
    $date = str_replace('%20', ' ', $date);
    $date = str_replace('%3A', ':', $date);

    return $date;
}

function unsanitize_date($date)
{
	$date = str_replace('/', '%2F', $date);
    $date = str_replace(' ', '%20', $date);
    $date = str_replace(':', '%3A', $date);
    return $date;
}

// writes date a date with words (consider revision)
function ext_date($date)// formato dd/mm/aaaa
{
	$r = $date;
	if ($date)
	{
		if (strstr($date, '-'))
		{
			$date = format_date($date);
		}
		if ($date_a = explode('/', $date))
		{
			$dia = $date_a[0];
			$suf = "th";
			if ($dia == 1)
			{
				$suf = "st";
			}
			else if ($dia == 2)
			{
				$suf = "nd";
			}
			else if ($dia == 3)
			{
				$suf = "rd";
			}
			$mes_num = $date_a[1];
			$meses = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			$mes = $meses[(int)$mes_num];
			$ano = $date_a[2];
			$r = "$dia$suf of $mes $ano";
		}
	}
	return $r;
}
?>