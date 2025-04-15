@extends('backoffice.admin')

@section('titre', __('title.dashboard'))

@section('content')
    <div class="row pt-2">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2 class="text-primary">@yield('titre')</h2>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users me-1"></i> Utilisateurs</h5>
                    <p class="card-text fs-4">{{ $usersCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-plane-departure me-1"></i> Tours actifs</h5>
                    <p class="card-text fs-4">{{ $toursCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-calendar-check me-1"></i> Réservations</h5>
                    <p class="card-text fs-4">{{ $reservationsCount }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-comment-dots me-1"></i> Témoignages</h5>
                    <p class="card-text fs-4">{{ $testimonialsCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-12">
            <div class="card shadow-none" style="height: 500px;">
                <canvas id="reservationsChart" height="500"></canvas>
            </div>
        </div>
    </div>

    <div class="row mb-2">
       <div class="col-12">
            <div class="card shadow-sm p-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm mt-4">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Tour</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestReservations as $res)
                                <tr>
                                    <td>{{ $res->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $res->name }}</td>
                                    <td>{{ $res->email }}</td>
                                    <td>{{ $res->tour->title ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
       </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reservationsChart').getContext('2d');
    const reservationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! $labels !!},
            datasets: [{
                label: 'Réservations par mois',
                data: {!! $data !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgb(54, 162, 235)',
                borderWidth: 1,
                borderRadius: 5,
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush
