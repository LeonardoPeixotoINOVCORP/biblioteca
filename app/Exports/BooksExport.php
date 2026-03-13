<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Book::with(['authors','publisher']);

        // Pesquisa
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];

            $query->where(function ($q) use ($search) {
                $q->where('title','like',"%{$search}%")
                  ->orWhereHas('authors', fn($q)=>$q->where('name','like',"%{$search}%"))
                  ->orWhereHas('publisher', fn($q)=>$q->where('name','like',"%{$search}%"));
            });
        }

        // Preço mínimo
        if (!empty($this->filters['price_min'])) {
            $query->where('price','>=',$this->filters['price_min']);
        }

        // Preço máximo
        if (!empty($this->filters['price_max'])) {
            $query->where('price','<=',$this->filters['price_max']);
        }

        // Ordenação
        $sort = $this->filters['sort'] ?? 'latest';

        match($sort) {
            'latest'     => $query->orderBy('created_at','desc'),
            'oldest'     => $query->orderBy('created_at','asc'),
            'title_asc'  => $query->orderBy('title','asc'),
            'title_desc' => $query->orderBy('title','desc'),
            'price_asc'  => $query->orderBy('price','asc'),
            'price_desc' => $query->orderBy('price','desc'),
        };

        return $query->get()->map(function ($book) {
            return [
                $book->id,
                $book->isbn,
                $book->title,
                $book->authors->pluck('name')->join(', '),
                $book->publisher?->name,
                $book->bibliography,
                $book->cover ? asset('storage/'.$book->cover) : null,
                $book->price,
                $book->created_at,
                $book->updated_at
            ];
        });
    }

    public function headings(): array
    {
        return [
            'id',
            'ISBN',
            'Título',
            'Autores',
            'Editora',
            'Bibliografia',
            'Capa',
            'Preço',
            'Criado em',
            'Atualizado em'
        ];
    }
}