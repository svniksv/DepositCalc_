<?php
header("Content-Type: application/json");
$data = json_decode(file_get_contents("php://input"));

$temp = explode('-', $data->startDate);
$startMonth = $temp[1];

if ($data->sum < 1000 or $data->sum > 3000000) echo "Сумма вклада должна быть от 1000 до 3000000 рублей";
elseif ($data->term < 1 or $data->term > 60) echo "Срок вклада от 1 до 60 месяцев (до 5 лет)";
elseif ($data->percent % 1 != 0 or $data->percent < 3 or $data->percent >100) echo "Процентная ставка должна быть целым числом от 3 до 100 процентов";
elseif ($data->sumAdd < 0 or $data->sumAdd > 3000000) echo "Сумма пополнения вклада должна быть от 0 до 3000000 рублей";
else{
$result = sumN($startMonth, $startYear, $data->sum, $data->term, $data->percent, $data->sumAdd);
echo "Сумма к выплате: ".floor($result)." рублей.";
}
function sumN($startMonth, $startYear, $sum, $term, $percent, $sumAdd){
    if($term == 0){
        return $sum; 
    }
    else {
        $month = $startMonth + $term - 1;
        $year = $startYear;
        while ($month > 12){
            $year += 1;
            $month -= 12;
        }
        return sumN($startMonth,$startYear, $sum, $term - 1, $percent, $sumAdd) + (sumN($startMonth,$startYear, $sum, $term - 1, $percent, $sumAdd) + $sumAdd) * daysInMonth($month,$year) * ($percent / daysInYear($year));
    }
}

function daysInMonth($month, $year){
    switch ($month){
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            return 31;
            break;
        
        case 4:
        case 6:
        case 9:
        case 11:
            return 30;
            break;
        
        case 2:
            if (daysInYear($year) == 366) return 29;
            else return 28;
    }
}

function daysInYear($year){
    if ($year%4 == 0 and $year%100 != 0 or $year%100 == 0 and $year%400 == 0) return 366;
    else return 365;
}
