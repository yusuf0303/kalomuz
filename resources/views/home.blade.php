@extends('layouts.app')

<div id="custom-loader" class="loader-wrapper">
    <div class="loader-ball ball1"></div>
    <div class="loader-ball ball2"></div>
    <div class="loader-ball ball3"></div>
    <div class="loader-ball ball4"></div>
    <div class="loader-ball ball5"></div>
</div>

@section('content')
    @include('partials.hero')
    @include('partials.features')
    @include('partials.saved-ayahs')
    @include('partials.section-contact')
@endsection
