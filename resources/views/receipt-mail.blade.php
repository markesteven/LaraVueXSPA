<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style type="text/css" rel="stylesheet" media="all">
    body{
      	font-family: 'Open Sans', sans-serif;
    }
        /* Media Queries */
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        #fb-icon{
          position:relative;top:3px;
        }
    </style>
</head>

<?php
$style = [
    /* Layout ------------------------------ */
    'body' => 'margin: 0; padding: 0; width: 100%; background-color: #F2F4F6;',
    'fb-icon' => 'position:relative;top:3px;'
];
?>

<body style="{{ $style['body'] }}">

  <div style="width:100%;max-width:600px;margin:auto;background:#fff;font-size:12px;">
    {{-- <img  width="100%" src="{{ asset('static/img/email-header.jpg') }}" alt=""> --}}
    <div style="min-height:200px;margin: 40px 50px;">
      {{-- <p>Hi SEAOIL Believer <b>{{ $promo_submission->first_name }} {{ $promo_submission->middle_initial }} {{ $promo_submission->last_name }}!</b></p>
      <p>Thank you for joining the SEAOIL Lifetime Free Gas! Oh My Gas! Promo</p>
      <p>Your promo code <b>{{$promo_submission->promo_code}}</b> has been entered in the raffle promo. You have a total of <b>{{$promo_submission->promo_code_counts}} {{($promo_submission->promo_code_counts > 1) ? 'raffle entries' : 'raffle entry'}}.</p>
      <p>Continue gassing up at SEAOIL stations nationwide to earn more raffle entries and have the chance to win FREE gas for a lifetime.</p>
      <p>Terms and Conditions apply.</p>
      <p>Per DTI-FTEB Permit No. 12771 series of 2018</p> --}}

      <p><strong>Code : </strong>{{$promo_submission->code}}</p>
      <p><strong>First Name: </strong>{{$promo_submission->first_name}}</p>
      <p><strong>Middle Name : </strong>{{$promo_submission->middle_name}}</p>
      <p><strong>Last Name: </strong>{{$promo_submission->middle_name}}</p>
      <p><strong>Street Name : </strong>{{$promo_submission->street_name}}</p>
      <p><strong>Barangay/Subdivision: </strong>{{$promo_submission->barangay}}</p>
      <p><strong>City : </strong>{{$promo_submission->city}}</p>
      <p><strong>Email Address: </strong>{{$promo_submission->email_address}}</p>
      <p><strong>Mobile Number: </strong>{{$promo_submission->mobile_number}}</p>
    </div>

    {{-- <div style="width:100%;background:#0856a0;color:#fff;height:50px;line-height:30px;display: table;text-align: center;  margin: 2px auto 0 auto; vertical-align:middle;">
      <a href="https://www.facebook.com/SEAOIL" target="_blank">
        <img style="width:100%;" src="{{ asset('static/img/footer-mail.PNG') }}"/> </a>
    </div> --}}
  </div>


</body>
</html>
