@extends('layouts.app')

@section('content')
<div id='container' class="border-solid border-4 border-light-blue-500">
    <div id='account_info'>
        <div class="flex">
            Sent {{ $transferAmount }} {{ $currency }}
        </div>
    </div>
@endsection
