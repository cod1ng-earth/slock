<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Booking;
use App\Entity\CustomerLocation;
use Doctrine\ORM\QueryBuilder;

final class LocationFilter extends AbstractContextAwareFilter
{
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        string $operationName = null
    ) {
        // otherwise filter is applied to order and page as well
        if (!$this->isPropertyEnabled($property, $resourceClass)) {
            return;
        }

        if ((int) $value <= 0) {
            return;
        }

        switch ($resourceClass) {
            case Booking::class:
                $queryBuilder->innerJoin('o.slot', 'slot');
                $columnName = 'slot.location_id';
                break;

            case CustomerLocation::class:
                $columnName = 'o.location_id';
                break;

            default:
                return;
        }

        $queryBuilder
            ->andWhere(sprintf('%s = :location_id', $columnName))
            ->setParameter(':location_id', $value);
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
