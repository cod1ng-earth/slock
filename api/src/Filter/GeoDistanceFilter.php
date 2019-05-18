<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Booking;
use Doctrine\ORM\QueryBuilder;

final class GeoDistanceFilter extends AbstractContextAwareFilter
{
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
            !isset($values['latitude']) ||
            !isset($values['longitude']) ||
            !isset($values['distance'])
        ) {
            return;
        }

        if (Booking::class === $resourceClass) {
            $queryBuilder
                ->innerJoin('o.slot', 'slot')
                ->innerJoin('slot.location', 'location')
            ;
        }

        $queryBuilder
            ->andWhere('contains(earth_box(ll_to_earth(:latitude, :longitude), :distance), ll_to_earth(location.latitude, location.longitude)) = TRUE')
            ->setParameter(':distance', $values['distance'])
            ->setParameter(':latitude', $values['latitude'])
            ->setParameter(':longitude', $values['longitude']);
    }

    /**
     * Gets the description of this filter for the given resource.
     *
     * Returns an array with the filter parameter names as keys and array with the following data as values:
     *   - property: the property where the filter is applied
     *   - type: the type of the filter
     *   - required: if this filter is required
     *   - strategy: the used strategy
     *   - is_collection (optional): is this filter is collection
     *   - swagger (optional): additional parameters for the path operation,
     *     e.g. 'swagger' => [
     *       'description' => 'My Description',
     *       'name' => 'My Name',
     *       'type' => 'integer',
     *     ]
     *   - openapi (optional): additional parameters for the path operation in the version 3 spec,
     *     e.g. 'openapi' => [
     *       'description' => 'My Description',
     *       'name' => 'My Name',
     *       'schema' => [
     *          'type' => 'integer',
     *       ]
     *     ]
     * The description can contain additional data specific to a filter.
     *
     * @see \ApiPlatform\Core\Swagger\Serializer\DocumentationNormalizer::getFiltersParameters
     */
    public function getDescription(string $resourceClass): array
    {
        // TODO: Implement getDescription() method.
        return [];
    }
}
