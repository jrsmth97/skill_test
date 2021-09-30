<?php

// echo enkripsi('DFHKNQ');

function enkripsi($kata)
{
    // Ubah kata ke array
    $arrayKata = str_split($kata);

    // Siapkan variabel untuk mengisi hasil enkripsi
    $result = '';
    foreach ($arrayKata as $key => $alphabet) {
        // Siapkan Pattern untuk enkripsi
        $pattern = $key + 1;

        // Ubah format ascii dahulu
        $letterAscii = ord($alphabet);

        // Bedakan antara pattern dengan angka ganjil dan genap
        // Pattern Genap-Negatif / Ganjil-Positif
        if ($pattern % 2 == 0) {
            // Ascii baru setelah di kurangi pattern genap
            $newAscii = $letterAscii - $pattern;

            // Generate Huruf baru dengan pembatasan agar Huruf tetap direntang A-Z
            if ($newAscii < 66) {
                $newPatt = 66 - $newAscii;
                $result .= chr(92 - $newPatt);
            } else $result .= chr($letterAscii - $pattern);
        } else {
            // Ascii baru setelah di tambah pattern ganjil
            $newAscii = $letterAscii + $pattern;

            // Generate Huruf baru dengan pembatasan agar Huruf tetap direntang A-Z
            if ($newAscii > 90) {
                $newPatt = $newAscii - 92;
                $result .= chr(66 + $newPatt);
            } else $result .= chr($letterAscii + $pattern);
        }
    }

    return $result;
}
