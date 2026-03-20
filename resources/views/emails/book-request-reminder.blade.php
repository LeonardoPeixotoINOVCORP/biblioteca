<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; background: #f3f4f6; margin: 0; padding: 0; }
        .wrapper { max-width: 560px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
        .header { background: #b45309; padding: 32px; text-align: center; }
        .header h1 { color: #fff; margin: 0; font-size: 20px; font-weight: 700; letter-spacing: 0.5px; }
        .header p { color: #fde68a; margin: 6px 0 0; font-size: 13px; }
        .body { padding: 32px; }
        .greeting { font-size: 15px; color: #374151; margin-bottom: 24px; }
        .alert { background: #fef9c3; border: 1px solid #fde047; border-radius: 10px; padding: 14px 18px; margin-bottom: 24px; font-size: 13px; color: #854d0e; font-weight: 600; }
        .book-card { display: flex; gap: 20px; align-items: flex-start; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 24px; }
        .book-cover { width: 72px; height: 96px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); flex-shrink: 0; }
        .book-cover-placeholder { width: 72px; height: 96px; background: #e5e7eb; border-radius: 6px; flex-shrink: 0; }
        .book-info h2 { margin: 0 0 8px; font-size: 16px; color: #111827; font-weight: 700; }
        .book-info p { margin: 0; font-size: 13px; color: #6b7280; }
        .details { margin-bottom: 24px; }
        .detail-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #6b7280; font-weight: 600; text-transform: uppercase; font-size: 11px; letter-spacing: 0.5px; }
        .detail-value { color: #111827; font-weight: 500; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px 32px; text-align: center; font-size: 12px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>Lembrete de devolução</p>
        </div>

        <div class="body">
            <p class="greeting">
                Olá, <strong>{{ $bookRequest->user->name }}</strong>!
            </p>

            <div class="alert">
                O prazo de devolução do livro abaixo termina <strong>amanhã</strong>.
            </div>

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

            <div class="details">
                <div class="detail-row">
                    <span class="detail-label">Devolução Limite</span>
                    <span class="detail-value">{{ \Carbon\Carbon::parse($bookRequest->due_date)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>

        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }} · Este é um email automático, não responda.
        </div>
    </div>
</body>
</html>