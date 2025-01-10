@php
    use App\Helpers\RZWHelper;
@endphp


@extends('panel.layout')

@section('title', 'Dashboard')

@section('content')
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('panel') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Dashboard
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div>
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row"> <!--begin::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 1-->
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>Rp {{ RZWHelper::FormatNumber($user->saldo) }}</h3>
                            <p>Saldo</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="m3 6a2 2 0 0 1 2-2h5.14l-4.89 4.89a3 3 0 0 1 -2.25-2.89zm23 3v-1a4 4 0 0 0 -4-4h-4.17l5 5zm-1 1h-19a1.75 1.75 0 0 1 -.4 0 4 4 0 0 1 -3.6-4v19a5 5 0 0 0 5 5h18a5 5 0 0 0 5-5v-1h-5a3 3 0 0 1 -3-3v-2a3 3 0 0 1 3-3h5v-1a5 5 0 0 0 -5-5zm-1 9v2a1 1 0 0 0 1 1h5v-4h-5a1 1 0 0 0 -1 1zm-14.62-10 4.62-4.6 4.59 4.6h2.82l-6.72-6.72a1 1 0 0 0 -1.41 0l-6.73 6.72z"
                                fill="#283b96"></path>
                        </svg>
                        </svg>
                        <a href="{{ route('topup') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Topup <i class="bi bi-link-45deg"></i>
                        </a>
                    </div> <!--end::Small Box Widget 1-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 2-->
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ RZWHelper::FormatNumber($transaksi->count()) }}</h3>
                            <p>Semua Pesanan</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                            </path>
                        </svg> <a href="{{ url('transaksi') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Transaksi <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 2-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 3-->
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>Rp {{ RZWHelper::FormatNumber($topup->where('status', 1)->sum('nominal')) }}</h3>
                            <p>Total Deposit</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                            </path>
                        </svg> <a href="{{ route('topup') }}"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            Transaksi Deposit <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 3-->
                </div> <!--end::Col-->
                <div class="col-lg-3 col-6"> <!--begin::Small Box Widget 4-->
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>Rp {{ RZWHelper::FormatNumber($transaksi->sum('nominal')) }}</h3>
                            <p>Total Nominal Pesanan</p>
                        </div> <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                            </path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                            </path>
                        </svg> <a href="{{ route('transaksi') }}"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            Transaksi <i class="bi bi-link-45deg"></i> </a>
                    </div> <!--end::Small Box Widget 4-->
                </div> <!--end::Col-->
            </div> <!--end::Row--> <!--begin::Row-->
            <div class="row"> <!-- Start col -->
                <div class="col-lg-6 connectedSortable">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Transaksi Bulanan</h3>
                        </div>
                        <div class="card-body">
                            <div id="trx-bulanan"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 connectedSortable">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Transaksi Mingguan</h3>
                        </div>
                        <div class="card-body">
                            <div id="trx-mingguan"></div>
                        </div>
                    </div>
                </div>
            </div> <!-- /.row (main row) -->
        </div> <!--end::Container-->
    </div> <!--end::App Content-->
@endsection


@section('js')
    <script>
        function getLast5Months() {
            const currentDate = new Date();
            const categories = [];

            for (let i = 5; i >= 0; i--) {
                const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
                const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-01`;
                categories.push(formattedDate);
            }

            return categories;
        }
        const Bulanan = {
            series: {!! json_encode($transaksiBulanan) !!},
            chart: {
                height: 350,
                type: "area",
                toolbar: {
                    show: true,
                },
            },
            legend: {
                show: true,
            },
            colors: ["#31BD90", "#20c997"],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                type: "datetime",
                categories: getLast5Months(),
            },
            tooltip: {
                x: {
                    format: "MMMM",
                },
            },
        };

        const Mingguan = {
            series: {!! json_encode($transaksiMingguan) !!},
            chart: {
                height: 350,
                type: "area",
                toolbar: {
                    show: true,
                },
            },
            legend: {
                show: true,
            },
            colors: ["#F9322C", "#20c997"],
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: "smooth",
            },
            xaxis: {
                type: "week",
                categories: [
                    "Senin",
                    "Selasa",
                    "Rabu",
                    "Kamis",
                    "Jumat",
                    "Sabtu",
                    "Minggu",
                ],
            },
        };

        const trx_bulanan = new ApexCharts(
            document.querySelector("#trx-bulanan"),
            Bulanan,
        );
        const trx_mingguan = new ApexCharts(
            document.querySelector("#trx-mingguan"),
            Mingguan,
        );
        trx_bulanan.render();
        trx_mingguan.render();
    </script>

@endsection
