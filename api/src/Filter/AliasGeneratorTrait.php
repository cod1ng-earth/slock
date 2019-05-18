<?php

declare(strict_types=1);

namespace App\Filter;

trait AliasGeneratorTrait
{
    private function createUniqueAlias($alias): string
    {
        return sprintf('%s_%s', $alias, sha1(uniqid('', true)));
    }
}
