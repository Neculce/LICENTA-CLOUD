<x-app-layout>
    
    <x-slot name="header">
        <div>
            <span>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
            </span>
            <span>
        <a class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" href="{{ route('uploads.create') }}">
            Upload a file
        </a>
            </span>
        </div>
    </x-slot>

<section class="bg-slate-800">
<h1 class="title">Upload file</h1>
@if ($errors->any())
<div class="notification is-danger is-light">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="userfile">
    <button type="submit">Upload</button>
</form>
</section>
</x-app-layout>