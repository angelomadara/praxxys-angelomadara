@extends('layouts.app')

@section('content')
    <create-product-form categories="{{$categories}}"></create-product-form>
@endsection
