<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>
    <x-posts-list :posts="$posts" />
</x-app-layout>
<!--앞에 x가 있으먄 블레이드 컴포넌트이다-->
