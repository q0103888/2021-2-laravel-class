<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between" id="app">
            <example-component/>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
        <button onclick=location.href="{{ route('posts.create') }}" type="button" class="btn btn-info hover:bg-blue-700 font-bold text-white">
            글쓰기
        </button>
        </div>
    </x-slot>
    <x-posts-list :posts="$posts" />
    
</x-app-layout>
<!--앞에 x가 있으먄 블레이드 컴포넌트이다-->
