@extends('admin.faqs.form')

@section('card-header')
    {{ __('Edit FAQ') }}
@endsection

@php
    $faq = $faq;
@endphp