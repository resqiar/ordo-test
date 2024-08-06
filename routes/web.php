<?php

use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;

Route::get("/", [BooksController::class, "index"]);
Route::get("/book/{id}", [BooksController::class, "detail"]);

Route::get("/create", function () {
    return view("create");
});

Route::post("/create", [BooksController::class, "create"]);
