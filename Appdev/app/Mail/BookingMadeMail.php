<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingMadeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $type;

    public function __construct($booking, $type)
    {
        $this->booking = $booking;
        $this->type = $type;
    }

    public function build()
    {
        return $this->subject('Booking Confirmation - ' . ucfirst($this->type) . ' Reserved')
                    ->view('emails.booking.made')
                    ->with([
                        'booking' => $this->booking,
                        'type' => $this->type,
                    ]);
    }
}