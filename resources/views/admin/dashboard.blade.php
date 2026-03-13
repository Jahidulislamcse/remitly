@extends('admin.layouts.app')

@section('panel')
    <div class="row responsive-row">

        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="#" variant="primary" title="Deposit" :value="$topupCount"
                icon="la la-exchange-alt" :currency="false" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="#" variant="primary" title="Remittance" :value="$remittanceCount"
                icon="la la-exchange-alt" :currency="false" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="#" variant="primary" title="Mobile Banking Trasfer" :value="$mobileBankingCount"
                icon="la la-exchange-alt" :currency="false" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="#" variant="primary" title="Bank Transfer" :value="$bankPayCount"
                icon="la la-exchange-alt" :currency="false" />
        </div>

        
        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="#" variant="primary" title="Mobile Recharge" :value="$mobileRechargeCount"
                icon="la la-exchange-alt" :currency="false" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-admin.ui.widget.four url="#" variant="primary" title="Balance" :value="$balance"
                icon="la la-exchange-alt" :currency="false" />
        </div>


    </div>



    {{-- Charts --}}

    <div class="row responsive-row">

        <div class="col-lg-6">
            <x-admin.ui.card class="h-100">

                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('User Statistics')</h4>
                </x-admin.ui.card.header>

                <x-admin.ui.card.body class="text-center">
                    <div id="userChart"></div>
                </x-admin.ui.card.body>

            </x-admin.ui.card>
        </div>


        <div class="col-lg-6">
            <x-admin.ui.card class="h-100">

                <x-admin.ui.card.header>
                    <h4 class="card-title">@lang('Deposit Statistics')</h4>
                </x-admin.ui.card.header>

                <x-admin.ui.card.body>
                    <div id="revenueChart"></div>
                </x-admin.ui.card.body>

            </x-admin.ui.card>
        </div>

    </div>



    {{-- Financial Overview --}}

    <div class="row responsive-row">

        <div class="col-xxl-6">

            <div class="card shadow-none h-100">

                <div class="card-header border-0">
                    <h5 class="card-title">@lang('Deposit Overview')</h5>
                </div>

                <div class="card-body">

                    <div class="widget-card-wrapper custom-widget-wrapper">

                        <div class="row g-0">

                            <div class="col-sm-6">
                                <div class="widget-card widget--success">
                                    <div class="widget-card-left">
                                        <span class="widget-icon"><i class="fas fa-hand-holding-usd"></i></span>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Received Add Money')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($totalAddMoney, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="widget-card widget--warning">
                                    <div class="widget-card-left">
                                        <div class="widget-icon"><i class="fas fa-spinner"></i></div>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Pending Add Money')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($pendingAddMoney, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="widget-card widget--danger">
                                    <div class="widget-card-left">
                                        <div class="widget-icon"><i class="fas fa-ban"></i></div>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Rejected Add Money')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($rejectedAddMoney, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="widget-card widget--primary">
                                    <div class="widget-card-left">
                                        <div class="widget-icon"><i class="fas fa-percentage"></i></div>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Customer Commission')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($addMoneyCharge, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>




        <div class="col-xxl-6">

            <div class="card shadow-none h-100">

                <div class="card-header border-0">
                    <h5 class="card-title">@lang('Withdrawal Overview')</h5>
                </div>

                <div class="card-body">

                    <div class="widget-card-wrapper custom-widget-wrapper">

                        <div class="row g-0">


                            <div class="col-sm-6">
                                <div class="widget-card widget--success">
                                    <div class="widget-card-left">
                                        <span class="widget-icon"><i class="fas fa-hand-holding-usd"></i></span>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Total Withdrawal')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($totalWithdrawal, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="widget-card widget--warning">
                                    <div class="widget-card-left">
                                        <div class="widget-icon"><i class="fas fa-spinner"></i></div>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Pending Withdrawal')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($pendingWithdrawal, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="widget-card widget--danger">
                                    <div class="widget-card-left">
                                        <div class="widget-icon"><i class="fas fa-ban"></i></div>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Rejected Withdrawal')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($rejectedWithdrawal, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

         <div class="col-xxl-6">

            <div class="card shadow-none h-100">

                <div class="card-header border-0">
                    <h5 class="card-title">@lang('Remittance Overview')</h5>
                </div>

                <div class="card-body">

                    <div class="widget-card-wrapper custom-widget-wrapper">

                        <div class="row g-0">


                            <div class="col-sm-6">
                                <div class="widget-card widget--success">
                                    <div class="widget-card-left">
                                        <span class="widget-icon"><i class="fas fa-hand-holding-usd"></i></span>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Processed Remittance')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($totalRemittance, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="widget-card widget--warning">
                                    <div class="widget-card-left">
                                        <div class="widget-icon"><i class="fas fa-spinner"></i></div>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Pending Remittance Request')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($pendingRemittance, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <div class="widget-card widget--danger">
                                    <div class="widget-card-left">
                                        <div class="widget-icon"><i class="fas fa-ban"></i></div>
                                        <div class="widget-card-content">
                                            <p class="widget-title fs-14">@lang('Rejected Remittance Request')</p>
                                            <h6 class="widget-amount">৳ {{ number_format($rejectedRemittance, 2) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- Agent Stats --}}

    <div class="row responsive-row">

    </div>



    {{-- Merchant Stats --}}

    {{-- <div class="row responsive-row">

<div class="col-xxl-3 col-sm-6">
<x-admin.ui.widget.one url="#" variant="primary" title="Total Merchant"
:value="$totalMerchant" icon="las la-store" />
</div>

<div class="col-xxl-3 col-sm-6">
<x-admin.ui.widget.one url="#" variant="success" title="Active Merchant"
:value="$activeMerchant" icon="las la-user-check" />
</div>

<div class="col-xxl-3 col-sm-6">
<x-admin.ui.widget.one url="#" variant="warning" title="Email Unverified Merchant"
:value="$emailUnverifiedMerchant" icon="lar la-envelope" />
</div>

<div class="col-xxl-3 col-sm-6">
<x-admin.ui.widget.one url="#" variant="danger" title="Mobile Unverified Merchant"
:value="$mobileUnverifiedMerchant" icon="las la-comment-slash" />
</div>

</div> --}}
@endsection


@push('script-lib')
    <script src="{{ asset('assets/admin/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
@endpush


@push('style-lib')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/global/css/flatpickr.min.css') }}">
@endpush

@push('script')
    <script>
        "use strict";
        (function($) {
            // User Statistics Pie Chart
            (function() {
                const options = {
                    series: [
                        {{ $activeUsers }},
                        {{ $inactiveUsers }},
                        {{ $pendingUsers }},
                        {{ $blockedUsers }}
                    ],
                    chart: {
                        type: 'donut',
                        height: 350,
                        width: '100%'
                    },
                    labels: ['Active Users', 'Inactive Users', 'Pending Users', 'Banned Users'],
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) {
                            return Math.round(val) + '%';
                        }
                    },
                    colors: ['#33c758', '#ff382e', '#ff9500', '#6338ff'],
                    legend: {
                        position: 'bottom',
                        markers: {
                            show: true
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            }
                        }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#userChart"), options);
                chart.render();
            })();

            // Revenue Statistics Bar Chart
            (function() {

                const options = {
                    series: [{
                        name: "Topups",
                        data: @json($topupGraph)
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            borderRadiusApplication: 'end',
                            columnWidth: '55%'
                        }
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: @json($months),
                        title: {
                            text: 'Months'
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Total Topups'
                        }
                    },
                    colors: ['#33c758'],
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " Deposits";
                            }
                        }
                    }
                };

                var chart = new ApexCharts(document.querySelector("#revenueChart"), options);
                chart.render();

            })();
        })(jQuery);
    </script>
@endpush
