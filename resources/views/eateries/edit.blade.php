@extends('layouts.app')

@section('content')

<h1 class="mb-6 text-3xl font-bold">
    Edit {{ $eatery->name }}
</h1>

@include('eateries._form')

@endsection
