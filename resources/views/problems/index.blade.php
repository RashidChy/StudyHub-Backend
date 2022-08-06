@extends('layout')
@section('content')
@include('partials._search')

<div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

@if(count($problems)==0)
<p>No problems found</p>
@endif

@foreach($problems as $problem)
<x-problem-card :problem="$problem"/>
@endforeach


</div>
<div class="mt-6 p-4">
    {{$problems->links()}}
</div>
@endsection


