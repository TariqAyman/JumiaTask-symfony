<?php

namespace App\Controller;

use App\Repository\CountryRepository;
use App\Service\FilterPhoneNumberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var FilterPhoneNumberService
     */
    private $phoneNumberService;

    public function __construct(CountryRepository $countryRepository,
                                FilterPhoneNumberService $phoneNumberService)
    {
        $this->countryRepository = $countryRepository;
        $this->phoneNumberService = $phoneNumberService;
    }

    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        $countries = $this->countryRepository->fetchCountryForSelect();

        return $this->render('base.html.twig', [
            "countries" => $countries
        ]);
    }

    /**
     * @Route("/filter", name="filter")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request): JsonResponse
    {
        return $this->phoneNumberService->fetchPhoneNumber($request);
    }
}
