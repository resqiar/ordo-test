<?php

use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;

Route::get("/", [BooksController::class, "indexPage"]);
Route::get("/book/{id}", [BooksController::class, "detailPage"]);
Route::get("/edit/{id}", [BooksController::class, "editPage"]);

Route::get("/create", function () {
    return view("create");
});

Route::post("/create", [BooksController::class, "create"]);
Route::post("/edit/{id}", [BooksController::class, "edit"]);
