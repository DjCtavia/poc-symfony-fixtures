<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\BookDto;
use App\Entity\Book;
use App\Service\BookService;
use App\Service\ValidationService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\SerializerInterface;

#[OA\Tag(name: 'Book')]
class BookController extends AbstractController
{
    public function __construct(
        private readonly BookService         $bookService,
        private readonly ValidationService   $validator,
        private readonly SerializerInterface $serializer,
    )
    {
    }

    #[Route('/api/v1/book', name: 'create_book', methods: ['POST'], format: 'json')]
    #[OA\RequestBody(required: true, content: new OA\JsonContent(ref: new Model(type: BookDto::class)))]
    #[OA\Response(
        response: 201,
        description: 'Book created successfully',
        content: new OA\JsonContent(
            properties: [new OA\Property(property: 'id', type: 'string')],
            type: 'object',
        )
    )]
    #[OA\Response(
        response: 400,
        description: 'Validation error',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string'),
                new OA\Property(property: 'errors', type: 'array', items: new OA\Items(type: 'string'))
            ],
            type: 'object')
    )]
    public function create(
        #[MapRequestPayload] BookDto $bookDto,
    ): Response
    {
        if ($validationRes = $this->validator->validateAndReturnResponse($bookDto, ['create'])) {
            return $validationRes;
        }

        $bookId = $this->bookService->create($bookDto);

        return $this->json([
            'message' => "Book created successfully with id $bookId",
        ], Response::HTTP_CREATED);
    }

    #[Route('api/v1/book/{id}', name: 'read_book', methods: ['GET'], format: 'json')]
    #[OA\Response(
        response: 200,
        description: 'Book details',
        content: new OA\JsonContent(
            ref: new Model(type: Book::class, groups: ['read'])
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Book not found',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'message', type: 'string')
            ],
            type: 'object'
        )
    )]
    public function read(string $id): Response
    {
        $book = $this->bookService->read($id);

        if (!$book) {
            return $this->json([
                'message' => 'Book not found'
            ], Response::HTTP_NOT_FOUND);
        }
        $bookJson = $this->serializer->serialize($book, 'json', ['groups' => 'read']);

        return $this->json(json_decode($bookJson, true));
    }
}