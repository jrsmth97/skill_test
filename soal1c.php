<?php

$kalimat = 'Jakarta adalah ibukota negara Republik Indonesia';

// echo uBiTri($kalimat);

function uBiTri($kalimat)
{
    $arrayKalimat = explode(' ', $kalimat);

    // Buat unigram
    $unigram = str_replace(' ', ', ', $kalimat);

    // Buat bigram

    // Pisahkan array masing2 dua kata
    $arrayBigram = array_chunk($arrayKalimat, 2);

    $bigram = '';
    // Buat kalimat dari array bigram
    foreach ($arrayBigram as $key => $abi) {
        if ($key != count($arrayBigram) - 1) {
            $bigram .= implode(' ', $abi) . ', ';
        } else $bigram .= implode(' ', $abi);
    }

    // Pisahkan array masing2 tiga kata
    $arrayTrigram = array_chunk($arrayKalimat, 3);

    $trigram = '';
    // Buat kalimat dari array trigram
    foreach ($arrayTrigram as $key => $atr) {
        if ($key != count($arrayTrigram) - 1) {
            $trigram .= implode(' ', $atr) . ', ';
        } else $trigram .= implode(' ', $atr);
    }

    return 'Unigram : ' . $unigram . '<br/>Bigram : ' . $bigram . '<br/>Trigram : ' . $trigram;
}
