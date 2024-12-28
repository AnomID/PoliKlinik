@extends('layouts.app-dashboard')

@section('title', 'Pemeriksaan Pasien')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pemeriksaan Pasien</h1>
    <a href="{{ route('dokter.periksa.index') }}" class="btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pemeriksaan</h6>
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
                <input type="datetime-local" name="tgl_periksa" class="form-control @error('tgl_periksa') is-invalid @enderror" required>
                @error('tgl_periksa')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="3" required></textarea>
                @error('catatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Obat</label>
                <div class="table-responsive">
                    <table class="table table-bordered" id="obatTable">
                        <thead>
                            <tr>
                                <th>Nama Obat</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="emptyRow">
                                <td colspan="5" class="text-center">Belum ada obat yang dipilih</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#obatModal">
                    <i class="fas fa-plus"></i> Tambah Obat
                </button>
            </div>

            <div class="form-group">
                <label>Total Biaya</label>
                <input type="text" id="totalBiaya" class="form-control" readonly>
                <input type="hidden" name="biaya_periksa" id="biayaPeriksa">
                <small class="text-muted">* Rp 150.000 Awal adalah biaya jasa dokter</small>

            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dokter.periksa.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<!-- Modal Pilih Obat -->
<div class="modal fade" id="obatModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Obat</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Obat</label>
                    <select id="obatSelect" class="form-control">
                        <option value="">Pilih Obat</option>
                        @foreach($obatList as $obat)
                            <option value="{{ $obat->id }}"
                                    data-nama="{{ $obat->nama_obat }}"
                                    data-harga="{{ $obat->harga }}"
                                    data-stok="{{ $obat->stok }}">
                                {{ $obat->nama_obat }} (Stok: {{ $obat->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" id="jumlahObat" class="form-control" min="1" value="1">
                    <small class="text-muted">Stok tersedia: <span id="stokTersedia">0</span></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="tambahObat">Tambah</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const BIAYA_DOKTER = 150000;
    let selectedObat = {};

    $('#obatSelect').change(function() {
        const stok = $(this).find(':selected').data('stok');
        $('#stokTersedia').text(stok);
        $('#jumlahObat').attr('max', stok);
    });

    $('#tambahObat').click(function() {
        const obatId = $('#obatSelect').val();
        if (!obatId) return;

        const selected = $('#obatSelect').find(':selected');
        const jumlah = parseInt($('#jumlahObat').val());
        const harga = selected.data('harga');
        const nama = selected.data('nama');
        const stok = selected.data('stok');

        if (jumlah < 1 || jumlah > stok) {
            alert('Jumlah tidak valid');
            return;
        }

        if (selectedObat[obatId]) {
            alert('Obat sudah dipilih');
            return;
        }

        selectedObat[obatId] = {
            nama: nama,
            harga: harga,
            jumlah: jumlah
        };

        updateObatTable();
        $('#obatModal').modal('hide');
    });

    function updateObatTable() {
        const tbody = $('#obatTable tbody');
        tbody.empty();

        if (Object.keys(selectedObat).length === 0) {
            tbody.append(`
                <tr id="emptyRow">
                    <td colspan="5" class="text-center">Belum ada obat yang dipilih</td>
                </tr>
            `);
        } else {
            Object.entries(selectedObat).forEach(([id, data]) => {
                const subtotal = data.harga * data.jumlah;
                tbody.append(`
                    <tr>
                        <td>${data.nama}</td>
                        <td>Rp ${data.harga.toLocaleString('id-ID')}</td>
                        <td>
                            <input type="hidden" name="obat_id[]" value="${id}">
                            <input type="hidden" name="jumlah[]" value="${data.jumlah}">
                            ${data.jumlah}
                        </td>
                        <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapusObat('${id}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
            });
        }

        updateTotalBiaya();
    }

    function updateTotalBiaya() {
        let totalObat = 0;
        Object.values(selectedObat).forEach(data => {
            totalObat += data.harga * data.jumlah;
        });

        const totalBiaya = BIAYA_DOKTER + totalObat;
        $('#totalBiaya').val('Rp ' + totalBiaya.toLocaleString('id-ID'));
        $('#biayaPeriksa').val(totalBiaya);
    }

    window.hapusObat = function(id) {
        delete selectedObat[id];
        updateObatTable();
    }
});
</script>
@endpush
@endsection
