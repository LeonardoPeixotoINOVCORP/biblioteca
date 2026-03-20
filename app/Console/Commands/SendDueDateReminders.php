<?php

namespace App\Console\Commands;

use App\Mail\BookRequestReminder;
use App\Models\BookRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDueDateReminders extends Command
{
    protected $signature   = 'reminders:due-date';
    protected $description = 'Envia emails de lembrete para requisições com entrega amanhã';

    public function handle()
    {
        $tomorrow = now()->addDay()->toDateString();

        $requests = BookRequest::with(['user', 'book.authors', 'book.publisher'])
            ->where('status', 'aprovada')
            ->whereDate('due_date', $tomorrow)
            ->get();

        foreach ($requests as $bookRequest) {
            Mail::to($bookRequest->user->email)
                ->send(new BookRequestReminder($bookRequest));

            $this->info("Reminder enviado para: {$bookRequest->user->email}");
        }

        $this->info("Total: {$requests->count()} reminder(s) enviado(s).");
    }
}