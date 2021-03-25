<?php

namespace App\Http\Controllers\Web;

use App\Dto\EnquiryDto;
use App\Http\Controllers\Controller;
use App\Mail\EnquiryReceived;
use App\Mail\NotifyClientEnquiryReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EnquiryController extends Controller
{
    // public function submit(Request $request)
    // {
    //     // Validation
    //     $validator = $this->validate($request, [
    //         'name' => 'required|string',
    //         'email' => 'required|email',
    //         'phone' => 'required|string',
    //         'company' => 'nullable|string',
    //         'subject' => 'required|string',
    //         'budget' => 'required|string',
    //         'description' => 'required|string'
    //     ]);

    //     $enquiryDto = new EnquiryDto();
    //     $enquiryDto->setName($request->input('name'));
    //     $enquiryDto->setEmail($request->input('email'));
    //     $enquiryDto->setPhone($request->input('phone'));
    //     $enquiryDto->setCompany($request->input('company'));
    //     $enquiryDto->setSubject($request->input('subject'));
    //     $enquiryDto->setBudget($request->input('budget'));
    //     $enquiryDto->setDescription($request->input('description'));

    //     Mail::to(resolve('Setting')->getEnquiryReceiver())
    //         ->send(new EnquiryReceived($enquiryDto));

    //     Mail::to($enquiryDto->getEmail())
    //         ->send(new NotifyClientEnquiryReceived($enquiryDto));

    //     return [true];
    // }

    public function submit(Request $request)
    {
        // Validation
        $validator = $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'interest' => 'array',
            'message' => 'required|string'
        ]);

        $enquiryDto = new EnquiryDto();
        $enquiryDto->setName($request->input('name'));
        $enquiryDto->setEmail($request->input('email'));
        $enquiryDto->setPhone($request->input('phone_number'));
        $enquiryDto->setInterest($request->input('interest'));
        $enquiryDto->setMessage($request->input('message'));

        Mail::to(resolve('Setting')->getEnquiryReceiver())
            ->send(new EnquiryReceived($enquiryDto));

        Mail::to($enquiryDto->getEmail())
            ->send(new NotifyClientEnquiryReceived($enquiryDto));

        return [true];
    }
}
