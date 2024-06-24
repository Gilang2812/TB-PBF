<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\DetailTransactionModel;
use Carbon\Carbon;

class SendOverdueReminderEmails extends Command
{
    protected $signature = 'emails:send-overdue-reminders';
    protected $description = 'Send overdue reminder emails to users';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();

        $overdueTransactions = DetailTransactionModel::with('peminjaman.user', 'peminjaman.durasi')
            ->whereHas('peminjaman', function ($query) use ($today) {
                // We will get all transactions, and calculate due dates later
                // Only transactions that are not returned yet
                $query->whereNull('tanggal_pengembalian');
            })
            ->get();

        foreach ($overdueTransactions as $transaction) {
            $peminjaman = $transaction->peminjaman;
            $user = $peminjaman->user;
            $tanggalPeminjaman = Carbon::parse($peminjaman->tanggal_peminjaman);
            $dueDate = $tanggalPeminjaman->addDays($peminjaman->durasi?->durasi??7);

            if ($dueDate->lessThan($today)) {
                $this->sendReminderEmail($user->email, $dueDate);
            }
        }

        $this->info('Overdue reminder emails have been sent successfully.');
    }

    protected function sendReminderEmail($email, $dueDate)
    {
        Mail::send('emails.overdue_reminder', ['dueDate' => $dueDate], function ($message) use ($email) {
            $message->to($email)
                ->subject('Overdue Book Reminder');
        });
    }
}
