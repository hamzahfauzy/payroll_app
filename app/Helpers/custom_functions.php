<?php

function monthListArray()
{
    return [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
}

function getMonth($value)
{
    return monthListArray()[$value];
}

function monthListOption()
{
    $monthLists = monthListArray();
    $options    = '';
    foreach($monthLists as $key => $month)
        $options .= "<option value='$key'>$month</option>";
    
    return $options;
}