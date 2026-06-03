<?php

namespace App\Http\Repositories;

interface ExampleRepositoryInterface
{
    public function getExample();
}

class ExampleRepository implements ExampleRepositoryInterface
{
    public function __construct(

    ) {
    }

    public function getExample()
    {
        return 'example';
    }
}
