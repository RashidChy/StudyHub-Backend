@props(['problem'])
<x-card>
    <div class="flex">
        <img
            class="hidden w-48 mr-6 md:block"
            src="{{asset('images/no-image.png')}}"
            alt=""
        />
        <div>
            <h3 class="text-2xl">
                <a href="/problems/{{$problem->id}}">{{$problem->title}}</a>
            </h3>
            <x-problem-tags :tagsCsv="$problem->tags"></x-problem-tags>
        </div>
    </div>
</x-card>