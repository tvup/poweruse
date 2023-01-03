@extends("layout")

@section('content')
<x-app-layout>
    <div class="container mt-4">
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {!! session('error') !!}
            </div>
        @endif
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                Hent aktuelle totalpriser
            </div>
            @if(@isset($chart))
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
            @endif
            @if(@isset($data))
                <pre class="json-output">{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
            @endif
            <div class="card-body">
                <form name="add-blog-post-form" id="add-blog-post-form" method="post"
                      action="{{url('getTotalPrices')}}">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="exampleInputEmail1">Vis som:</label>
                        JSON {{ Form::radio('outputformat', 'JSON' , (old('outputformat') && old('outputformat')=='JSON') ? old('outputformat') : true) }}
                        GRAF {{ Form::radio('outputformat', 'GRAF' , (old('outputformat') && old('outputformat')=='GRAF') ? old('outputformat') : false) }}
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Netselskab</label><br/>
                        {!! Form::select('netcompany', $companies, old('area') ? : null, ['class' => 'form-control']) !!}
                    </div>


                    <button type="submit" class="btn btn-primary">Hent</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
    <script type="text/javascript">
        $('.date').datepicker({
            format: 'yyyy-mm-dd'
        });

    </script>

    <script>
        $(function () {
            $(document).ready(function () {
                $(".alert").slideDown(300).delay(10000).slideUp(300);
            });
        });
    </script>
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

    <script>
        $(function() {
            $('input[name="outputformat"]').change(function() {
                updateShowData($('input[name="outputformat"]:checked').val());
            });

            function updateShowData($type) {
                console.log($type);
                switch ($type) {
                    case "GRAF":
                        $('.graph-output').show();
                        $('.json-output').hide();
                        break;
                    case "JSON":
                        $('.json-output').show();
                        $('.graph-output').hide();
                        break;
                }
            }
            updateShowData($('input[name="outputformat"]:checked').val());
        });
    </script>

@endsection
