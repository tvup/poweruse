<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Total prices') }}
        </h2>
    </x-slot>

    @if(@isset($chart))
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="container graph-output">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading my-2">Pris pr. time - alle tariffer inkl. moms</div>
                        <div class="col-lg-8">
                            <canvas id="userChart" class="rounded shadow"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-totalprices.form />
            </div>
        </div>
    </div>
</x-app-layout>

@if(@isset($chart))
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <!-- CHARTS -->
    <script>
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
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            callback: function (value) {
                                if (value % 1 === 0) {
                                    return value;
                                }
                            }
                        },
                        scaleLabel: {
                            display: false
                        }
                    }]
                },
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
    </script>
@endif