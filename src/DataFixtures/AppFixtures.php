<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class AppFixtures extends Fixture
{
    /**
     * @param array<int, array<string, mixed>> $blocks
     * @return string
     */
    protected function parseEditorJs(array $blocks): ?string
    {
        $json = json_encode([
            'time' => strtotime('now'),
            'blocks' => $blocks,
        ]);

        return !!$json ? $json : null;
    }
}
