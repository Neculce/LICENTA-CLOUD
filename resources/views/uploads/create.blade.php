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

<section class="text-gray-300 px-5 py-5 justify-items-center">
    <div>
<h1 class="title justify-center flex text-xl">Upload file</h1>
    </div>

<div class="justify-center flex py-5">
    <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data" class="px-5" >
        @csrf
        <input type="file" name="userfile" >
        <button type="submit" class="text-xl">Press this button to upload</button>

    </form>
</div>
</div>
</section>
<div class="flex justify-center text-grey-200">
@if ($errors->any())
                    <div class="notification is-danger is-light">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
</div>
</x-app-layout>