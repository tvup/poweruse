@extends("layouts.app")

@section('content')
    <div class="container mt-4">
        @if(@isset($chart))
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                <div class="bg-white graph-output">
                    <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                            <div class="ml-4 mt-2">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ __('Price pr. hour - all tariff incl. VAT') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <canvas id="userChart" class="rounded shadow"></canvas>
                </div>
            </div>
        @endif
        @if(@isset($data))
        <div class="card">
            <pre class="json-output">{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
        </div>
        @endif
        <div class="card">
            <div class="card-header font-weight-bold">
                <h2 class="card-title text-lg leading-6 font-medium text-gray-900">
                    {{ __('Get total prices for next hours') }}
                </h2>
            </div>
            <x-totalprices.form :companies="$companies"/>
        </div>
    </div>
@endsection

@if(@isset($chart))
    @section('javaScript')
            var ctx = document.getElementById('userChart').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(collect($chart->labels)->map(function($value) {return substr($value,11,12);})->toArray()) !!},
                    datasets: [
                        {
                            label: 'DK2',
                            backgroundColor: {!! json_encode($chart->colours)!!},
                            data: {!! json_encode($chart->dataset)!!},
                        },
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    if (value % 0.5 === 0) {
                                        return value;
                                    }
                                }
                            },
                            scaleLabel: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                            labels: {
                                // This more specific font property overrides the global property
                                fontColor: '#122C4B',
                                fontFamily: "'Muli', sans-serif",
                                padding: 25,
                                boxWidth: 25,
                                fontSize: 14,
                            }
                        },
                    },
                    layout: {
                        padding: {
                            left: 10,
                            right: 10,
                            top: 0,
                            bottom: 10
                        }
                    }
                }
            });
            if (window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true) {
                document.addEventListener('DOMContentLoaded', () => {
                    const lastAccessTime = localStorage.getItem('lastAccessTime');
                    const currentHour = new Date().getHours();
                    localStorage.setItem('lastAccessTime', currentHour);
                });
                document.addEventListener('visibilitychange', () => {
                    if (document.visibilityState === 'visible') {
                        const lastAccessTime = localStorage.getItem('lastAccessTime');
                        const currentHour = new Date().getHours();
                        if (lastAccessTime !== null && parseInt(lastAccessTime) !== currentHour) {
                            localStorage.setItem('lastAccessTime', currentHour);
                            location.reload();
                        }
                    }
                });
            }
    @endsection
@endif

