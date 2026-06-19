@extends('backend.layout.app')

@push('css-top')
<style>
    .stat-number { font-size: 2.5rem; font-weight: bold; }
</style>
@endpush

@section('content')
    @include('backend.layout.breadcrumb',['content' => 'Monitoring'])
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">CPU Usage</h3></div>
                        <div class="card-body text-center">
                            <div class="stat-number" id="cpu-value">--%</div>
                            <small class="text-muted" id="cpu-cores">-- core</small>
                            <div class="progress mt-2" style="height:20px;">
                                <div id="cpu-bar" class="progress-bar bg-info" role="progressbar" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">RAM Usage</h3></div>
                        <div class="card-body text-center">
                            <div class="stat-number" id="mem-value">--%</div>
                            <small class="text-muted" id="mem-detail">-- / -- MB</small>
                            <div class="progress mt-2" style="height:20px;">
                                <div id="mem-bar" class="progress-bar bg-success" role="progressbar" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">Disk Usage</h3></div>
                        <div class="card-body text-center">
                            <div class="stat-number" id="disk-value">--%</div>
                            <small class="text-muted" id="disk-detail">-- / -- GB</small>
                            <div class="progress mt-2" style="height:20px;">
                                <div id="disk-bar" class="progress-bar bg-warning" role="progressbar" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">CPU &amp; RAM (Live)</h3>
                            <div class="card-tools">
                                <span class="badge badge-secondary" id="last-update">menunggu data...</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="live-chart" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js-bottom')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
$(function () {
    const statsUrl   = "{{ route('console.monitoring.stats') }}";
    const historyUrl = "{{ route('console.monitoring.history') }}";
    const POLL_MS    = 5000;
    const MAX_POINTS = 60;

    const ctx = document.getElementById('live-chart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                { label: 'CPU %', data: [], borderColor: '#17a2b8', backgroundColor: 'rgba(23,162,184,.1)', tension: .3, fill: true },
                { label: 'RAM %', data: [], borderColor: '#28a745', backgroundColor: 'rgba(40,167,69,.1)', tension: .3, fill: true }
            ]
        },
        options: {
            responsive: true,
            animation: false,
            scales: { y: { min: 0, max: 100, ticks: { callback: v => v + '%' } } }
        }
    });

    function pushPoint(time, cpu, mem) {
        chart.data.labels.push(time);
        chart.data.datasets[0].data.push(cpu);
        chart.data.datasets[1].data.push(mem);
        if (chart.data.labels.length > MAX_POINTS) {
            chart.data.labels.shift();
            chart.data.datasets[0].data.shift();
            chart.data.datasets[1].data.shift();
        }
        chart.update();
    }

    function setCard(prefix, percent, detailText, detailId) {
        const v = (percent === null || percent === undefined) ? '--%' : percent + '%';
        $('#' + prefix + '-value').text(v);
        $('#' + prefix + '-bar').css('width', (percent || 0) + '%');
        if (detailId) $('#' + detailId).text(detailText);
    }

    function refresh() {
        $.getJSON(statsUrl)
            .done(function (d) {
                setCard('cpu', d.cpu.percent, '', null);
                $('#cpu-cores').text((d.cpu.cores ?? '--') + ' core');

                setCard('mem', d.memory.percent,
                    (d.memory.used_mb ?? '--') + ' / ' + (d.memory.total_mb ?? '--') + ' MB', 'mem-detail');

                setCard('disk', d.disk.percent,
                    (d.disk.used_gb ?? '--') + ' / ' + (d.disk.total_gb ?? '--') + ' GB', 'disk-detail');

                pushPoint(d.time, d.cpu.percent, d.memory.percent);
                $('#last-update').text('update: ' + d.time);
            })
            .fail(function () {
                $('#last-update').text('gagal ambil data');
            });
    }

    $.getJSON(historyUrl)
        .done(function (rows) { (rows || []).forEach(row => pushPoint(row.time, row.cpu, row.mem)); })
        .always(function () {
            refresh();
            setInterval(refresh, POLL_MS);
        });
});
</script>
@endpush