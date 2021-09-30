<?php

$array = [
    ['f', 'g', 'h', 'i'],
    ['j', 'k', 'p', 'q'],
    ['r', 's', 't', 'u']
];

// var_dump(cari($array, 'fghp'));

function cari($array, $huruf)
{
    // Ubah input huruf ke array
    $arrayHuruf = str_split($huruf);

    // Merge Array
    $countArray = count($array) - 1;
    $arrayBulk = [];
    for ($count = 0; $count <= $countArray; $count++) {
        foreach ($array[$count] as $arr) {
            array_push($arrayBulk, $arr);
        }
    }

    // Buat variabel search untuk menampung hasil pencarian
    $search = [];

    // Buat search pattern 
    $allowedGap = [1, 4];

    // Buat variabel untuk menyimpan key hasil pencarian yang sudah lalu
    $prevKey = 0;
    foreach ($arrayBulk as $key => $arr) {
        $newLine = false;

        // Batasi agar jumlah key array tidak melebihi array huruf
        if ($key > count($arrayHuruf) - 1) break;

        // Cari huruf menggunakan array search dan simpan ke variabel
        $searchKey = array_search($arrayHuruf[$key], $arrayBulk);

        if ($searchKey !== null) {
            // Tentukan gap key yang sekarang dengan key sebelumnya
            $keyGap = abs($searchKey - $prevKey);

            // Buat kondisi 
            if ($searchKey % 4 === 0 && $searchKey !== 0 && $key !== 0 && $keyGap !== 4) {
                $newLine = true;
            }

            if ($searchKey === 0) $keyGap = 1;

            // Push huruf hasil pencarian ke dalam array $search dengan kondisi pattern yang sudah ditentukan
            if (in_array($keyGap, $allowedGap) && !$newLine) {
                array_push($search, $arrayHuruf[$key]);

                // Masukkan key huruf yang sudah ketemu untuk digunakan dalam loop selanjutnya
                $prevKey = $searchKey;
            }
        }
    }

    return count($arrayHuruf) === count($search) ? true : false;
}
