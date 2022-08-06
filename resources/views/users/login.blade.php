@extends('layout')
@section('content')
<div
class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24"
>
<header class="text-center">
    <h2 class="text-2xl font-bold uppercase mb-1">
        Login
    </h2>
    <p class="mb-4">Log In</p>
</header>

<form method="POST" action="/users/authenticate">
    @csrf
    <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2"
            >Email</label
        >
        <input
            type="email"
            class="border border-gray-200 rounded p-2 w-full"
            name="email"
            value="{{old('email')}}"
        />
        <!-- Error Example -->
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
            value="{{old('password')}}"
        />
        <p class="text-red-500 text-xs mt-1">
            @error('password')
                {{$message}}
            @enderror
        </p>
    </div>
    <div class="mb-6">
        <button
            type="submit"
            class="bg-green-500 text-white rounded py-2 px-4 hover:bg-black"
        >
            Login
        </button>
    </div>

    <div class="mt-8">
        <p>
            Not registerd yet?
            <a href="/register" class="text-green-500"
                >Register</a
            >
        </p>
    </div>
    <div class=" mt-12 ">
            <a href="{{route('facebook.login')}}" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-700"
                ><i class="fab fa-facebook-f mr-2"></i>
                Login with Facebook</a
            >
    </div>
    <div class=" mt-12 ">
        <a href="{{route('github.login')}}" class="bg-black text-white rounded py-2 px-4 hover:bg-slate-700"
            ><i class="fa-brands fa-github"></i>
            Login with Github</a
        >
</div>
</form>
</div>
@endsection