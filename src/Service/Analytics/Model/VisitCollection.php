<?php

namespace App\Service\Analytics\Model;

class VisitCollection
{
    /**
     * @var Visit[]
     */
    public array $data;

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
}