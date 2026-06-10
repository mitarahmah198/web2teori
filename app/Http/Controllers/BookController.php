<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    // Tampilkan data
    public function index()
    {
        return response()->json(Book::all());
    }

    // Tambah data
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'year' => 'required|integer'
        ]);

        try {
            $book = $this->bookService->store($validated);

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
                'data' => $book
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal menambah data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Ubah data
    public function update(Request $request, $id)
    {
        try {

            $book = Book::findOrFail($id);

            $book->update([
                'title' => $request->title,
                'author' => $request->author,
                'year' => $request->year
            ]);

            return response()->json([
                'message' => 'Data berhasil diubah'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal mengubah data'
            ], 500);
        }
    }

    // Hapus data
    public function destroy($id)
    {
        try {

            Book::findOrFail($id)->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Gagal menghapus data'
            ], 500);
        }
    }
}