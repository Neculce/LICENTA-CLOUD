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