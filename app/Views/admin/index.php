<?= $this->extend('admin/template/app') ?>

<?= $this->section('title') ?>
Hao
<?= $this->endSection() ?>

<?= $this->section('name_page') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-shopping-bag text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="small text-muted mb-0">Total Transactions</p>
                        <span class="h3 mb-0" id="totalTransactions">0</span>
                        <!-- <span class="small text-muted">+5.5%</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-inbox text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="small text-muted mb-0">Total Products</p>
                        <span class="h3 mb-0" id="totalProducts">0</span>
                        <!-- <span class="small text-success">+16.5%</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-users text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="small text-muted mb-0">Total Users</p>
                        <span class="h3 mb-0" id="totalUsers">0</span>
                        <!-- <span class="small text-success">+16.5%</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-4">
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-3 text-center">
                        <span class="circle circle-sm bg-primary">
                            <i class="fe fe-16 fe-credit-card text-white mb-0"></i>
                        </span>
                    </div>
                    <div class="col pr-0">
                        <p class="small text-muted mb-0">Total Profit</p>
                        <span class="h3 mb-0" id="totalProfit">Rp. 0</span>
                        <!-- <span class="small text-success">+16.5%</span> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- charts-->
<div class="row my-4">
    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="text-center">Week Of Transaction</h6>
            </div>
            <div class="card-body">
                <div class="chart-box">
                    <div id="weekTransCart"></div>
                </div>
            </div>
        </div>
    </div> <!-- .col -->

    <div class="col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="text-center">Transaction Status</h6>
            </div>
            <div class="card-body">
                <div id="chart-box" style="overflow: auto;">
                    <div id="statusTrans"></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- end section -->
<?= $this->endSection() ?>

<?= $this->section('footer') ?>
<script>
    $.ajax({
        url: window.api_url + 'totalData',
        type: 'GET',
        success: function(res){
            $("#totalTransactions").html(res.transaction);
            $("#totalProducts").html(res.product);
            $("#totalUsers").html(res.users);
            $("#totalProfit").html(res.profit);
        }
    })
    $.ajax({
        url: window.api_url + 'weekTransaction',
        type: 'GET',
        success: function(res) {
            var columnChart, columnChartoptions = {
                    series: [{
                        name: "Process",
                        data: res.processPriceTrans
                    },{
                        name: "Success",
                        data: res.successPriceTrans
                    },{
                        name: "Failed",
                        data: res.failedPriceTrans
                    }],
                    colors: ["#6c757d", "#3ad29f", "#dc3545"],
                    chart: {
                        type: "bar",
                        height: 350,
                        stacked: !1,
                        columnWidth: "70%",
                        zoom: {
                            enabled: !0
                        },
                        toolbar: {
                            show: !1
                        },
                        background: "transparent"
                    },
                    dataLabels: {
                        enabled: !1
                    },
                    theme: {
                        mode: colors.chartTheme
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: "bottom",
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: !1,
                            columnWidth: "40%",
                            radius: 30,
                            enableShades: !1,
                            endingShape: "rounded"
                        }
                    },
                    xaxis: {
                        type: "text",
                        categories: res.dateTrans,
                        labels: {
                            show: !0,
                            trim: !0,
                            minHeight: void 0,
                            maxHeight: 120,
                            style: {
                                colors: colors.mutedColor,
                                cssClass: "text-muted",
                                fontFamily: base.defaultFontFamily
                            }
                        },
                        axisBorder: {
                            show: !1
                        }
                    },
                    yaxis: {
                        labels: {
                            show: !0,
                            trim: !1,
                            offsetX: -10,
                            minHeight: void 0,
                            maxHeight: 120,
                            style: {
                                colors: colors.mutedColor,
                                cssClass: "text-muted",
                                fontFamily: base.defaultFontFamily
                            }
                        }
                    },
                    legend: {
                        position: "top",
                        fontFamily: base.defaultFontFamily,
                        fontWeight: 400,
                        labels: {
                            colors: colors.mutedColor,
                            useSeriesColors: !1
                        },
                        markers: {
                            width: 10,
                            height: 10,
                            strokeWidth: 0,
                            strokeColor: "#fff",
                            fillColors: ["#6c757d", "#3ad29f", "#dc3545"],
                            radius: 6,
                            customHTML: void 0,
                            onClick: void 0,
                            offsetX: 0,
                            offsetY: 0
                        },
                        itemMargin: {
                            horizontal: 10,
                            vertical: 0
                        },
                        onItemClick: {
                            toggleDataSeries: !0
                        },
                        onItemHover: {
                            highlightDataSeries: !0
                        }
                    },
                    fill: {
                        opacity: 1,
                        colors: ["#6c757d", "#3ad29f", "#dc3545"]
                    },
                    grid: {
                        show: !0,
                        borderColor: colors.borderColor,
                        strokeDashArray: 0,
                        position: "back",
                        xaxis: {
                            lines: {
                                show: !1
                            }
                        },
                        yaxis: {
                            lines: {
                                show: !0
                            }
                        },
                        row: {
                            colors: void 0,
                            opacity: .5
                        },
                        column: {
                            colors: void 0,
                            opacity: .5
                        },
                        padding: {
                            top: 0,
                            right: 0,
                            bottom: 0,
                            left: 0
                        }
                    }
                },
                columnChartCtn = document.querySelector("#weekTransCart");
            columnChartCtn && (columnChart = new ApexCharts(columnChartCtn, columnChartoptions)).render();
        }
    });

    $.ajax({
        url: window.api_url + 'statusToday',
        type: 'GET',
        success: function(res) {
            var options = {
                series: res.statusData,
                colors: ["#6c757d", "#eea303", "#1b68ff", "#3ad29f", "#dc3545"],
                chart: {
                    width: 400,
                    type: 'pie',
                },
                labels: res.statusLabel,
                legend: {
                    position: 'bottom'
                },
                pie: {
                    expandOnClick: true
                }
            };

            var chart = new ApexCharts(document.querySelector("#statusTrans"), options);
            chart.render();
        }
    })
</script>
<?= $this->endSection() ?>