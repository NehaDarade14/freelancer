@extends('admin.support-tickets.form')

@section('card-header')
    {{ __('Edit Support Ticket') }}
@endsection

@php
    $supportTicket = $supportTicket;
@endphp