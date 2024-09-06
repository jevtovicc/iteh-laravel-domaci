<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return new BookCollection($books);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'store_id' => $request->store_id,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return response()->json(['Book created successfully', new BookResource($book)]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $book->title = $request->title;
        $book->author_id = $request->author_id;
        $book->publisher_id = $request->publisher_id;
        $book->store_id = $request->store_id;
        $book->price = $request->price;
        $book->stock = $request->stock;

        $book->save();

        return response()->json(['Book updated successfully', new BookResource($book)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json('Book deleted successfully');
    }
}
