@extends('layouts.app')
<div>
    <div class="flex h-screen justify-center flex-col">
        <div class="flex m-auto border-solid border-4 border-blue-800 p-4 mb-1">
            <p><b>Currency mismatch error:</b> Please select sender currency, so that it matches reciever account's currency</p>
        </div>
        <div class="flex m-auto mt-4">
            <button class="bg-blue-800 hover:bg-blue-600 text-white font-bold py-2 px-4 border border-black-700 rounded" onclick="history.go(-1);">Back </button>
        </div>
    </div>
</div>
@section('title', __('Currency mismatch'))
