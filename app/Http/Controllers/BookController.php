<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {

        // Inicia a query com os relacionamentos necessários, ordenada pela mais recente
        $query = Book::with(['publisher', 'authors'])->latest();

        // Se existir um termo de pesquisa na query string (?search=...)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                // Filtra por título, ou por nome de autor, ou por nome de editora
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('authors', fn($q) => $q->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('publisher', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        // Filtro de preço mínimo
        if ($min = $request->input('price_min')) {
            $query->where('price', '>=', $min);
        }

        // Filtro de preço máximo
        if ($max = $request->input('price_max')) {
            $query->where('price', '<=', $max);
        }

        // Aplica a ordenação conforme o valor de ?sort=...
        match($request->input('sort', 'latest')) {
            'latest'     => $query->reorder('created_at', 'desc'),
            'oldest'     => $query->reorder('created_at', 'asc'),
            'title_asc'  => $query->reorder('title', 'asc'),
            'title_desc' => $query->reorder('title', 'desc'),
            'price_asc'  => $query->reorder('price', 'asc'),
            'price_desc' => $query->reorder('price', 'desc'),
        };

        // Pagina os resultados em grupos de 6
        $books = $query->simplePaginate(6);

        // Envia os livros e os filtros ativos para o componente Vue
        return Inertia::render('Books/Index', [
            'books' => $books,
            'filters' => array_merge(['sort' => 'latest'], $request->only(['search', 'sort', 'price_min', 'price_max']))
        ]);
    }

    public function show(Book $book)
    {
        $book->load(['publisher','authors']);

        return Inertia::render('Books/Show', [
            'book' => $book
        ]);
    }
}
