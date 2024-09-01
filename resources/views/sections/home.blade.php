@extends('layouts.main')
@section('title', 'Broobe Challenge')

@section('content')

<ul>
    @foreach ($categories as $category)
        <li>{{$category->name}}</li>
    @endforeach
</ul>
@endsection