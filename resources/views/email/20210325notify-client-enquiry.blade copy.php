<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 7/4/2018
 * Time: 5:18 PM
 */
?>

@php /* @var \App\Dto\EnquiryDto $enquiryDto */ @endphp

<div>Hi {{ $enquiryDto->getName() }},</div>

<p>We received your enquiry <b>{{ $enquiryDto->getSubject() }}</b><br />
    One of our colleague will get back to you as soon as possible.</p>

<p>Have a nice day!</p>

<p>
    Cheers,
    {{ app('Setting')->getSiteName() }} Administrator
</p>
