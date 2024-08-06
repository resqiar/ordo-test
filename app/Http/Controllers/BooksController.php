<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rules\Enum;
use Mauricius\LaravelHtmx\Http\HtmxRequest;
use Mauricius\LaravelHtmx\Http\HtmxResponseClientRedirect;

enum BookStatus: string
{
    case DRAFTED = "Draft";
    case PUBLISHED = "Published";
    case ARCHIVED = "Archived";
}

class BooksController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view("index", ["data" => $books]);
    }

    public function detail($id)
    {
        $book = Book::where("id", $id)->whereNot("status", "Draft")->firstOrFail();
        return view("detail", ["data" => $book]);
    }

    public function create(HtmxRequest $request)
    {
        $validator = Validator::make($request->all(), [
            "book_name" => "required|string|max:100",
            "book_description" => "string|nullable",
            "book_author" => "required|string|max:100",
            "book_status" => ["required", "string", new Enum(BookStatus::class)],
            "book_cover" => "nullable|image|mimes:jpeg,png,jpg,gif|max:5048",
        ]);

        if ($validator->fails()) {
            return response()->view("components.error-alert", [
                "error" => $validator->errors()
            ]);
        }

        $path = "";

        // if there is a cover file, save it to the local storage.
        // iam going to make an arbitrary folder in public/uploads/media.
        // get the unique path and we are good to go.
        if ($request->hasFile("book_cover")) {
            $path = $request->file("book_cover")->store("media", "uploads");
        }

        try {
            // create a book, iam surprised how convenient laravel is with this,
            // there must be a tradeoff, need to research more on this.
            Book::create([
                "name" => $request->input("book_name"),
                "description" => $request->input("book_description", ""),
                "author" => $request->input("book_author"),
                "status" => $request->input("book_status"),
                "image_path" => $path,
            ]);

            // redirect back as a response back to "/"
            return new HtmxResponseClientRedirect("/");
        } catch (\Exception $e) {
            // if the error is about duplicate key, show meaningful, otherwise, throw generic.
            if (str_starts_with($e->getMessage(), "SQLSTATE[23000]")) {
                return response()->view("components.error-alert", [
                    "error" => new MessageBag(["Book with the same title already exist"])
                ]);
            } else {
                return response()->view("components.error-alert", [
                    "error" => new MessageBag(["Something went wrong, please try again later."])
                ]);
            }
        }
    }
}
