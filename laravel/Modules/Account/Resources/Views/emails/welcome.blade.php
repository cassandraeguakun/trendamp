@extends('mailmessenger::emails.layout')

@section('content')
    <h2 class="flow-text uk-text-center">
        Welcome to Talk<span class="fg-ts">S</span>tuff
    </h2>

    <p>
        Hello, {{$user->getDisplayName()}}
    </p>
@endsection