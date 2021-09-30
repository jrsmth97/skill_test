<?php

$nilai = "72 65 73 78 75 74 90 81 87 65 55 69 72 78 79 91 100 40 67 77 86";

// var_dump(hitungRataRata($nilai));
// var_dump(tujuhNilai($nilai, 'tertinggi'));
// var_dump(tujuhNilai($nilai, 'terendah'));

function hitungRataRata($nilai)
{
    // Ubah string ke array
    $arrayNilai = explode(' ', $nilai);

    $jumlahNilai = 0;
    // Hitung Semua Jumlah Nilai
    foreach ($arrayNilai as $arr) {
        $jumlahNilai += $arr;
    }

    // Bagi Jumlah Nilai dengan banyaknya nilai di array
    return $jumlahNilai / count($arrayNilai);
}

function tujuhNilai($nilai, $kondisi)
{
    // Ubah string ke array
    $arrayNilai = explode(' ', $nilai);

    // Ubah format string ke integer
    for ($i = 0; $i < count($arrayNilai); $i++) {
        $arrayNilai[$i] = (int) $arrayNilai[$i];
    }

    // Jalankan sorting sesuai kondisi
    if ($kondisi == 'tertinggi') {
        rsort($arrayNilai);
    } else {
        sort($arrayNilai);
    }

    $arrayBaru = [];
    // Masukkan hasil sorting ke array baru
    for ($a = 0; $a <= 6; $a++) {
        array_push($arrayBaru, $arrayNilai[$a]);
    }

    return $arrayBaru;
}
