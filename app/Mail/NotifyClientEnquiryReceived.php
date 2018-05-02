<?php

namespace App\Mail;

use App\Dto\EnquiryDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyClientEnquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiryDto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EnquiryDto $enquiryDto)
    {
        $this->enquiryDto = $enquiryDto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('We\'ve received your enquiry')
            ->view('email.notify-client-enquiry');
    }
}
