@extends('layouts.master')
@section('title')
    لوحة التحكم - برنامج الموردين
@stop
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
	<script src="{{URL::asset('assets/js/chart.flot.js')}}"></script>

@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">مرحبا بعودتك مجددا</h2>
                <p class="mg-b-0">نقدم لك لوحة أدارة الموردين - المطور غيث ابراهيم حسن</p>
            </div>
        </div>
        <div class="main-dashboard-header-right">
            <div>
                <label class="tx-13">تقييم العملاء</label>
                <div class="main-star">
                    <i class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star active"></i> <i class="typcn typcn-star active"></i> <i
                        class="typcn typcn-star"></i> <span>(14,873)</span>
                </div>
            </div>

        </div>
    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                   12
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7"> عدد الفواتير الاجمالية 2 </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7">100%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h3 class="tx-20 font-weight-bold mb-1 text-white">

                                    12

                                </h3>
                                <p class="mb-0 tx-12 text-white op-7"> عدد الفواتير غير المدفوعة 11
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7">

                                    @php
                                    // $count_all= App\Models\Invoices::count();
                                    // $count_invoices2 = App\Models\Invoices::where('Value_Status', 2)->count();

                                    // if($count_invoices2 == 0){
                                       echo 10;
                                    // }
                                    // else{
                                    	// $count_invoices2 = round($count_invoices2 / $count_all *100);
										// echo $count_invoices2.'%';
                                    // }
                                    @endphp

                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                    13

                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">
                                   عدد الفواتير المدفوعة 21
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7">
                                    @php
                                        // $count_all= App\Models\Invoices::count();
                                        // $count_invoices1 = App\Models\Invoices::where('Value_Status', 1)->count();

                                        // if($count_invoices1 == 0){
                                           echo 23;
                                        // }
                                        // else{
                                        	// $count_invoices1 = round($count_invoices1 / $count_all *100);
											// echo $count_invoices1.'%';
                                        // }
                                    @endphp
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                    231

                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">
                                    عدد الفواتير المدفوعة جزئيا 44
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7">
                                    @php
                                        // $count_all= App\Models\Invoices::count();
                                        // $count_invoices1 = App\Models\Invoices::where('Value_Status', 1)->count();

                                        // if($count_invoices1 == 0){
                                            echo 22;
                                        // }
                                        // else{
                                        //   $count_invoices1 = round($count_invoices1 / $count_all *100);
										//   echo   $count_invoices1.'%';
                                        // }
                                    @endphp
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
    </div>
    <!-- row closed -->
    <div class="row row-sm">
        <!-- الرسم الأول -->
        <div class="col-lg-12 col-xl-6">
            <div class="card shadow-lg">
                <div class="card-header bg-transparent pd-b-0 pd-t-20 bd-b-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0 text-primary">نسبة احصائية الفواتير</h4>
                        <i class="mdi mdi-dots-horizontal text-secondary"></i>
                    </div>
                </div>
                <div class="card-body" style="width: 100%; padding: 20px; background-color: #f8f9fa; border-radius: 12px;">
                    <div>
                        <canvas id="myChart1"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسم الثاني -->
        <div class="col-lg-12 col-xl-6">
            <div class="card card-dashboard-map-one shadow-lg">
                <label class="main-content-label text-primary" style="padding: 15px; font-weight: bold;">نسبة احصائية الفواتير</label>
                <div class="card-body" style="width: 100%; padding: 20px; background-color: #f8f9fa; border-radius: 12px;">
                    <div>
                        <canvas id="myCha"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row opened -->
    <!-- Container closed -->
@endsection
@section('js')

    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // رسم دائري (Pie Chart)
        var ctx1 = document.getElementById('myChart1').getContext('2d');
        var myPieChart = new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: ['مدفوع', 'غير مدفوع', 'مدفوع جزئياً'],
                datasets: [{
                    data: [2, 5, 1],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107'],
                    hoverBackgroundColor: ['#218838', '#c82333', '#e0a800']
                }]
            },
            options: {
                responsive: true
            }
        });

        // رسم أعمدة (Bar Chart)
        var ctx2 = document.getElementById('myCha').getContext('2d');
        var myBarChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['مدفوع', 'غير مدفوع', 'مدفوع جزئياً'],
                datasets: [{
                    label: 'عدد الفواتير',
                    data: [12, 5, 90],
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>


@endsection
