<?php

namespace App\Service\ServerInformations;

use Doctrine\DBAL\Connection;
use Exception;

class ServerInformationsProvider implements ServerInformationsProviderInterface
{
    private ?float $diskFreeSpace = null;

    private ?float $diskTotalSpace = null;

    private ?float $percentAvailableSpace = null;

    private ?float $bddUsedSpace = null;

    public function __construct(
        private Connection $connection,
    )
    {
    }

    public function getAvailableSpace(): float
    {
        if (null === $this->diskFreeSpace) {
            $value = disk_free_space('/');
            $this->diskFreeSpace = !!$value ? $value : 0;
        }

        return $this->diskFreeSpace;
    }

    /**
     * @throws Exception
     */
    public function getDatabaseUsedSpace(): float
    {
        if (null === $this->bddUsedSpace) {
            $stmt = $this->connection->prepare("SHOW TABLE STATUS");
            $resultSet = $stmt->executeQuery();
            $this->bddUsedSpace = 0;

            foreach ($resultSet->fetchAllAssociative() as $row) {
                $this->bddUsedSpace += $row["Data_length"] + $row["Index_length"];
            }
        }

        return $this->bddUsedSpace;
    }

    public function getTotalSpace(): float
    {
        if (null === $this->diskTotalSpace) {
            $value = disk_total_space('/');
            $this->diskTotalSpace = !!$value ? $value : 0;
        }

        return $this->diskTotalSpace;
    }

    public function getPercentAvailableSpace(): float
    {
        if (null === $this->percentAvailableSpace) {

            if (null === $this->diskFreeSpace) {
                $value = disk_free_space('/');
                $this->diskFreeSpace = !!$value ? $value : 0;
            }

            if (null === $this->diskTotalSpace) {
                $value = disk_total_space('/');
                $this->diskTotalSpace = !!$value ? $value : 0;
            }

            $this->percentAvailableSpace = ($this->diskFreeSpace * 100) / $this->diskTotalSpace;
        }

        return $this->percentAvailableSpace;
    }
}
