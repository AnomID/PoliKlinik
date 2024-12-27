@extends('layouts.app-dashboard')

@section('content')
    <div class="container">
        <h1>Edit Periksa</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Terjadi kesalahan saat input data.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dokter.periksa.update', $periksa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="no_rm">No RM</label>
                <input type="text" class="form-control" id="no_rm" value="{{ $periksa->daftarPoli->pasien->no_rm }}" readonly>
            </div>

            <div class="form-group">
                <label for="nama_pasien">Nama Pasien</label>
                <input type="text" class="form-control" id="nama_pasien" value="{{ $periksa->daftarPoli->pasien->nama }}" readonly>
            </div>

            <div class="form-group">
                <label for="tgl_periksa">Tanggal Periksa</label>
                <input type="date" class="form-control" name="tgl_periksa" id="tgl_periksa" value="{{ $periksa->tgl_periksa->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="jam_periksa">Jam Periksa</label>
                <input type="time" class="form-control" name="jam_periksa" id="jam_periksa" value="{{ $periksa->tgl_periksa->format('H:i') }}" required>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan</label>
                <textarea class="form-control" name="catatan" id="catatan" rows="3">{{ $periksa->catatan }}</textarea>
            </div>

            <div class="form-group">
                <label for="obat">Pilih Obat</label>
                <select multiple class="form-control" name="obat_ids[]" id="obat" required>
                    @foreach($obats as $obat)
                        <option value="{{ $obat->id }}" {{ $periksa->detailPeriksa->contains('id_obat', $obat->id) ? 'selected' : '' }}>
                            {{ $obat->nama_obat }} ({{ number_format($obat->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Total Harga</label>
                <p>Biaya Dokter: Rp. 150.000</p>
                <p>Biaya Obat: <span id="biaya_obat">Rp. 0</span></p>
                <p><strong>Total: <span id="total_biaya">Rp. 150.000</span></strong></p>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('dokter.periksa.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const obatSelect = document.getElementById('obat');
        const biayaObat = document.getElementById('biaya_obat');
        const totalBiaya = document.getElementById('total_biaya');

        const obatPrices = @json($obats->pluck('harga', 'id'));

        function updateHarga() {
            let selectedOptions = Array.from(obatSelect.selectedOptions);
            let total = 0;
            selectedOptions.forEach(option => {
                let harga = obatPrices[option.value] || 0;
                total += parseInt(harga);
            });

            biayaObat.textContent = 'Rp. ' + total.toLocaleString('id-ID');
            let totalHarga = 150000 + total;
            totalBiaya.textContent = 'Rp. ' + totalHarga.toLocaleString('id-ID');
        }

        // Hitung awal
        updateHarga();

        obatSelect.addEventListener('change', updateHarga);
    });
</script>
@endsection
