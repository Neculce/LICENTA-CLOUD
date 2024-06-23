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

    <section>
        <h1>Uploaded files</h1>
<table>
    <tr>
        <th>Filename</th>
        <th>Uploaded at</th>
        <th>Download</th>
        <th>Delete</th>
    </tr>
    @forelse($uploadedFiles as $uploadedFile)
        <tr>
            <td>
                {{ $uploadedFile->filename }}
            </td>
            <td>
                {{ $uploadedFile->created_at }}
            </td>
            <td>
                <a href="{{ route('uploads.download', $uploadedFile) }}" download>Download {{ $uploadedFile->filename }}</a>        
                
            </td>
            <td>
                <a href="{{route('uploads.delete', $uploadedFile)}}" >Delete file </a>
        </tr>
    @empty
        <tr>
            <td>No uploads found</td>
        </tr>
    @endforelse
</table>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

    </section>

</x-app-layout>
