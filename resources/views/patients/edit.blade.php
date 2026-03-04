<h2>Edit Pasien</h2>

<form action="{{ route('patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="name" value="{{ $patient->name }}"><br>
    <input type="email" name="email" value="{{ $patient->email }}"><br>

    @if($patient->photo)
        <img src="{{ asset('storage/'.$patient->photo) }}" width="150"><br>
    @endif

    <input type="file" name="photo"><br>

    <button type="submit">Update</button>
</form>