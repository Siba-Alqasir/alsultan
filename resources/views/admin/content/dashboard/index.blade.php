@extends('admin.layouts.contentLayoutMaster')
@section('title', 'Dashboard')
@section('content')
    <section id="dashboard-ecommerce">
        <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <a href="{{url('admin/categories')}}">
                        <div class="card-header">
                            <div>
                                <h2 class="font-weight-bolder mb-0">{{\App\Models\Category::count()}} </h2>
                                <p class="card-text">Categories Count</p>
                            </div>
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i data-feather="list" class="avatar-icon" style="width: 2rem; height: 2rem"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <a href="{{url('admin/products?category=1')}}">
                        <div class="card-header">
                            <div>
                                <h2 class="font-weight-bolder mb-0"> {{\App\Models\Product::count()}}</h2>
                                <p class="card-text">Products Count</p>
                            </div>
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i data-feather="list" class="avatar-icon" style="width: 2rem; height: 2rem"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 col-sm-6 col-12">
                <div class="card">
                    <a href="{{url('admin/projects')}}">
                        <div class="card-header">
                            <div>
                                <h2 class="font-weight-bolder mb-0">{{\App\Models\Project::count()}}</h2>
                                <p class="card-text">Projects Count</p>
                            </div>
                            <div class="avatar bg-light-primary p-50 m-0">
                                <div class="avatar-content">
                                    <i data-feather="help-circle" class="avatar-icon" style="width: 2rem; height: 2rem"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section id="chartjs-chart">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Inquiries Statistics</h4><span>(Last 30 days)</span>
                    </div>
                    <div class="card-body">
                        <div style="height:500px">
                            <canvas class="bar-chart-ex chartjs"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
    <script src="{{ asset(mix('admin-assets/vendors/js/charts/chart.min.js')) }}"></script>
    <script>
        new Chart($('.bar-chart-ex'), {
            type: 'bar',
            options: {
                responsive: true,
                maintainAspectRatio: false,
                responsiveAnimationDuration: 500,
                legend: {
                    display: false
                },
                tooltips: {
                    // Updated default tooltip UI
                    shadowOffsetX: 1,
                    shadowOffsetY: 1,
                    shadowBlur: 8,
                    shadowColor: 'rgba(0, 0, 0, 0.25)',
                    backgroundColor: window.colors.solid.white,
                    titleFontColor: window.colors.solid.black,
                    bodyFontColor: window.colors.solid.black
                },
                scales: {
                    xAxes: [
                        {
                            display: true,
                            gridLines: {
                                display: true,
                                color: 'rgba(200, 200, 200, 0.2)',
                                zeroLineColor: 'rgba(200, 200, 200, 0.2)'
                            },
                            ticks: {
                                fontColor: '#b4b7bd'
                            }
                        }
                    ],
                    yAxes: [
                        {
                            display: true,
                            gridLines: {
                                color: 'rgba(200, 200, 200, 0.2)',
                                zeroLineColor: 'rgba(200, 200, 200, 0.2)'
                            }
                        }
                    ]
                }
            },
            data: {
                labels: {!! json_encode($inquires->pluck('date')) !!},
                datasets: [
                    {
                        data: {!! json_encode($inquires->pluck('count')) !!},
                        barThickness: 25,
                        backgroundColor: randomColor = "#" + Math.floor(Math.random() * 16777215).toString(16),
                        borderColor: 'transparent'
                    }
                ]
            }
        });
    </script>
@endsection
