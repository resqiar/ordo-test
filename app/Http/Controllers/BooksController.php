<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\Rules\Enum;
use Mauricius\LaravelHtmx\Http\HtmxRequest;
use Mauricius\LaravelHtmx\Http\HtmxResponseClientRedirect;
use Mauricius\LaravelHtmx\Http\HtmxResponseClientRefresh;

enum BookStatus: string
{
    case DRAFTED = "Draft";
    case PUBLISHED = "Published";
    case ARCHIVED = "Archived";
}

class BooksController extends Controller
{
    public function indexPage()
    {
        $books = Book::all();
        return view("index", ["data" => $books]);
    }

    public function detailPage($id)
    {
        $book = Book::where("id", $id)->whereNot("status", "Draft")->firstOrFail();
        return view("detail", ["data" => $book]);
    }

    public function editPage($id)
    {
        $book = Book::find($id);
        return view("edit", ["data" => $book]);
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

    public function edit($id, HtmxRequest $request)
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
            $book = Book::findOrFail($id);

            // delete old image from the disk
            if ($path && $book->image_path) {
                Storage::disk("uploads")->delete($book->image_path);
            }

            // update attr
            $book->name = $request->input("book_name");
            $book->description = $request->input("book_description", "");
            $book->author = $request->input("book_author");
            $book->status = $request->input("book_status");
            if ($path) {
                $book->image_path = $path;
            }

            // save the attr.
            // ideally i need to make a transaction for this type of op, 
            // but i dont have much more time to research on that.
            $book->save();

            // redirect back as a response back to "/"
            return new HtmxResponseClientRedirect("/");
        } catch (ModelNotFoundException $e) {
            dump($e);
            return response()->view("components.error-alert", [
                "error" => new MessageBag(["Book Not Found"])
            ]);
        } catch (\Exception $e) {
            dump($e);
            return response()->view("components.error-alert", [
                "error" => new MessageBag(["Something went wrong, please try again later."])
            ]);
        }
    }

    public function delete($id)
    {
        try {
            $book = Book::findOrFail($id);

            // if book is archived, prevent it from deleted.
            if ($book->status == "Archived") {
                return response()->view("components.error-alert", [
                    "error" => new MessageBag(["Book is archived and can't be deleted."])
                ]);
            }

            // delete old image from the disk (if any)
            if ($book->image_path) {
                Storage::disk("uploads")->delete($book->image_path);
            }

            // delete op.
            // ideally i need to make a transaction for this type of op, 
            // but i dont have much more time to research on that.
            $book->delete();

            // redirect back as a response back to "/"
            return new HtmxResponseClientRefresh();
        } catch (ModelNotFoundException $e) {
            dump($e);
            return response()->view("components.error-alert", [
                "error" => new MessageBag(["Book Not Found"])
            ]);
        } catch (\Exception $e) {
            dump($e);
            return response()->view("components.error-alert", [
                "error" => new MessageBag(["Something went wrong, please try again later."])
            ]);
        }
    }
}
