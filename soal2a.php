<?php

// echo buatTabel(64);

function buatTabel($angka)
{
    // Buat variabel untuk menampung output tabel
    $tabel = '';

    /* Buat Pattern untuk warna
    h = hitam | p = putih */
    $patternSatu = ['h', 'h', 'p', 'p', 'h', 'p', 'h', 'p'];
    $patternDua = ['p', 'h', 'h', 'p', 'h', 'h', 'p', 'p'];
    $patternTiga = ['h', 'p', 'h', 'p', 'p', 'h', 'h', 'p'];

    // Gabungkan pattern menjadi 1 array
    $pattern = array_merge($patternSatu, $patternDua, $patternTiga);

    $index = 0;
    for ($i = 1; $i <= $angka; $i++) {
        // Seleksi jika index array melebihi isi dari pattern lalu ulangi dari awal
        if ($i > 24) {
            if ($index > 23) $index = 0;
            $index += 1;
            $aang = $pattern[$index - 1];
        } else $aang = $pattern[$i - 1];

        // Buat baris baru ketika kolom sudah mencapai 8
        if ($i % 8 == 1) $tabel .= '<tr/>';

        // Seleksi warna tabel angka sesuai dengan pattern yang sudah dibuat
        if ($aang == 'h') {
            $tabel .= '<td style="background: #000;color:#fff;padding:5px 15px">' . $i . '</td>';
        } else {
            $tabel .= '<td style="padding:5px 15px">' . $i . '</td>';
        }
    }

    return '<table>' . $tabel . '</table>';
}
