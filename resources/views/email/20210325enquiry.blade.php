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
        <td width="100">Company</td>
        <td>{{ $enquiryDto->getCompany() }}</td>
    </tr>
    <tr>
        <td width="100">Subject</td>
        <td>{{ $enquiryDto->getSubject() }}</td>
    </tr>
    <tr>
        <td width="100">Budget</td>
        <td>{{ $enquiryDto->getBudget() }}</td>
    </tr>
    <tr>
        <td width="100">Description</td>
        <td>{{ nl2br($enquiryDto->getDescription()) }}</td>
    </tr>
</table>

<p>Thanks!</p>

<p>
    From {{ app('Setting')->getSiteName() }}
</p>
