<?php

use App\Interfaces\TicketRepositoryInterface;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Front\TicketController;
use \App\Http\Controllers\Front\ReplyController;

// Make the route redirect to the tickets index
Route::get('/', function () {
    return redirect()->route('tickets.index');
});

// Tickets Route Resource
Route::resource('/tickets', TicketController::class);

// Replies Route Resource
Route::resource('/replies', ReplyController::class);

// A specific Ticket Replies Route
Route::get('/ticket/{ticket}/replies', [TicketController::class, 'replies'])->name('ticket.replies');
