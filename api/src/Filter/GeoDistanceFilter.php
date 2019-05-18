<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Booking;
use Doctrine\ORM\QueryBuilder;

final class GeoDistanceFilter extends AbstractContextAwareFilter
{
    use AliasGeneratorTrait;

    const PARAMETER_DISTANCE = 'distance';
    const PARAMETER_LATITUDE = 'latitude';
    const PARAMETER_LONGITUDE = 'longitude';

    protected function filterProperty(
        string $property,
        $values,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {
        // otherwise filter is applied to order and page as well
        if (!$this->isPropertyEnabled($property, $resourceClass)) {
            return;
        }

        if (!is_array($values) ||
            !isset($values[self::PARAMETER_LATITUDE]) ||
            !isset($values[self::PARAMETER_LONGITUDE]) ||
            !isset($values[self::PARAMETER_DISTANCE])
        ) {
            return;
        }

        if (Booking::class !== $resourceClass) {
            return;
        }

        $aliasSlot = $this->createUniqueAlias('slot');
        $aliasLocation = $this->createUniqueAlias('location');

        $queryBuilder
            ->innerJoin('o.slot', $aliasSlot)
            ->innerJoin(sprintf('%s.location', $aliasSlot), $aliasLocation);

        $earthBox = 'earth_box(ll_to_earth(:latitude, :longitude), :distance)';
        $lltoEarth = sprintf('ll_to_earth(%1$s.latitude, %1$s.longitude)', $aliasLocation);
        $condition = sprintf('contains(%s,%s) = TRUE', $earthBox, $lltoEarth);
        $queryBuilder
            ->andWhere($condition)
            ->setParameter(':distance', $values[self::PARAMETER_DISTANCE])
            ->setParameter(':latitude', $values[self::PARAMETER_LATITUDE])
            ->setParameter(':longitude', $values[self::PARAMETER_LONGITUDE]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(string $resourceClass): array
    {
        $description = [];

        $properties = $this->getProperties();
        if (null === $properties) {
            $properties = array_fill_keys($this->getClassMetadata($resourceClass)->getFieldNames(), null);
        }

        foreach ($properties as $property => $unused) {
            $description += $this->getFilterDescription($property, self::PARAMETER_LATITUDE);
            $description += $this->getFilterDescription($property, self::PARAMETER_LONGITUDE);
            $description += $this->getFilterDescription($property, self::PARAMETER_DISTANCE, 'int');
        }

        return $description;
    }

    private function getFilterDescription(string $property, string $parameter, string $type = 'float'): array
    {
        return [
            sprintf('%s[%s]', $property, $parameter) => [
                'property' => $property,
                'type' => $type,
                'required' => true,
            ],
        ];
    }
}
