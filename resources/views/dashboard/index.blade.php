@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stat-card-1 { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
    .stat-card-2 { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
    .stat-card-3 { background: linear-gradient(135deg, #16a34a, #15803d); }
    .stat-card-4 { background: linear-gradient(135deg, #dc2626, #b91c1c); }
    .upcoming-item { border-left: 3px solid #0ea5e9; padding-left: 12px; margin-bottom: 12px; }
    .upcoming-item .appt-time { font-size: .78rem; color: #64748b; }
</style>
@endpush

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-1 d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-number">{{ $totalUsers }}</div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-2 d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-number">{{ $myAppointments }}</div>
                <div class="stat-label">My Appointments</div>
            </div>
            <div class="stat-icon"><i class="bi bi-calendar-event-fill"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-3 d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-number">{{ $completedCount }}</div>
                <div class="stat-label">Completed</div>
            </div>
            <div class="stat-icon"><i class="bi bi-check-circle-fill"></i></div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card stat-card-4 d-flex justify-content-between align-items-center">
            <div>
                <div class="stat-number">{{ $scheduledCount }}</div>
                <div class="stat-label">Scheduled</div>
            </div>
            <div class="stat-icon"><i class="bi bi-clock-fill"></i></div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-graph-up me-2 text-primary"></i>Monthly Appointments (Last 6 Months)</div>
            <div class="card-body">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header"><i class="bi bi-pie-chart-fill me-2 text-primary"></i>Appointment Status</div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <canvas id="statusChart" style="max-height:220px"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header"><i class="bi bi-bar-chart-fill me-2 text-primary"></i>Appointments by Service</div>
            <div class="card-body">
                <canvas id="serviceChart" height="130"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-calendar-event me-2 text-primary"></i>Upcoming Appointments</span>
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($upcomingAppointments as $appt)
                <div class="upcoming-item">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-600">{{ $appt->title }}</div>
                            <div class="appt-time"><i class="bi bi-person me-1"></i>{{ $appt->client_name }}</div>
                            <div class="appt-time"><i class="bi bi-clock me-1"></i>{{ $appt->appointment_date->format('M d, Y h:i A') }}</div>
                        </div>
                        <span class="badge bg-info text-dark">{{ $appt->service }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-4">
                    <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>No upcoming appointments
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: @json($monthLabels),
            datasets: [{
                label: 'Appointments',
                data: @json($monthlyData),
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14,165,233,.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#0ea5e9',
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Scheduled', 'Completed', 'Cancelled'],
            datasets: [{
                data: [{{ $scheduledCount }}, {{ $completedCount }}, {{ $cancelledCount }}],
                backgroundColor: ['#0ea5e9', '#16a34a', '#dc2626'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { padding: 15 } } }
        }
    });

    new Chart(document.getElementById('serviceChart'), {
        type: 'bar',
        data: {
            labels: @json($serviceData->keys()),
            datasets: [{
                label: 'Appointments',
                data: @json($serviceData->values()),
                backgroundColor: ['#0ea5e9','#8b5cf6','#16a34a','#f59e0b','#dc2626'],
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
        }
    });
</script>
@endpush
