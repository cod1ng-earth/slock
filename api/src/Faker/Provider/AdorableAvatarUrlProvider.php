<?php

declare(strict_types=1);

namespace App\Faker\Provider;

use Faker\Provider;

/**
 * @see http://avatars.adorable.io
 */
final class AdorableAvatarUrlProvider extends Provider\Base
{
    public function adorableAvatarUrl(string $userName, int $size): string
    {
        return sprintf(
            'https://api.adorable.io/avatars/%d/%s.png',
            $userName,
            $size
        );
    }
}
