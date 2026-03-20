<?php

namespace App\Http\Controllers;

use App\Mail\BookRequestCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

use App\Models\Book;
use App\Models\BookRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BookRequestController extends Controller
{
    // Lista todas as requisições (admin vê todas, utilizador vê as suas)
    public function index(Request $request)
    {
        $query = BookRequest::with(['user', 'book'])->latest();

        if (!auth()->user()->hasRole('admin')) {
            $query->where('user_id', auth()->id());
        }

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por nome do utilizador
        if ($request->filled('user')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->user . '%'));
        }

        // Filtro por nome do livro
        if ($request->filled('book')) {
            $query->whereHas('book', fn($q) => $q->where('title', 'like', '%' . $request->book . '%'));
        }

        // Filtro por data
        if ($request->filled('date')) {
            $query->whereDate('requested_at', '>=', $request->date);
        }

        // Filtro por data de devolução
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', '<=', $request->due_date);
        }

        $isAdmin = auth()->user()->hasRole('admin');
        $userId  = auth()->id();

        return Inertia::render('BookRequests/Index', [
            'requests' => $query->get(),
            'filters'  => $request->only(['status', 'user', 'book', 'date', 'due_date']),
            'stats' => [
                'active' => BookRequest::whereIn('status', ['pendente', 'aprovada'])
                    ->when(!$isAdmin, fn($q) => $q->where('user_id', $userId))
                    ->count(),
                'last_30_days' => BookRequest::where('requested_at', '>=', now()->subDays(30))
                    ->when(!$isAdmin, fn($q) => $q->where('user_id', $userId))
                    ->count(),
                'returned_today' => BookRequest::where('status', 'devolvida')
                    ->whereDate('returned_at', today())
                    ->when(!$isAdmin, fn($q) => $q->where('user_id', $userId))
                    ->count(),
            ],
        ]);
    }

    // Formulário de criação de requisição
    public function create()
    {
        $activeRequests = BookRequest::where('user_id', auth()->id())
            ->whereIn('status', ['pendente', 'aprovada'])
            ->count();

        if ($activeRequests >= 3) {
            return redirect()
                ->route('book-requests.index')
                ->with('error', 'Atingiu o limite máximo de 3 requisições ativas.');
        }

        return Inertia::render('BookRequests/Create', [
            'books' => Book::where('available', true)->orderBy('title')->get(['id', 'title'])
        ]);
    }

    // Guardar nova requisição
    public function store(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
    
        $activeRequests = BookRequest::where('user_id', auth()->id())
            ->whereIn('status', ['pendente', 'aprovada'])
            ->count();
    
        if ($activeRequests >= 3) {
            return back()->with('error', 'Atingiu o limite máximo de 3 requisições ativas.');
        }
    
        $book = Book::findOrFail($data['book_id']);
    
        if (!$book->available) {
            return back()->withErrors(['book_id' => 'Este livro não está disponível.']);
        }
    
        $bookRequest = BookRequest::create([
            'user_id'      => auth()->id(),
            'book_id'      => $book->id,
            'status'       => 'pendente',
            'requested_at' => now(),
            'due_date'     => now()->addDays(5),
        ]);
    
        $book->update(['available' => false]);
    
        // Carrega as relações necessárias para o email
        $bookRequest->load(['user', 'book.authors', 'book.publisher']);
    
        // Email para o utilizador
        Mail::to($bookRequest->user->email)
            ->later(now(), new BookRequestCreated($bookRequest, isAdmin: false));

        $admins = User::role('admin')->get();
            
        // Email para todos os admins com delay crescente
        foreach ($admins as $index => $admin) {
            Mail::to($admin->email)
                ->later(now()->addSeconds(15 + ($index * 15)), new BookRequestCreated($bookRequest, isAdmin: true));
        };
        
        return redirect()
            ->route('book-requests.index')
            ->with('success', 'Requisição efetuada com sucesso!');
    }

    // Admin aprova requisição
    public function approve(BookRequest $bookRequest)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $bookRequest->update(['status' => 'aprovada']);

        return back()->with('success', 'Requisição aprovada.');
    }

    // Admin rejeita requisição
    public function reject(BookRequest $bookRequest)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $bookRequest->update(['status' => 'rejeitada']);

        // Livro volta a estar disponível
        $bookRequest->book->update(['available' => true]);

        return back()->with('success', 'Requisição rejeitada.');
    }

    // Marcar como devolvido
    public function returned(Request $request, BookRequest $bookRequest)
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'returned_at' => ['required', 'date'],
        ]);

        $bookRequest->update([
            'status'      => 'devolvida',
            'returned_at' => $request->returned_at,
        ]);

        // Livro volta a estar disponível
        $bookRequest->book->update(['available' => true]);

        return back()->with('success', 'Devolução registada.');
    }

    public function destroy(BookRequest $bookRequest)
    {
        $bookRequest->book->update(['available' => true]);

        $bookRequest->delete();

        return back()->with('success', 'Requisição apagada.');
    }

    public function clear()
    {
        Book::query()->update(['available' => true]);
        
        BookRequest::truncate(); 

        return back()->with('success', 'Requisições apagadas.');
    }
}