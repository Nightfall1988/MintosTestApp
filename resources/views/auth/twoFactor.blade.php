@extends('layouts.app')

@section('content')
<div class="wrapper">
    <div class="content">
        <div>
        @if(! Auth::user()->two_factor_secret) 
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            <div>
                @csrf
                <button type="submit">ENABLE</button>
            </div>
        </form>
        @else 
        <form method="POST" action="{{ url('user/two-factor-authentication') }}">
            @csrf
            <div>
                <form class="d-inline" method="POST" action="{{ url('/two-factor-challenge') }}">
                    @csrf

                    @if (session('status') == "two-factor-authentication-enabled")
                    <p>Please scan this QR code with your Google Authenticator app on your phone or tablet</p><br>
                    {!! $request->user()->twoFactorQrCodeSvg() !!}<br>
                    Please save these codes, for security purposes:<br>
                    
                    @foreach (json_decode(decrypt(Auth::user()->two_factor_recovery_codes, true))  as $code)
                    - {{ trim($code) }}<br>
                    @endforeach
                    <?php //THIS IS THE LIST $request->user()->recoveryCodes(); ?>
                    <input type="text" name='code'/><br>
                    <input type="button" name="submit" id='submit'/>
                    @endif
                </form>
            </div>
        </form>

        @endif
        </div>
    </div>
</div>