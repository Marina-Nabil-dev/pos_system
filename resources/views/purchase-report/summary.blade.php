@extends('layouts.app')

@section('content')
    <style>
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card:hover {
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.2);
        }

        .card-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .bg-light-primary {
            background-color: #e7f3ff;
        }

        .bg-light-danger {
            background-color: #fdecec;
        }

        .bg-light-success {
            background-color: #eafaf1;
        }
    </style>
    <div class="container mt-3">
        <div class="row">
            <!-- Summary Cards -->
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="card-icon bg-light-primary text-primary mb-2">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                    </div>
                    <h5 class="card-title">Total Purchases</h5>
                    <h3 class="fw-bold"> ${{ number_format($totalPurchases, 2) }}
                    </h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="card-icon bg-light-danger text-danger mb-2">
                        <i class="fas fa-undo fa-2x"></i>
                    </div>
                    <h5 class="card-title">Purchase Returns</h5>
                    <h3 class="fw-bold">${{ $totalPurchaseReturns }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <div class="card-icon bg-light-success text-success mb-2">
                        <i class="fas fa-boxes fa-2x"></i>
                    </div>
                    <h5 class="card-title">Current Stock</h5>
                    <h3 class="fw-bold">{{ $currentStock }} Units</h3>
                </div>
            </div>
        </div>
        <hr>
        <br>

        <!-- Purchase Trends Chart -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Purchase Trends Over Time</h2>
            <canvas id="purchaseTrendsChart" width="400" height="200"></canvas>
        </div>
        <hr>
        <br>

        <!-- Detailed Purchase History Table -->
        <div class="container mt-5">
            <h2 class="text-center mb-4">Purchase History</h2>

            <div class="row mb-3 justify-content-center">
                <div class="col-md-4">
                    <select id="typeFilter" class="form-select">
                        <option value="">All Status</option>
                        @foreach(\App\Enums\TransactionTypeEnum::cases() as $status)
                            <option value="{{ $status->value }}">{{ $status->prettifyName() }}</option>

                        @endforeach
                    </select>
                </div>
            </div>



            <table id="purchaseTable" class="table table-striped">
                <thead>
                <tr>
                    <th>Products</th>
                    <th>Transaction Type</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Created At</th>
                </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize DataTable with Ajax source
            const table = $('#purchaseTable').DataTable({
                processing: true,
                serverMethod: 'GET',
                serverSide: true,
                paging: true,
                searching: true,
                responsive: true,
                ajax: {
                    url: '{{ route('purchase.history') }}',
                    data: function (d) {
                        d.type = $('#typeFilter').val();
                    }
                },
                columns: [
                    {data: 'product_name'},
                    {data: 'transaction_type'},
                    {data: 'quantity'},
                    {data: 'amount'},
                    {data: 'created_at', name: 'created_at'}
                ],
            });

            $('#typeFilter').on('change', function () {
                table.ajax.reload();
            });
            $(document).ready(function () {
                $.ajax({
                    url: '{{ route('trends.data') }}',
                    method: 'GET',
                    success: function (response) {
                        const ctx = document.getElementById('purchaseTrendsChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: response.labels,
                                datasets: [{
                                    label: 'Purchase Amount',
                                    data: response.data,
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    borderWidth: 2,
                                    tension: 0.4, // Makes the line curve smoothly
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        display: true,
                                        position: 'top'
                                    },
                                },
                                scales: {
                                    x: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Date'
                                        }
                                    },
                                    y: {
                                        display: true,
                                        title: {
                                            display: true,
                                            text: 'Amount'
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection