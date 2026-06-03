<?php

namespace App\Http\Services;

use App\Http\Repositories\ExampleRepositoryInterface;

interface ExampleServiceInterface
{
    public function example();
}

class ExampleService implements ExampleServiceInterface
{
    protected $exampleRepository;

    public function __construct(
        ExampleRepositoryInterface $exampleRepository
    ) {
        $this->exampleRepository = $exampleRepository;
    }

    public function example()
    {
        return $this->exampleRepository->getExample();
    }
}
