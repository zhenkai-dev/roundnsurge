<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 7/4/2018
 * Time: 5:18 PM
 */
?>

@php /* @var \App\Dto\EnquiryDto $enquiryDto */ @endphp

<div>Hello,</div>

<p>We received an enquiry!<br />
    Check out the details below for enquiry information.</p>

<table>
    <tr>
        <td width="100">Name</td>
        <td>{{ $enquiryDto->getName() }}</td>
    </tr>
    <tr>
        <td width="100">Email</td>
        <td>{{ $enquiryDto->getEmail() }}</td>
    </tr>
    <tr>
        <td width="100">Phone</td>
        <td>{{ $enquiryDto->getPhone() }}</td>
    </tr>
    <tr>
        <td width="100">Interest</td>
        <td>
            @php
            $interests = $enquiryDto->getInterest();
            @endphp
            @foreach($interests as $interest)
                {{ $interest }}<br>
            @endforeach
        </td>
    </tr>
    <tr>
        <td width="100">Message</td>
        <td>{{ nl2br($enquiryDto->getMessage()) }}</td>
    </tr>
</table>

<p>Thanks!</p>

<p>
    From {{ app('Setting')->getSiteName() }}
</p>
