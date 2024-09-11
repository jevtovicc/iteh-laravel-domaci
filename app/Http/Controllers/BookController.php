<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Store;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all books and their related stores with stock
        $books = Book::with('stores')->get();
        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Create a new book
        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'price' => $request->price,
        ]);

        // Associate book with stores and stock via pivot table
        if ($request->stores) {
            foreach ($request->stores as $storeData) {
                $book->stores()->attach($storeData['store_id'], ['stock' => $storeData['stock']]);
            }
        }

        return response()->json(['Book created successfully', new BookResource($book), 201]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // Load related stores and stock for the specific book
        $book->load('stores');
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // Update the book details
        $book->update([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'price' => $request->price,
        ]);

        // Sync the stores and stock via pivot table
        if ($request->stores) {
            $book->stores()->sync([]);
            foreach ($request->stores as $storeData) {
                $book->stores()->attach($storeData['store_id'], ['stock' => $storeData['stock']]);
            }
        }

        return response()->json(['Book updated successfully', new BookResource($book)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        // Detach book from stores and delete the book
        $book->stores()->detach();
        $book->delete();

        return response()->json('Book deleted successfully');
    }
}