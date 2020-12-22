@extends('layouts.app')

@section('content')
    <App :auth="{{ auth()->user() }}"></App>
@endsection
