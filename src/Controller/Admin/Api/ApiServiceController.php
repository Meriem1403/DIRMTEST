<?php

namespace App\Controller\Admin\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServiceRepository;

class ApiServiceController extends AbstractController
{
    #[Route('/api/services/{id}/summary', name: 'api_service_summary', methods: ['GET'])]
    public function getServiceSummary(int $id, ServiceRepository $serviceRepository): JsonResponse
    {
        $service = $serviceRepository->find($id);

        if (!$service) {
            return new JsonResponse(['error' => 'Service not found'], 404);
        }

        return new JsonResponse([
            'types' => $service->getTypes(),
            'locations' => $service->getLocations()
        ]);
    }
}
