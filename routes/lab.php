<?php

/*
|--------------------------------------------------------------------------
| Lab Routes
|--------------------------------------------------------------------------
|
| Containing route to preview and testing purpose
|
*/

Route::group(['namespace' => 'Web'], function () {
    // Preview notification
    Route::get('previewResetPassword', function () {
        $message = (new \App\Notifications\Auth\ResetPassword('token'))->toMail('kitloong1008@gmail.com');
        $markdown = new \Illuminate\Mail\Markdown(view(), config('mail.markdown'));
        return $markdown->render('vendor.notifications.email', $message->toArray());
    });

    // Test email
    Route::get('testEmail', function () {
        $enquiryDto = new \App\Dto\EnquiryDto();
        $enquiryDto->setName('name');
        $enquiryDto->setEmail('kitloong1008@gmail.com');
        $enquiryDto->setPhone('phone');
        $enquiryDto->setCompany('company');
        $enquiryDto->setSubject('subject');
        $enquiryDto->setBudget('budget');
        $enquiryDto->setDescription('description');

        Mail::to('kitloong1008@gmail.com')
            ->send(new \App\Mail\EnquiryReceived($enquiryDto));
    });
});
