<x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('New server') }}
            </h2>
        </x-slot>
    <div class="flex flex-col items-center justify-center h-screen bg-gray-200">
        <form class="bg-white p-6 rounded-lg shadow-md" action="{{ route('domain.store') }}" method="post">
            @csrf
            @if (session('success'))
                <div class="bg-green-500 text-white py-2 px-4 rounded">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-500 text-white py-2 px-4 rounded">
                    {{ session('error') }}
                </div>
            @endif
            <h1 class="text-lg font-medium text-gray-700 mb-4">Enter Domain Name</h1>
            <div class="mb-4">
                <input type="text" name="domain" class="w-full border border-gray-400 p-2 rounded-lg" placeholder="example.com">
            </div>
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Submit</button>
        </form>
    </div>

</x-app-layout>
