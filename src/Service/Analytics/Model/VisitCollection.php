<?php

namespace App\Service\Analytics\Model;

use DateTimeImmutable;

class VisitCollection
{
    /**
     * @var Visit[]
     */
    public array $data = [];

    public function add(Visit $visit): self
    {
        $this->data[] = $visit;

        return $this;
    }

    /**
     * @return Visit[]
     */
    public function all(): array
    {
        return $this->data;
    }

    /**
     * @return array<DateTimeImmutable>
     */
    public function getDates(): array
    {
        return array_map(
            fn(Visit $visit) => $visit->date,
            $this->data
        );
    }

    /**
     * @return array<int>
     */
    public function getValues(): array
    {
        return array_map(
            fn(Visit $visit) => $visit->value,
            $this->data
        );
    }
}