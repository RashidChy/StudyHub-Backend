@extends('AdminLayout')
@section('content')
<x-card class="p-10">
    <header>
        <h1
            class="text-3xl text-center font-bold my-6 uppercase"
        >
            USERS LIST
        </h1>
    </header>

    <table class="w-full table-auto rounded-sm">
        <tbody>
            @if(count($users)==0)
            <p>No Users Registered Yet !</p>
            @endif

            @foreach($users as $user)
            <tr class="border-gray-300">
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a href="show.html">
                        {{$user->id}}
                    </a>
                </td>
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a href="show.html">
                        {{$user->name}}
                    </a>
                </td>
                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <a href="show.html">
                        {{$user->email}}
                    </a>
                </td>

                <td
                    class="px-4 py-8 border-t border-b border-gray-300 text-lg"
                >
                    <form method="POST" action="/adminOperations/user/{{$user->id}}">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600">
                            <i
                                class="fa-solid fa-trash-can"
                            ></i>
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            
        </tbody>
    </table>
</x-card>
@endsection