@extends('panel.layout')


@section('title', 'Orders')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Orders</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Orders
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="container">
        @if (session('alert') && isset(session('alert')['data']))
            <div class="alert alert-success" role="alert">
                <b>Pesanan Berhasil</b><br>
                Layanan : {{ session('alert')['data']['layanan'] }} <br>
                Target : {{ session('alert')['data']['target'] }} <br>
                Jumlah : {{ session('alert')['data']['jumlah'] }}
            </div>
        @endif
        <div class="card card-primary card-outline mb-4"> <!--begin::Header-->
            <form action="{{ route('layanan1.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Kategori Layanan</label>
                        <select name="categori_layanan" id="categori_layanan" class="form-control select2"
                            data-placeholder="Pilih Kategori Layanan">
                            <option value="">Pilih Kategori Layanan</option>
                            @foreach ($data['category'] as $key => $layanan)
                                <option value="{{ $key }}">{{ $layanan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Layanan</label>
                        <select name="layanan" id="layanan" class="form-control select2 @error('layanan') is-invalid @enderror" data-placeholder="Pilih Layanan">
                            <option value="">Pilih Layanan</option>
                        </select>
                        @error('layanan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Target</label>
                        <input type="text" class="form-control @error('target') is-invalid @enderror" id="target" name="target"
                            placeholder="Username/Link">
                        @error('target')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Jumlah</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" placeholder="100"
                            step="1">
                        <span class="text-danger" id="noted_jumlah"></span>
                        @error('jumlah')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" placeholder="Rp 0"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Total Harga</label>
                        <input type="text" class="form-control" id="total_harga" name="total_harga" placeholder="Rp 0"
                            readonly>
                    </div>
                </div>
                <div class="card-footer"> <button type="submit" class="btn btn-primary">Order</button> </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function formatRupiah(number, locale = 'id-ID') {
            return new Intl.NumberFormat(locale, {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }

        $(document).ready(function() {
            $('.select2').select2();
        });

        var datas = {!! json_encode($data['data']) !!};
        $('#categori_layanan').on('change', function() {
            $('#layanan').empty();
            $('#layanan').append('<option value="">Pilih Layanan</option>');
            var layanan = datas.filter(item => item.category_id == $(this).val());
            layanan.forEach(item => {
                $('#layanan').append('<option value="' + item.id + '">' + item.name + '</option>');
            });
        });

        $('#layanan').on('change', function() {
            var layanan = datas.filter(item => item.id == $(this).val());
            const kurs = {{ $kurs }};
            let total_kurs = (layanan[0].price * 1) * kurs;
            console.log(`Jumlah Kurs : ${total_kurs}, Harga Asli : ${layanan[0].price}`)
            $('#harga').val(`Rp ${formatRupiah(layanan[0].price + total_kurs)}`);
            $('#total_harga').val(`Rp ${formatRupiah(layanan[0].price + total_kurs)}`);


            const jumlahInput = document.querySelector('#jumlah');
            const noted_jumlah = document.querySelector('#noted_jumlah');
            jumlahInput.setAttribute('min', layanan[0].min);
            jumlahInput.setAttribute('max', layanan[0].max);
            noted_jumlah.textContent =
                `Minimal ${formatRupiah(layanan[0].min)} dan Maksimal ${formatRupiah(layanan[0].max)}`;
        });

        $('#jumlah').on('change', function() {
            var layanan = datas.filter(item => item.id == $('#layanan').val());
            var harga = (layanan[0].price / 1000);
            var jumlah = $('#jumlah').val();
            const kurs = {{ $kurs }};
            let total_kurs = (harga * jumlah) * kurs;
            let total = (harga * jumlah) + total_kurs;
            let total_harga = formatRupiah(total);
            $('#total_harga').val(`Rp ${total_harga}`);
        });
    </script>
@endsection
