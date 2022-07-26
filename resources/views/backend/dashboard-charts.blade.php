

<script type="text/javascript">


//     // ==============================================================
//  // Customer acquisition
//  // ==============================================================
//  var chart = new Chartist.Line('.ct-chart', {
//      labels: ['Sat', 'Sun', 'Mon','Tui','Wed','Thu','Fri'],
//      series: [
//          [0,20,5,60,70,5,22],
//          [0,30,5,40,70,10,50]

//      ]
//  }, {
//      low: 0,
//      showArea: true,
//      // showPoint: true,
//      fullWidth: true
//  });

//  chart.on('draw', function(data) {
//      if (data.type === 'line' || data.type === 'area') {
//          data.element.animate({
//              d: {
//                  begin: 2000 * data.index,
//                  dur: 2000,
//                  from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
//                  to: data.path.clone().stringify(),
//                  easing: Chartist.Svg.Easing.easeOutQuint
//              }
//          });
//      }
//  });


// new Chartist.Line('#morris_merchantrevenue', {
// series: [[
//  {x: 1, y: 100},
//  {x: 2, y: 50},
//  {x: 3, y: 25},
//  {x: 5, y: 12.5},
//  {x: 8, y: 6.25}
// ]]
// }, {
// axisX: {
//  type: Chartist.AutoScaleAxis,
//  onlyInteger: true
// }
// });



//  // ==============================================================
//  // Total Revenue
//  // ==============================================================
//  // Morris.Area({
//  //     element: 'morris_merchantrevenue',
//  //     behaveLikeLine: true,
//  //     data: [

//  //         { x: '2016 Q1', y: 0, },
//  //         { x: '2016 Q2', y: 7500, },
//  //         { x: '2017 Q3', y: 15000, },
//  //         { x: '2017 Q4', y: 500000, },
//  //         { x: '2018 Q5', y: 30000, },
//  //         { x: '2018 Q6', y: 400, }
//  //     ],
//  //     xkey: 'x',
//  //     ykeys: ['y'],
//  //     labels: ['Y'],
//  //     lineColors: ['#5969ff'],
//  //     resize: true

//  // });

//  // ==============================================================
//  // Total Revenue
//  // ==============================================================
//  Morris.Area({
//      element: 'morris_deliverymanrevenue',
//      behaveLikeLine: true,
//      data: [

//          { x: '2016 Q1', y: 0, },
//          { x: '2016 Q2', y: 7500, },
//          { x: '2017 Q3', y: 15000, },
//          { x: '2017 Q4', y: 500000, },
//          { x: '2018 Q5', y: 30000, },
//          { x: '2018 Q6', y: 400, }
//      ],
//      xkey: 'x',
//      ykeys: ['y'],
//      labels: ['Y'],
//      lineColors: ['#5969ff'],
//      resize: true

//  });

//  // ==============================================================
//  // Total Revenue
//  // ==============================================================
//  Morris.Area({
//      element: 'morris_hubrevenue',
//      behaveLikeLine: true,
//      data: [

//          { x: '2016 Q1', y: 0, },
//          { x: '2016 Q2', y: 7500, },
//          { x: '2017 Q3', y: 15000, },
//          { x: '2017 Q4', y: 500000, },
//          { x: '2018 Q5', y: 30000, },
//          { x: '2018 Q6', y: 400, }
//      ],
//      xkey: 'x',
//      ykeys: ['y'],
//      labels: ['Y'],
//      lineColors: ['#5969ff'],
//      resize: true

//  });


</script>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script type="text/javascript">
    //  income / expense

    const ctx = document.getElementById('myChartincomeexpense');




    $('#incomeExpenseselectDays').on('change',function () {
        $.ajax({
                type: 'post',
                url: $(this).data('url'),
                data: {'days': $(this).val(),'type':'income_expense'},
                success: function (data) {
                     console.log(data);
                }
            })
    });



    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: '{{ __("expense.title") }}',
                data:
                    [

                        @foreach($data['expenseDates'] as $date)
                            {x:'{{ $date }}', y:{{  dayExpenseCount($date) }}},
                        @endforeach
                    ],
                // data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                fill:true,
                tension:0.5,
                borderWidth: 2
            },
            {
                label: '{{ __("income.title") }}',
                data:
                    [
                        
                        @foreach($data['incomeDates'] as $date)
                                {x:'{{ $date }}', y:{{  dayIncomeCount($date) }}},
                        @endforeach
                    ],
                // data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                fill:true,
                tension:0.5,
                borderWidth: 2
            }

        ],
        },
        options: {

        }
    });
</script>

<script type="text/javascript">

//    merchant revenue

    const merchant = document.getElementById('myChartmerchantrevenue');
    const merchantCarts = new Chart(merchant, {
        type: 'line',
        data: {
            datasets: [{
                label: '{{ __("expense.title") }}',
                data: [
                        @foreach($data['merchantRevDates'] as $date)
                            {x:'{{ $date }}', y:{{  dayMerchantRevExpenseCount($date) }}},
                        @endforeach
                    ],
                // data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                fill:true,
                tension:0.5,
                borderWidth: 2
            },
            {
                label: '{{ __("income.title") }}',
                data: [
                    @foreach($data['merchantRevDates'] as $date)
                            {x:'{{ $date }}', y:{{  dayMerchantRevIncomeCount($date) }}},
                    @endforeach
                    ],
                // data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                fill:true,
                tension:0.5,
                borderWidth: 2
            }

        ],
        },
        options: {

        }
    });
</script>



<script type="text/javascript">

    //    Deliveryman revenue

    const deliveryman = document.getElementById('myChartdeliverymanrevenue');
    const deliverymanCarts = new Chart(deliveryman, {
        type: 'line',
        data: {
            datasets: [{
                label: '{{ __("expense.title") }}',
                data: [
                        @foreach($data['DeliverymanRevDates'] as $date)
                            {x:'{{ $date }}', y:{{  dayDeliverymanRevExpenseCount($date) }}},
                        @endforeach
                    ],
                // data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                fill:true,
                tension:0.5,
                borderWidth: 2
            },
            {
                label: '{{ __("income.title") }}',
                data: [
                    @foreach($data['DeliverymanRevDates'] as $date)
                            {x:'{{ $date }}', y:{{  dayDeliverymanRevIncomeCount($date) }}},
                    @endforeach
                    ],
                // data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                fill:true,
                tension:0.5,
                borderWidth: 2
            }

        ],
        },
        options: {

            animations: {
            tension: {
                duration: 5000,
                easing: 'linear',
                from: 1,
                to: 0,
                loop: true
            }
            },
        }
    });
</script>


<script type="text/javascript">

    //    courier  revenue pie charts

        const courier = document.getElementById('MychartsCourierRev');

        var pieData = {
    labels: ["{{ __('income.title') }}", "{{ __('expense.title') }}"],
    datasets: [{
        data: [{{ $data['courier_income'] }}, {{ $data['courier_expense'] }}],
        backgroundColor: [
            "#5969ff",
            "#ff407b",
        ]
        }]
    };


    var myChartCourier = new Chart(courier, {
    type: 'pie',
    data: pieData

    });



    $('#MerchantselectDays').on('change',function () {

            $.ajax({
                    type: 'post',
                    url: $(this).data('url'),
                    data: {'days': $(this).val()},
                    success: function (data) {
                        console.log(data);
                    }
                })
    });

    $('#DeliverymanselectDays').on('change',function () {

            $.ajax({
                    type: 'post',
                    url: $(this).data('url'),
                    data: {'days': $(this).val()},
                    success: function (data) {
                        console.log(data);
                    }
                })
    });


</script>
