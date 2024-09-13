<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 8;
        $sortBy = $request->query('sort', 'title'); // default sort by title
        $order = $request->query('order', 'asc'); // default sort order
    
        // Validate `sortBy` and `order` parameters
        $validSortBy = ['title', 'price', 'author']; // Add other valid sort columns
        $validOrder = ['asc', 'desc'];
    
        if (!in_array($sortBy, $validSortBy)) {
            $sortBy = 'title'; // Fallback to default
        }
    
        if (!in_array($order, $validOrder)) {
            $order = 'asc'; // Fallback to default
        }
    
        $books = Book::with('stores')
            ->orderBy($sortBy, $order)
            ->paginate($perPage);
    
        return new BookCollection($books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{

    // Validate the incoming request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'isbn' => 'required|string|max:13',
        'description' => 'required|string',
        'format' => 'required|string',
        'page_count' => 'required|integer',
        'price' => 'required|numeric',
        'publisher_id' => 'required|integer|exists:publishers,id',
        'author_id' => 'required|integer|exists:authors,id',
        'image' => 'required|image',
        'genres.*' => 'exists:genres,name'
    ]);

   

    $imageName = time().'.'.$request->image->extension();
    $request->image->move(public_path('images'), $imageName);

    // Create a new book with validated data
    $book = Book::create([
        'title' => $validated['title'],
        'author_id' => $validated['author_id'],
        'publisher_id' => $validated['publisher_id'],
        'price' => $validated['price'],
        'isbn' => $validated['isbn'],
        'description' => $validated['description'],
        'page_count' => $validated['page_count'],
        'format' => $validated['format'],
        'cover_image_path' => 'images/' . $imageName, // Can be null if no image uploaded
    ]);

     // Attach genres to the book
     if ($request->has('genres') && is_array($request->genres)) {
        $genreIds = Genre::whereIn('name', $request->genres)->pluck('id')->toArray();
        $book->genres()->attach($genreIds);
    }

    // // Handle attaching stores and stock (ensure `stores` is an array of data)
    if ($request->has('stores') && is_array($request->stores)) {
        foreach ($request->stores as $storeData) {
            $book->stores()->attach($storeData['store_id'], ['stock' => $storeData['stock']]);
        }
    }

    // Return a success response with the newly created book resource
    return response()->json([
        'message' => 'Book created successfully',
        'book' => new BookResource($book),
    ], 201);
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

        // Validiraj dolazni zahtev
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|integer|exists:authors,id',
            'publisher_id' => 'sometimes|required|integer|exists:publishers,id',
            'price' => 'sometimes|required|numeric',
            'isbn' => 'sometimes|required|string|max:13',
            'description' => 'sometimes|required|string',
            'page_count' => 'sometimes|required|integer',
            'stores' => 'sometimes|array',
            'stores.*.store_id' => 'required_with:stores|integer|exists:stores,id',
            'stores.*.stock' => 'required_with:stores|integer|min:0',
        ]);
    
        // Ažuriraj samo prisutna polja
        $book->update($validated);
    
        // Sinhronizuj prodavnice i zalihe
        if (isset($validated['stores'])) {
            $book->stores()->sync([]);
            foreach ($validated['stores'] as $storeData) {
                $book->stores()->attach($storeData['store_id'], ['stock' => $storeData['stock']]);
            }
        }
    
        return response()->json([
            'message' => 'Book updated successfully',
            'book' => new BookResource($book),
        ]);
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

    public function search(Request $request)
    {
        $query = $request->input('query');
        
        Log::info('Search query: ' . $query); // Log the query for debugging

        if (!$query) {
            return response()->json([]);
        }

        // Search books where the title contains the query
        try {
            $books = Book::where('title', 'ILIKE', "%{$query}%")->get();
            return response()->json(new BookCollection($books));
        } catch (\Exception $e) {
            Log::error('Error during search: ' . $e->getMessage()); // Log any exception
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}