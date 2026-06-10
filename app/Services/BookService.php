<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function store(array $data)
    {
        return Book::create($data);
    }
}