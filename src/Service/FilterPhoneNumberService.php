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
     */
    public function fetchPhoneNumber(Request $request): JsonResponse
    {
        $filters = $request->request->all();

        $data = $this->customerRepository->queryFetchFilterPhoneNumbers($filters);

        $response['data'] = $data;

        return new JsonResponse($response);
    }
}
