<?php

namespace App\Http\Controllers;

use App\Book;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
   use ApiResponser;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of books.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return $this->successResponse($books);
    }

    /**
     * Create one new book.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',

        ];

        $this->validate($request, $rules);

        $books = Book::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * Obtain & show details of one book.
     *
     * @return Illuminate\Http\Response
     */
    public function show($book)
    {
        $book = Book::findorFail($book);
        return $this->successResponse($book);
    }

    /**
     * Update existing book
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author)
    {
        $rules = [
            'title' => 'max:255',
            'description' => 'max:255',
            'price' => 'min:1',
            'author_id' => 'min:1',

        ];
        $this->validate($request, $rules);

        $book = Book::findorFail($book);

        $book->fill($request->all());

        if($book->isCLean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->save();

        return $this->successResponse($book);
    }
    /**
     * Remove existing book
     *
     * @return Illuminate\Http\Response
     */
    public function destroy($book)
    {
        $book = Book::findorFail($book);

        $book->delete();
        
        return $this->successResponse($book);
    }
}
