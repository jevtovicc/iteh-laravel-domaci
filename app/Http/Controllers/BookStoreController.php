<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookStoreController extends Controller
{
    public function getStoresForBook($bookId)
    {
        // Pronađi knjigu
        $book = Book::find($bookId);

        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        // Pronađi radnje u kojima je knjiga dostupna
        $stores = $book->stores;

        return response()->json($stores);
    }
}