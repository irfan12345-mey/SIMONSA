<form method="GET" class="card card-body mb-4 no-print">
    <div class="row g-3 align-items-end">
        <div class="col-md-2">
            <label class="form-label">Bulan</label>
            <input type="month" name="bulan" value="{{ request('bulan') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Dari tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Sampai tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control">
        </div>
        <div class="col-md-2">
            <label class="form-label">Kebun</label>
            <select name="id_kebun" class="form-select">
                <option value="">Semua kebun</option>
                @foreach ($kebunList as $k)
                    <option value="{{ $k->id_kebun }}" @selected(request('id_kebun') == $k->id_kebun)>{{ $k->nama_kebun }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">Blok</label>
            <select name="id_blok" class="form-select">
                <option value="">Semua blok</option>
                @foreach ($blokList as $b)
                    <option value="{{ $b->id_blok }}" @selected(request('id_blok') == $b->id_blok)>{{ $b->kebun->nama_kebun }} - {{ $b->kode_blok }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button class="btn btn-primary flex-fill">Terapkan</button>
            <a href="{{ url()->current() }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </div>
</form>
