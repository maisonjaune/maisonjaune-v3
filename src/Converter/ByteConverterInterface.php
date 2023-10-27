<?php

namespace App\Converter;

interface ByteConverterInterface
{
    public function convert(int $bytes): string;
}