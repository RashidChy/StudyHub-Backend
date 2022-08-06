@extends('layout')
@section('content')
@php

@endphp
<div
class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24"
>
<center><img style="width: 200px" src={{auth()->user()->p_pic ? 'http://localhost:8000/storage/'.auth()->user()->p_pic : asset('images/user.png')}} alt="ff"></center>
<header class="text-center">
    <h2 class="text-2xl font-bold uppercase mb-1">
        Profile
    </h2>
    <p class="mb-4">Update your profile</p>
</header>

<form method="POST" action="/user/profile" action="/user">
    @csrf
    @method('PUT')
    <div class="mb-6">
        <label for="name" class="inline-block text-lg mb-2">
            Name
        </label>
        <input
            type="text"
            class="border border-gray-200 rounded p-2 w-full"
            name="name"
            value="{{auth()->user()->name}}"
        />
        <p class="text-red-500 text-xs mt-1">
            @error('name')
                {{$message}}
            @enderror
        </p>
    </div>

    <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2"
            >Email</label
        >
        <input
            type="email"
            class="border border-gray-200 rounded p-2 w-full"
            name="email"
            value="{{auth()->user()->email}}"
        />
        <p class="text-red-500 text-xs mt-1">
            @error('email')
                {{$message}}
            @enderror
        </p>
    </div>

    <div class="mb-6">
        <label
            for="password"
            class="inline-block text-lg mb-2"
        >
            Password
        </label>
        <input
            type="password"
            class="border border-gray-200 rounded p-2 w-full"
            name="password"
        />
        <p class="text-red-500 text-xs mt-1">
            @error('password')
                {{$message}}
            @enderror
        </p>
    </div>

    <div class="mb-6">
        <label
            for="password2"
            class="inline-block text-lg mb-2"
        >
            Confirm Password
        </label>
        <input
            type="password"
            class="border border-gray-200 rounded p-2 w-full"
            name="password2"
        />
        <p class="text-red-500 text-xs mt-1">
            @error('password2')
                {{$message}}
            @enderror
        </p>
    </div>

    <div class="mb-6">
        <button
            type="submit"
            class="bg-green-500 text-white rounded py-2 px-4 hover:bg-black"
        >
            Update
        </button>
    </div>
</form>
</div>
@endsection