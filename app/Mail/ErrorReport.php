<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ErrorReport extends Mailable
{
    use Queueable, SerializesModels;
    protected $exception;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($exception = array())
    {
        $this->exception = $exception;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.error.report')->with($this->exception);
    }
}
