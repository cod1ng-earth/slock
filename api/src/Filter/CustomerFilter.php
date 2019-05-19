<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractContextAwareFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\CustomerLocation;
use Doctrine\ORM\QueryBuilder;

final class CustomerFilter extends AbstractContextAwareFilter
{
    use AliasGeneratorTrait;

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

        $aliasCustomer = $this->createUniqueAlias('customer');

        switch ($resourceClass) {
            case CustomerLocation::class:
                $queryBuilder->innerJoin('o.customer', $aliasCustomer);
                break;

            default:
                return;
        }

        $queryBuilder
            ->andWhere(sprintf('%s.id = :customer_id', $aliasCustomer))
            ->setParameter(':customer_id', $value);
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
            $description[$property] = [
                'property' => $property,
                'type' => 'int',
                'required' => false,
            ];
        }

        return $description;
    }
}
