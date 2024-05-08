<?php

namespace App\Controller;

use App\Entity\Storage;
use App\RequestValidator\StorageGetRequestValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class StorageController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    #[Route('/storage/{id}/', methods: ["GET"])]
    public function index(Request $request, string $id): JsonResponse
    {
        $page = $request->query->get('page');
        $data = ['id' => $id, 'page' => $page];
        $data = (new StorageGetRequestValidator())->validated($data);


        $s = $this->em->getRepository(Storage::class);
        $result = $s->findItems($data['id'], $data['page'], 5);

        if (empty($result))
        {
            return new JsonResponse(["message" => "No items found."]);
        }
        return new JsonResponse($result);
    }
}
