@extends('layouts.app')

@section('content')
    <update-product-form categories="{{$categories}}" item="{{$product}}"></update-product-form>
@endsection
