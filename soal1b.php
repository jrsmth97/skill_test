<?php

$kalimat = 'Coba Boskuuh';

// var_dump(banyakHurufKecil($kalimat));

function banyakHurufKecil($kalimat)
{
    $arrayHuruf = str_split($kalimat);

    $jumlahHurufKecil = 0;
    foreach ($arrayHuruf as $arr) {
        if (ctype_lower($arr)) $jumlahHurufKecil += 1;
    }

    return '"' . $kalimat . '" mengandung ' . $jumlahHurufKecil . ' buah huruf kecil';
}
