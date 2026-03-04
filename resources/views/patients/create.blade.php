<h2>Tambah Pasien</h2>

<form action="{{ route('patients.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="text" name="name" placeholder="Nama"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="file" name="photo"><br>

    <button type="submit">Simpan</button>
</form>