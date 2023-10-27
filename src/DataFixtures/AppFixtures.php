<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class AppFixtures extends Fixture
{
    protected function parseEditorJs(array $blocks): string
    {
        return json_encode([
            'time' => strtotime('now'),
            'blocks' => $blocks,
        ]);
    }
}
