@extends('layouts.admin')

@section('header_css')
<link rel="stylesheet" type="text/css" href="/AdminLTE/plugins/morris/morris.css">
<style>
  .box-header>.fa, .box-header>.glyphicon, .box-header>.ion, .box-header .box-title{
    font-size: 15px;
  }
</style>
@endsection
@section('content')
<section class="content-header">
    <h1>
        Dashboard management
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>       
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$restaurant_count}}</h3>

              <p>Total restaurants</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$prouser_count}}</h3>

              <p>Pro users</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$normaluser_count}}</h3>
                <p>Normal users</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people-outline"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$dish_today_count}}</h3>

              <p>Dish today</p>
            </div>
            <div class="icon">
              <i class="fa fa-cutlery"></i>
            </div>
            <!--<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div>
        </div>
        <!-- ./col -->
    </div>

   <!--  BAR CHAR SECTION -->
    <div class="row">
        <!-- BAR CHAR RESTAURANT -->
        <div class="col-lg-3 col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{!! trans('dashboard.new_restaurant')!!}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool prev-month"><i class="fa fa-chevron-left"></i></button>
                  <span id="month-booking" data-type="restaurant" data-month="{!! (int)date('m')!!}">{!! date('F') !!}</span>
                <button type="button" class="btn btn-box-tool next-month"><i class="fa fa-chevron-right"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="chart-restaurant" style="max-height: 250px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- END BAR CHAR RESTAURANT -->
        <!-- BAR CHAR Pro user -->
        <div class="col-lg-3 col-md-6">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">{!! trans('dashboard.new_prousers')!!}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool prev-month"><i class="fa fa-chevron-left"></i></button>
                  <span id="month-booking" data-type="pro-user" data-month="{!! (int)date('m')!!}">{!! date('F') !!}</span>
                <button type="button" class="btn btn-box-tool next-month"><i class="fa fa-chevron-right"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="chart-pro-user" style="max-height: 250px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- end BAR CHAR Pro user -->
        <!-- BAR CHAR normal user -->
        <div class="col-lg-3 col-md-6">
          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">{!! trans('dashboard.new_normalusers')!!}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool prev-month"><i class="fa fa-chevron-left"></i></button>
                  <span id="month-booking" data-type="normal-user" data-month="{!! (int)date('m')!!}">{!! date('F') !!}</span>
                <button type="button" class="btn btn-box-tool next-month"><i class="fa fa-chevron-right"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="chart-normal-user" style="max-height: 250px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- end BAR CHAR normal user -->
        <!-- BAR CHAR dishes -->
        <div class="col-lg-3 col-md-6">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">{!! trans('dashboard.new_dishes')!!}</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool prev-month"><i class="fa fa-chevron-left"></i></button>
                  <span id="month-booking" data-type="dishes" data-month="{!! (int)date('m')!!}">{!! date('F') !!}</span>
                <button type="button" class="btn btn-box-tool next-month"><i class="fa fa-chevron-right"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="chart-dish" style="max-height: 250px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <!-- end BAR CHAR dishes -->
        <div class="col-md-6">
            <!-- BAR CHART -->

            <div class="box box-success">
              <div class="box-header with-border">
                <h3 class="box-title">User register statistics</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChart" style="height:230px"></canvas>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
        <!-- /.box -->
        </div>
        <div class="col-md-6">
           <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Restaurants Statistics</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <canvas id="pieChart" style="height:250px"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
    </div>
</section>
@endsection
@section('footer_js')
<!-- ChartJS 1.0.1 -->
<script src="/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/AdminLTE/plugins/chartjs/Chart.min.js"></script>
<script src="/AdminLTE/plugins/morris/morris.min.js"></script>
<script type="text/javascript">
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
$( document ).ready(function() {  
    var labels_pro = [];
    var data_pro = [];
    @foreach($statistics_regis as $key => $pro_regis)
    labels_pro.push('{{$key}}');
    data_pro.push({{$pro_regis}});
    @endforeach
    //var labels_pro = [];
    var data_normal = [];
    @foreach($statistics_regis_normal as $key => $nor_regis)
    data_normal.push({{$nor_regis}});
    @endforeach
    var areaChartData = {
      labels: labels_pro,
      datasets: [
        {
          label: "Pro User Regis",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "rgba(210, 214, 222, 1)",
          pointColor: "rgba(210, 214, 222, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(220,220,220,1)",
          data: data_pro
        },
        {
          label: "Normal User",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: data_normal
        }
      ]
    };
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#00a65a";
    barChartData.datasets[1].strokeColor = "#00a65a";
    barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };
    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);

    //-------------
    //- PIE CHART -
    //-------------
    var labels_pro = [];
    var data_pro = [];
    
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    
    var colors = {'active':{'color':'#f56954','hightline':'#f56954'},
                'pending':{'color':'#00a65a','hightline':'#00a65a'},
                'verified':{'color':'#3c8dbc','hightline':'#3c8dbc'}
                }
    var PieData = [
        @foreach($statistics_resto as $key => $resto)
            {  
                value: {{$resto}},
                color: colors['{{$key}}'].color,
                highlight: colors['{{$key}}'].hightline,
                label: '{{$key}}'          
            },
        @endforeach                      
        ];
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
    });
  
  // My code ===
  var newRestaurant = JSON.parse('<?php echo $newRestaurant; ?>');
  var newProuser = JSON.parse('<?php echo $newProuser; ?>');
  var newNormaluser = JSON.parse('<?php echo $newNormaluser; ?>');
  var newDishes = JSON.parse('<?php echo $newDishes; ?>');

  var chartRestaurant = Morris.Bar({
    element: 'chart-restaurant',
    data: newRestaurant,
    xkey: 'date',
    ykeys: ['count'],
    labels: ["{!! trans('dashboard.restaurants') !!}"],
    barColors: ['#00c0ef '],
    gridIntegers: true,
    yLabelFormat: function(y){return y != Math.round(y)?'':y;}
  });

  var chartProuser = Morris.Bar({
    element: 'chart-pro-user',
    data: newProuser,
    xkey: 'date',
    ykeys: ['count'],
    labels: ["{!! trans('dashboard.prousers') !!}"],
    barColors: ['#00a65a'],
    gridIntegers: true,
    yLabelFormat: function(y){return y != Math.round(y)?'':y;}
  });

  var chartNormaluser = Morris.Bar({
    element: 'chart-normal-user',
    data: newNormaluser,
    xkey: 'date',
    ykeys: ['count'],
    labels: ["{!! trans('dashboard.normalusers') !!}"],
    barColors: ['#f39c12'],
    gridIntegers: true,
    yLabelFormat: function(y){return y != Math.round(y)?'':y;}
  });

  var chartDishes = Morris.Bar({
    element: 'chart-dish',
    data: newDishes,
    xkey: 'date',
    ykeys: ['count'],
    labels: ["{!! trans('dashboard.restaurants') !!}"],
    barColors: ['#dd4b39'],
    gridIntegers: true,
    yLabelFormat: function(y){return y != Math.round(y)?'':y;}
  });
  var monthNames = ['{!! trans('dashboard.months.January') !!}',
    '{!! trans('dashboard.months.February') !!}', '{!! trans('dashboard.months.March') !!}',
    '{!! trans('dashboard.months.April') !!}', '{!! trans('dashboard.months.May') !!}',
    '{!! trans('dashboard.months.June') !!}',
    '{!! trans('dashboard.months.July') !!}', '{!! trans('dashboard.months.August') !!}',
    '{!! trans('dashboard.months.September') !!}', '{!! trans('dashboard.months.October') !!}',
    '{!! trans('dashboard.months.November') !!}', '{!! trans('dashboard.months.December') !!}'
    ];
  $('.prev-month').click(function(event) {
        var currMonth = $(this).next('span').attr('data-month');
        var prevMonth = currMonth;
        var url = "{!! route('dashboard.data-chart') !!}";
        if(parseInt(currMonth) > 1){
            prevMonth = parseInt(currMonth) - 1;
            $(this).next('span').attr('data-month', prevMonth);
            $(this).next('span').html(monthNames[prevMonth-1]);
        }
        
        var data_type = $(this).next('span').attr('data-type');
        var dataSend = {
            data_type: data_type,
            month: prevMonth
        }
        $.post(url, dataSend, function(res){
           var jsonData =  JSON.parse(res);

            if(data_type == 'restaurant'){
                chartRestaurant.setData(jsonData);
            }

            if(data_type == 'pro-user'){
               chartProuser.setData(jsonData);
            }

            if(data_type == 'normal-user'){
                chartNormaluser.setData(jsonData);
            }
            if(data_type == 'dishes'){
                chartDishes.setData(jsonData);
            }
        });
    });

    $('.next-month').click(function(event) {
        var currMonth = $(this).prev('span').attr('data-month');
        var nextMonth = currMonth;
        var url = "{!! route('dashboard.data-chart') !!}";
        if(parseInt(currMonth) < 12){
            nextMonth = parseInt(currMonth) + 1;
            $(this).prev('span').attr('data-month',nextMonth);
            $(this).prev('span').html(monthNames[nextMonth-1]);
        }
        
        var data_type = $(this).prev('span').attr('data-type');
        var dataSend = {
            data_type: data_type,
            month: nextMonth
        }
        $.post(url, dataSend, function(res){
           var jsonData =  JSON.parse(res);

            if(data_type == 'restaurant'){
                chartRestaurant.setData(jsonData);
            }

            if(data_type == 'pro-user'){
               chartProuser.setData(jsonData);
            }

            if(data_type == 'normal-user'){
                chartNormaluser.setData(jsonData);
            }
            if(data_type == 'dishes'){
                chartDishes.setData(jsonData);
            }
        });
    });
</script>
@endsection