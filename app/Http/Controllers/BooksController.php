<?php

namespace App\Http\Controllers;

use Mauricius\LaravelHtmx\Http\HtmxRequest;

class BooksController extends Controller
{
    public function create(HtmxRequest $request)
    {
        $book_name = $request->input("book_name");
        $book_desc = $request->input("book_description");
        $book_author = $request->input("book_author");
        $book_status = $request->input("book_status");

        dump($book_name, $book_desc, $book_author, $book_status);

        return $book_name;
    }
}
