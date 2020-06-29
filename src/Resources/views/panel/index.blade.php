@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        var csrf = "{!! csrf_token() !!}";
        function getGoogleAnalytics(){
            return $.ajax({
                url:'/panel/googleAnalytics',
                method:'GET',
                data:{
                    "_token": csrf,
                },
                async: false,
                success: function (s1,s2,s3) {
                }
            });
        }
        $(window).on('load',function () {
            var google_data = getGoogleAnalytics().responseJSON;
            var devices = google_data.device;
            var page_views = google_data.page_views;
            var page_views_date = google_data.page_views_date;
            var baslik = [['day','Visitors']];
            $.each(page_views_date,function(key,value){
                value[0] = value[0].slice(-2);
                value[0] = Number(value[0]);
                value[1] = Number(value[1]);
            });
            page_views_date = baslik.concat(page_views_date);
            console.log(page_views_date);
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                var data = google.visualization.arrayToDataTable(
                    devices

                );
                var options = {
                    is3D: true,
                };

                var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
                chart.draw(data, options);
            }

            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawMultSeries);

            function drawMultSeries() {

                var data = google.visualization.arrayToDataTable(page_views_date);

                var options = {
                    title: 'Last 30 Days Visitors',
                };

                var chart = new google.visualization.ColumnChart(
                    document.getElementById('chart'));

                chart.draw(data, options);
            }
            $('#total_page_views').append(page_views);
        });
    </script>

@endpush
@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 col-8 align-self-center">
                    <h3 class="text-themecolor">Dashboard</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- Row -->
            <div class="row">
                <!-- Column -->
                <div class="col-12">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-block">

                                <div id="chart">

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">

                        <div class="card col-6">
                            <div class="card-block bg-info">
                                <h4 class="text-white card-title">{!! trans('cms::panel.received') !!}</h4>
                                <h6 class="card-subtitle text-white m-b-0 op-5">You have  {!! count($messages) !!} unread notifications</h6>
                            </div>
                            <div class="card-block">
                                <div class="message-box contact-box">
                                    <div class="message-widget contact-widget">
                                        @foreach($messages as $message)
                                            <!-- Message -->
                                            <a href="{!! route('messages.show',$message->id) !!}">
                                                <div class="user-img"> <img src="{!! asset('vendor/cms/assets/images/information.png') !!}" alt="user" class="img-circle"></div>
                                                <div class="mail-contnet">

                                                <h5 @if($message->read == 0) class="font-weight-bold" @endif>{!! $message->form->name !!}</h5></div>
                                            </a>
                                        @endforeach
                                        {{ $messages->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card col-6">
                            <div class="card-block bg-info">
                                <h4 class="text-white card-title">Kullanıcı logları gelecek</h4>
                                <h6 class="card-subtitle text-white m-b-0 op-5">{!! trans('cms::panel.forms') !!}</h6>
                            </div>
                            <div class="card-block">
                                <div class="message-box contact-box">
                                    <div class="message-widget contact-widget">
                                        @foreach($messages as $message)
                                            <!-- Message -->
                                            <a href="{!! route('messages.show',$message->id) !!}">
                                                <div class="user-img"> <img src="{!! asset('vendor/cms/assets/images/email.png') !!}" alt="user" class="img-circle"></div>
                                                <div class="mail-contnet">
    
                                                <h5 @if($message->read == 0) class="font-weight-bold" @endif>{!! $message->form->name !!}</h5></div>
                                            </a>
                                        @endforeach
                                        {{ $messages->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4 col-xlg-3 col-md-5">
                        <!-- Column -->

                        <!-- Column -->

                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>

    </div>
@endsection
