<?php


namespace App\Service;

use App\Repository\CustomerRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class FilterPhoneNumberService
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @param CustomerRepository $customerRepository
     */
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Format and validate  filter send, and filter phone numbers from database using filters
     * @param Request $request
     * @return JsonResponse
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function fetchPhoneNumber(Request $request): JsonResponse
    {
        $filters = $request->request->all();

        $data = $this->customerRepository->fetchFilterPhoneNumbers($filters);

        $count = $this->customerRepository->countFilterPhoneNumbers($filters);

        $response = [
            'data' => $data,
            'recordsTotal' => $count,
            'recordsFiltered' => $count
        ];

        return new JsonResponse($response);
    }
}
