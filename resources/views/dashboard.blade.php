@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Warga</div>
                <div class="card-body">
                    <h3 class="card-title">{{ $totalWarga }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Jumlah KK</div>
                <div class="card-body">
                    <h3 class="card-title">{{ $totalKK }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 bg-info text-white">
                <h4>Laki-laki</h4>
                <p>{{ $lakiLaki }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-warning text-white">
                <h4>Perempuan</h4>
                <p>{{ $perempuan }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Surat Pengantar</div>
                <div class="card-body">
                    <h3 class="card-title">{{ $totalSurat }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 bg-success text-white">
                <h4>Menikah</h4>
                <p>{{ $menikah }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3 bg-danger text-white">
                <h4>Belum Menikah</h4>
                <p>{{ $belumMenikah }}</p>
            </div>
        </div>
    </div>
<br>

    <a href="{{ route('warga.index') }}" class="btn btn-outline-primary">Kelola Data Warga</a>
    <a href="{{ route('keluarga.index') }}" class="btn btn-outline-primary">Kelola Data keluarga</a>
    <a href="{{ route('surat.index') }}" class="btn btn-outline-success">Kelola Surat Pengantar</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="card mt-5">
    <div class="card-body">
        <h4 class="mb-4">Grafik Kelompok Usia</h4>
        <canvas id="usiaChart"></canvas>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6">
        <h5 class="mb-3">Grafik Pendidikan</h5>
        <canvas id="pendidikanChart"></canvas>
    </div>
    <div class="col-md-6">
        <h5 class="mb-3">Grafik Pekerjaan</h5>
        <canvas id="pekerjaanChart"></canvas>
    </div>
</div>

<script>
    const ctx = document.getElementById('usiaChart').getContext('2d');
    const usiaChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['0-17 (Anak)', '18-40 (Dewasa Muda)', '41-60 (Dewasa)', '60+ (Lansia)'],
            datasets: [{
                label: 'Jumlah',
                data: [{{ $usiaAnak }}, {{ $usiaDewasaMuda }}, {{ $usiaDewasa }}, {{ $usiaLansia }}],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    const pendidikanData = {
        labels: {!! json_encode($pendidikan->pluck('pendidikan')) !!},
        datasets: [{
            label: 'Pendidikan',
            data: {!! json_encode($pendidikan->pluck('total')) !!},
            backgroundColor: [
                '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#20c997'
            ]
        }]
    };

    const pekerjaanData = {
        labels: {!! json_encode($pekerjaan->pluck('pekerjaan')) !!},
        datasets: [{
            label: 'Pekerjaan',
            data: {!! json_encode($pekerjaan->pluck('total')) !!},
            backgroundColor: [
                '#f94144', '#f3722c', '#f9c74f', '#90be6d', '#43aa8b', '#577590'
            ]
        }]
    };

    new Chart(document.getElementById('pendidikanChart'), {
        type: 'pie',
        data: pendidikanData
    });

    new Chart(document.getElementById('pekerjaanChart'), {
        type: 'pie',
        data: pekerjaanData
    });


</script>

@endsection
