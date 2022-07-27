<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Interfaces\TicketRepositoryInterface;
use \App\Http\Controllers\Front\ReplyController;
use \App\Http\Controllers\Front\TicketController;

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

Route::get();