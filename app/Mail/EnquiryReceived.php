<?php

namespace App\Mail;

use App\Dto\EnquiryDto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnquiryReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $enquiryDto;

    /**
     * Create a new message instance.
     * EnquiryReceived constructor.
     *
     * @param EnquiryDto $enquiryDto
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
        return $this->from(config('mail.from.address'))
            ->subject('Enquiry received from '.app('Setting')->getSiteName())
            ->view('email.enquiry');
    }
}
