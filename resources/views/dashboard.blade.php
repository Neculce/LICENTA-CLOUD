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

        <!--Whole section dedicated to showing and downloading the files-->

    <section class="text-gray-300 px-5 py-5 text" >

        <div class="justify-center flex text-2xl">  
             <h1>Uploaded files</h1>
        </div>

<table class="text-gray-300 justify-center flex py-5 text">
    <tr class=" space-x-4">
        <th>Filename</th>
        <th>Uploaded at</th>
        <th>Filesize</th>
        <th>Download</th>
        <th>Delete</th>
    </tr>
    @forelse($uploadedFiles as $uploadedFile)
        <tr class="space-x-4">
            <td class=" px-9">
                {{ $uploadedFile->filename }}
            </td>
            <td class=" px-9">
                {{ $uploadedFile->created_at }}
            </td>
            <td class="px-9">
                {{ $uploadedFile->filesize }}.Bytes
            </td>
            <td class=" px-9">
                <a href="{{ route('uploads.download', $uploadedFile) }}" download>Download {{ $uploadedFile->filename }}</a>        
                
            </td>
            <td class=" px-9">
                <a href="{{route('uploads.delete', $uploadedFile)}}" >Delete file </a>
        </tr>
    @empty
        <tr>
            <td>No uploads found</td>
        </tr>
    @endforelse
</table>



    </section>
<div class="justify-center flex py-5 text-red-900">
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
</div>
</x-app-layout>
