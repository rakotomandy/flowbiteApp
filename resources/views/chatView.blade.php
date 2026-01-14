@extends('layout.layout')

@section('title')
    Chat View
@endsection

@section('content')
   <x-sidebar />
   <x-welcome :user="Auth::user()" />
   <x-welcome-body :user="Auth::user()" />
@endsection