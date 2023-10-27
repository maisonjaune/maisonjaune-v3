<?php

namespace App\Converter;

interface ByteConverterInterface
{
    public function convert(float $bytes): string;
}