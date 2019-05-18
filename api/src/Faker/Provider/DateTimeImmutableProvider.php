<?php

declare(strict_types=1);

namespace App\Faker\Provider;

use Faker\Provider;

final class DateTimeImmutableProvider extends Provider\Base
{
    public static function dateTimeImmutableBetween($startDate = '-30 years', $endDate = 'now', $timezone = null): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable(Provider\DateTime::dateTimeBetween(
            $startDate,
            $endDate,
            $timezone
        ));
    }
}
