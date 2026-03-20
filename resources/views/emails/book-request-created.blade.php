<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; background: #f3f4f6; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .header { background: #1f2937; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 20px; font-weight: 700; letter-spacing: 0.5px; }
        .header p { color: #9ca3af; margin: 6px 0 0; font-size: 13px; }
        .body { padding: 32px; }
        .greeting { font-size: 15px; color: #374151; margin-bottom: 24px; }
        .book-card { display: flex; gap: 20px; align-items: flex-start; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .book-cover { width: 72px; height: 96px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); flex-shrink: 0; }
        .book-cover-placeholder { width: 72px; height: 96px; background: #e5e7eb; border-radius: 6px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 11px; }
        .book-info h2 { margin: 0 0 8px; font-size: 16px; color: #111827; font-weight: 700; }
        .book-info p { margin: 0; font-size: 13px; color: #6b7280; }
        .details { margin-bottom: 24px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #6b7280; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        .detail-value { color: #111827; font-weight: 500; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: capitalize; background: #fef9c3; color: #854d0e; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>
                {{ $isAdmin 
                    ? 'Nova requisição feita por ' . $bookRequest->user->name 
                    : 'A sua requisição foi recebida' 
                }}
            </p> 
       </div>

        <div class="body">
            <p class="greeting">
                @if($isAdmin)
                    Uma nova requisição foi submetida por <strong>{{ $bookRequest->user->name }}</strong>.
                @else
                    Olá, <strong>{{ $bookRequest->user->name }}</strong>! A sua requisição foi recebida e está a aguardar aprovação.
                @endif
            </p>

            <!-- Livro -->
            <div class="book-card">
               @if($bookRequest->book->cover)
                    @php
                        $path = storage_path('app/public/' . $bookRequest->book->cover);
                        $mime = mime_content_type($path);
                        $data = base64_encode(file_get_contents($path));
                    @endphp
                    <img src="data:{{ $mime }};base64,{{ $data }}" alt="{{ $bookRequest->book->title }}" style="width:72px;height:96px;object-fit:cover;border-radius:6px;box-shadow:0 2px 8px rgba(0,0,0,0.15);" />
                @else
                    <div style="width:72px;height:96px;background:#e5e7eb;border-radius:6px;"></div>
                @endif

                <div class="book-info">
                    <h2>{{ $bookRequest->book->title }}</h2>
                    <p>
                        @if($bookRequest->book->authors->isNotEmpty())
                            {{ $bookRequest->book->authors->pluck('name')->join(', ') }}
                        @endif
                    </p>
                    @if($bookRequest->book->publisher)
                        <p style="margin-top: 4px;">{{ $bookRequest->book->publisher->name }}</p>
                    @endif
                </div>
            </div>

            <!-- Detalhes -->
            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Estado</span>
                    <span class="badge">{{ $bookRequest->status }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Data de Requisição</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($bookRequest->requested_at)->format('d/m/Y') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Devolução Limite</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($bookRequest->due_date)->format('d/m/Y') }}</span>
                </div>
                @if($isAdmin)
                <div class="detail-row">
                    <span class="detail-label">Utilizador</span>
                    <span class="detail-value">{{ $bookRequest->user->name }} — {{ $bookRequest->user->email }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }} · Este é um email automático, não responda.
        </div>
    </div>
</body>
</html>