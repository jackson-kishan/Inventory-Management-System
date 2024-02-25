@extends('layout.sidenav-layout')

@section('content')
    @include('components.products.product-list')
    @include('components.products.product-create')
    @include('components.products.product-update')
    @include('components.products.product-delete')
@endsection