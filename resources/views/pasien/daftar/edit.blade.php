@extends('layouts.app-dashboard')

@section('title', 'Edit Pendaftaran Poli')

@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Pendaftaran Poli</h1>
    <a href="{{ route('pasien.daftar.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
      <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Form Edit Pendaftaran Poli</h6>
    </div>
    <div class="card-body">
      <form action="{{ route('pasien.daftar.update', $daftarPoli->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- No. RM (Read-Only) -->
        <div class="form-group">
          <label for="no_rm">No. RM</label>
          <input type="text" class="form-control" id="no_rm" name="no_rm" value="{{ $daftarPoli->pasien->no_rm }}" readonly>
        </div>

        <!-- Pilih Poli -->
        <div class="form-group">
          <label for="id_poli">Poli</label>
          <select class="form-control @error('id_poli') is-invalid @enderror" id="id_poli" name="id_poli" required>
            <option value="" disabled>Pilih Poli</option>
            @foreach($polis as $poli)
              <option value="{{ $poli->id }}" {{ ($daftarPoli->jadwalPeriksa->dokter->poli->id == $poli->id) ? 'selected' : '' }}>{{ $poli->nama_poli }}</option>
            @endforeach
          </select>
          @error('id_poli')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Pilih Jadwal Periksa -->
        <div class="form-group">
          <label for="id_jadwal">Jadwal Periksa</label>
          <select class="form-control @error('id_jadwal') is-invalid @enderror" id="id_jadwal" name="id_jadwal" required>
            <option value="" disabled>Pilih Jadwal Periksa</option>
            <!-- Options akan dimuat melalui AJAX berdasarkan poli yang dipilih -->
          </select>
          @error('id_jadwal')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Keluhan -->
        <div class="form-group">
          <label for="keluhan">Keluhan</label>
          <textarea class="form-control @error('keluhan') is-invalid @enderror" id="keluhan" name="keluhan" rows="3" required>{{ old('keluhan', $daftarPoli->keluhan) }}</textarea>
          @error('keluhan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pasien.daftar.index') }}" class="btn btn-secondary">Batal</a>
      </form>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const idPoliSelect = document.getElementById('id_poli');
    const idJadwalSelect = document.getElementById('id_jadwal');

    function loadJadwal(poliId, selectedJadwalId = null) {
      // Reset jadwal_periksa dropdown
      idJadwalSelect.innerHTML = '<option value="" disabled selected>Loading...</option>';

      if (poliId) {
        fetch(`{{ route('pasien.daftar.get-jadwal', '') }}/${poliId}`)
          .then(response => response.json())
          .then(data => {
            let options = '<option value="" disabled selected>Pilih Jadwal Periksa</option>';
            data.forEach(function(jadwal) {
              options += `<option value="${jadwal.id}" ${selectedJadwalId == jadwal.id ? 'selected' : ''}>${jadwal.hari} - ${jadwal.jam_mulai} - ${jadwal.jam_selesai} - Dokter ${jadwal.dokter.nama}</option>`;
            });
            idJadwalSelect.innerHTML = options;
          })
          .catch(error => {
            console.error('Error fetching jadwal_periksa:', error);
            idJadwalSelect.innerHTML = '<option value="" disabled selected>Terjadi kesalahan</option>';
          });
      } else {
        idJadwalSelect.innerHTML = '<option value="" disabled selected>Pilih Jadwal Periksa</option>';
      }
    }

    idPoliSelect.addEventListener('change', function() {
      const poliId = this.value;
      loadJadwal(poliId);
    });

    // Muat jadwal_periksa yang dipilih saat ini
    @if(old('id_poli') || $daftarPoli->jadwalPeriksa->dokter->poli->id)
      let selectedPoliId = "{{ old('id_poli', $daftarPoli->jadwalPeriksa->dokter->poli->id) }}";
      let selectedJadwalId = "{{ old('id_jadwal', $daftarPoli->id_jadwal) }}";

      idPoliSelect.value = selectedPoliId;
      loadJadwal(selectedPoliId, selectedJadwalId);
    @endif
  });
</script>
@endsection
