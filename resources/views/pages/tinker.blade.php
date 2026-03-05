@extends('app')

@section('active_key', 'tinker')
@section('page_title', 'Tinker Console')
@section('page_subtitle', 'Select a project first.')

@section('content')
    <livewire:tinker-console.workbench />
@endsection
