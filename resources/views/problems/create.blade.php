@extends('layout')
@section('content')
<div
                    class="bg-gray-50 border border-gray-200 p-10 rounded max-w-lg mx-auto mt-24"
                >
                    <header class="text-center">
                        <h2 class="text-2xl font-bold uppercase mb-1">
                            Post a problem
                        </h2>
                        <p class="mb-4">Post a problem to find a solution</p>
                    </header>

                    <form method="POST" action="/problems" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-6">
                            <label for="title" class="inline-block text-lg mb-2"
                                >Problem Title</label
                            >
                            <input
                                type="text"
                                class="border border-gray-200 rounded p-2 w-full"
                                name="title"
                            />
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">
                                    {{$message}}
                                </p>
                            @enderror
                        </div>


                        <div class="mb-6">
                            <label for="email" class="inline-block text-lg mb-2"
                                >Contact Email</label
                            >
                            <input
                                type="text"
                                class="border border-gray-200 rounded p-2 w-full"
                                name="email"
                                value={{auth()->user()->email}}
                            />
                            <p class="text-red-500 text-xs mt-1">
                                @error('email')
                                    {{$message}}
                                @enderror
                            </p>
                        </div>

                        <div class="mb-6">
                            <label for="tags" class="inline-block text-lg mb-2">
                                Tags (Comma Separated)
                            </label>
                            <input
                                type="text"
                                class="border border-gray-200 rounded p-2 w-full"
                                name="tags"
                                placeholder="Example: DLC, Presentation, EEE, etc"
                            />
                            <p class="text-red-500 text-xs mt-1">
                                @error('tags')
                                    {{$message}}
                                @enderror
                            </p>
                        </div>

                        <div class="mb-6">
                            <label for="p_file" class="inline-block text-lg mb-2">
                                Problem File
                            </label>
                            <input
                                type="file"
                                class="border border-gray-200 rounded p-2 w-full"
                                name="p_file"
                            />
                            @error('file')
                            <p class="text-red-500 text-xs mt-1">
                                {{$message}}
                            </p>
                        @enderror
                        </div>

                        <div class="mb-6">
                            <label
                                for="description"
                                class="inline-block text-lg mb-2"
                            >
                                Job Description
                            </label>
                            <textarea
                                class="border border-gray-200 rounded p-2 w-full"
                                name="description"
                                rows="10"
                                placeholder="A brief description of your problem"
                            ></textarea>
                            <p class="text-red-500 text-xs mt-1">
                                @error('description')
                                    {{$message}}
                                @enderror
                            </p>
                        </div>

                        <div class="mb-6">
                            <button
                                class="bg-green-500 text-white rounded py-2 px-4 hover:bg-black"
                            >
                                Create Post
                            </button>

                            <a href="/" class="text-black ml-4"> Back </a>
                        </div>
                    </form>
                </div>
@endsection
