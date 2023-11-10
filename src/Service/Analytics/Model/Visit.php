<?php

namespace App\Service\Analytics\Model;

use DateTimeImmutable;

class Visit
{
    public DateTimeImmutable $date;

    public int $value;

    public function __construct(DateTimeImmutable $date, int $value)
    {
        $this->date = $date;
        $this->value = $value;
    }
}