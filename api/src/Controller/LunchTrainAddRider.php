<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\LunchTrain;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LunchTrainAddRider
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(LunchTrain $data, $rider_id)
    {
        /** @var Customer|null $customer */
        $customer = $this->em->find(Customer::class, $rider_id);

        if (!$customer) {
            throw new NotFoundHttpException("Rider $rider_id not found");
        }

        $data->addRider($customer);
        $this->em->flush();

        return $data;
    }
}
