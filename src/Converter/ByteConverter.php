<?php

namespace App\Converter;

class ByteConverter implements ByteConverterInterface
{
    public function convert(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 Octet';
        }

        $symbols = ['Octets', 'Ko', 'Mo', 'Go', 'To', 'Po', 'Eo', 'Zo', 'Yo'];
        $exp = floor(log($bytes) / log(1024));

        return number_format($bytes / pow(1024, floor($exp)), 2, ',', ' ') . ' ' . $symbols[$exp];
    }
}