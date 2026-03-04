<h2>Daftar Pasien</h2>
<a href="{{ route('patients.create') }}">Tambah Pasien</a>

@foreach($patients as $patient)
    <div style="border:1px solid #ccc; margin:10px; padding:10px;">
        <p>Nama: {{ $patient->name }}</p>
        <p>Email: {{ $patient->email }}</p>

        @if($patient->photo)
            <img src="{{ asset('storage/'.$patient->photo) }}" width="150">
        @endif

        <br>
        <a href="{{ route('patients.edit', $patient->id) }}">Edit</a>

        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </div>
@endforeach