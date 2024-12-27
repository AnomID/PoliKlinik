@extends('layouts.app-dashboard')

@section('title', 'Pemeriksaan Pasien')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pemeriksaan Pasien</h1>
    <a href="{{ route('dokter.periksa.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pemeriksaan Pasien</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dokter.periksa.store') }}" method="POST" id="periksaForm">
            @csrf
            <input type="hidden" name="id_daftar_poli" value="{{ $daftarPoli->id }}">

            <div class="form-group">
                <label>No. RM</label>
                <input type="text" class="form-control" value="{{ $daftarPoli->pasien->no_rm }}" readonly>
            </div>

            <div class="form-group">
                <label>Nama Pasien</label>
                <input type="text" class="form-control" value="{{ $daftarPoli->pasien->nama }}" readonly>
            </div>

            <div class="form-group">
                <label>Tanggal & Jam Periksa</label>
                <input type="datetime-local" class="form-control @error('tgl_periksa') is-invalid @enderror" name="tgl_periksa" required>
                @error('tgl_periksa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" rows="3" required></textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="card mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Obat yang diberikan</h6>
                </div>
                <div class="card-body">
                    <div id="obat-container">
                        <!-- Container untuk baris obat -->
                    </div>

                    <button type="button" class="btn btn-success btn-sm mt-3" id="tambah-obat">
                        <i class="fas fa-plus"></i> Tambah Obat
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Total Biaya</label>
                <input type="text" class="form-control" id="totalBiaya" value="Rp 150.000" readonly>
                <small class="text-muted">*Biaya awal pemeriksaan Rp 150.000 + harga obat</small>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

@push('styles')
<style>
    .obat-row {
        position: relative;
        padding: 1rem;
        border: 1px solid #e3e6f0;
        border-radius: 0.35rem;
        margin-bottom: 1rem;
    }
    .remove-obat {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    const obatList = {!! json_encode($obatList) !!};
    let totalBiaya = 150000; // Biaya awal

    function updateTotalBiaya() {
        let obatBiaya = 0;
        $('.obat-select').each(function() {
            const selectedObat = obatList.find(o => o.id == $(this).val());
            if (selectedObat) {
                obatBiaya += selectedObat.harga;
            }
        });
        totalBiaya = 150000 + obatBiaya;
        $('#totalBiaya').val('Rp ' + totalBiaya.toLocaleString('id-ID'));
    }

    function createObatRow() {
        const rowId = Date.now();
        const row = `
            <div class="obat-row" id="obat-${rowId}">
                <button type="button" class="btn btn-danger btn-sm remove-obat">
                    <i class="fas fa-times"></i>
                </button>
                <div class="form-group">
                    <label>Pilih Obat</label>
                    <select class="form-control obat-select" name="obat_id[]" required>
                        <option value="">Pilih Obat</option>
                        ${obatList.map(obat => `
                            <option value="${obat.id}" data-harga="${obat.harga}">
                                ${obat.nama_obat} (Stok: ${obat.stok}) - Rp ${obat.harga.toLocaleString('id-ID')}
                            </option>
                        `).join('')}
                    </select>
                </div>
            </div>
        `;
        $('#obat-container').append(row);
    }

    // Event untuk tombol tambah obat
    $('#tambah-obat').click(function() {
        createObatRow();
    });

    // Event untuk hapus baris obat
    $(document).on('click', '.remove-obat', function() {
        $(this).closest('.obat-row').remove();
        updateTotalBiaya();
    });

    // Event untuk perubahan pilihan obat
    $(document).on('change', '.obat-select', function() {
        updateTotalBiaya();
    });

    // Tambahkan satu baris obat saat halaman dimuat
    createObatRow();

    // Validasi form sebelum submit
    $('#periksaForm').submit(function(e) {
        const obatSelected = $('.obat-select').filter(function() {
            return $(this).val() !== '';
        }).length;

        if (obatSelected === 0) {
            e.preventDefault();
            alert('Pilih minimal satu obat');
        }
    });
});
</script>
@endpush
@endsection
