@extends('main.event.layout.event-add-layout')
@section('main')


<div class="content">

    <div class="echart-pie-edge-align-chart-example" style="min-height:320px"></div>
    <!-- </div> -->
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    @endsection

    @push('script')

    <!-- <script src="{{ asset ('assets/js/custom.js') }}"></script> -->
    <script>
        (function(factory) {
            typeof define === "function" && define.amd ? define(factory) : factory();
        })(function() {
            "use strict";

            // import * as echarts from 'echarts';
            const {
                merge
            } = window._;

            // form config.js
            const echartSetOption = (
                chart,
                userOptions,
                getDefaultOptions,
                responsiveOptions
            ) => {
                const {
                    breakpoints,
                    resize
                } = window.phoenix.utils;
                const handleResize = (options) => {
                    Object.keys(options).forEach((item) => {
                        if (window.innerWidth > breakpoints[item]) {
                            chart.setOption(options[item]);
                        }
                    });
                };

                const themeController = document.body;
                // Merge user options with lodash
                chart.setOption(merge(getDefaultOptions(), userOptions));

                const navbarVerticalToggle = document.querySelector(
                    ".navbar-vertical-toggle"
                );
                if (navbarVerticalToggle) {
                    navbarVerticalToggle.addEventListener(
                        "navbar.vertical.toggle",
                        () => {
                            chart.resize();
                            if (responsiveOptions) {
                                handleResize(responsiveOptions);
                            }
                        }
                    );
                }

                resize(() => {
                    chart.resize();
                    if (responsiveOptions) {
                        handleResize(responsiveOptions);
                    }
                });
                if (responsiveOptions) {
                    handleResize(responsiveOptions);
                }

                themeController.addEventListener(
                    "clickControl",
                    ({
                        detail: {
                            control
                        }
                    }) => {
                        if (control === "phoenixTheme") {
                            chart.setOption(
                                window._.merge(getDefaultOptions(), userOptions)
                            );
                        }
                    }
                );
            };
            // -------------------end config.js--------------------

            const pieEdgeAlignChartInit = () => {
                const {
                    getColor,
                    getData,
                    // rgbaColor
                } = window.phoenix.utils;
                const $chartEl = document.querySelector(
                    ".echart-pie-edge-align-chart-example"
                );

                // const data = [{
                //         value: 850,
                //         name: "Starter",
                //         itemStyle: {
                //             color: rgbaColor(getColor("primary"), 0.5),
                //         },
                //     },
                //     {
                //         value: 750,
                //         name: "Starter Pro",
                //         itemStyle: {
                //             color: getColor("danger"),
                //         },
                //     },
                //     {
                //         value: 457,
                //         name: "Basic",
                //         itemStyle: {
                //             color: getColor("primary"),
                //         },
                //     },
                //     {
                //         value: 654,
                //         name: "Optimal",
                //         itemStyle: {
                //             color: getColor("secondary"),
                //         },
                //     },
                //     {
                //         value: 447,
                //         name: "Business",
                //         itemStyle: {
                //             color: getColor("warning"),
                //         },
                //     },
                //     {
                //         value: 682,
                //         name: "Classic addition",
                //         itemStyle: {
                //             color: rgbaColor(getColor("warning"), 0.8),
                //         },
                //     },
                //     {
                //         value: 471,
                //         name: "Premium",
                //         itemStyle: {
                //             color: getColor("success"),
                //         },
                //     },
                //     {
                //         value: 524,
                //         name: "Platinum",
                //         itemStyle: {
                //             color: getColor("info"),
                //         },
                //     },
                //     {
                //         value: 200,
                //         name: "Platinum Pro",
                //         itemStyle: {
                //             color: rgbaColor(getColor("primary"), 0.5),
                //         },
                //     },
                // ];

                if ($chartEl) {
                    const userOptions = getData($chartEl, "echarts");
                    const chart = window.echarts.init($chartEl);
                    const getDefaultOptions = () => ({
                        legend: {
                            left: 'center',
                            textStyle: {
                                color: getColor('gray-600')
                            }
                        },
                        color: [
                            getColor('info'),
                            getColor('warning'),
                            getColor('danger'),
                            getColor('success'),
                            getColor('primary')
                        ],
                        // title: [{
                        //         text: "Pie Edge Align Chart",
                        //         left: "center",
                        //         textStyle: {
                        //             color: getColor("gray-600"),
                        //         },
                        //     },
                        //     {
                        //         subtext: 'alignTo: "edge"',
                        //         left: "50%",
                        //         top: "85%",
                        //         textAlign: "center",
                        //         subtextStyle: {
                        //             color: getColor("gray-700"),
                        //         },
                        //     },
                        // ],

                        tooltip: {
                            trigger: "item",
                            padding: [7, 10],
                            backgroundColor: getColor("gray-100"),
                            borderColor: getColor("gray-300"),
                            textStyle: {
                                color: getColor("dark")
                            },
                            borderWidth: 1,
                            transitionDuration: 0,
                            axisPointer: {
                                type: "none",
                            },
                            position(pos, ...size) {
                                if (window.innerWidth <= 540) {
                                    const tooltipHeight = size[1].offsetHeight;
                                    const obj = {
                                        top: pos[1] - tooltipHeight - 20
                                    };
                                    obj[
                                        pos[0] < size[3].viewSize[0] / 2 ?
                                        "left" :
                                        "right"
                                    ] = 5;
                                    return obj;
                                }
                                return null;
                            },
                        },

                        series: [{
                            type: "pie",
                            radius: window.innerWidth < 530 ? "45%" : "60%",
                            center: ["50%", "50%"],
                            data: <?php echo json_encode($Data); ?>,
                            label: {
                                position: "outer",
                                // alignTo: "edge",
                                formatter: '{x|{d}%}',
                                // formatter: '{x|{d}%}',
                                // formatter: '{x|{d}%} \n  {y|{b}}',
                                rich: {
                                    x: {
                                        fontSize: 11.25,
                                        fontWeight: 800,
                                        color: getColor('gray-700'),
                                        padding: [0, 0, 5, 15]
                                    },
                                    y: {
                                        fontSize: 12.8,
                                        color: getColor('gray-700'),
                                        fontWeight: 600
                                    }
                                },
                                margin: 20,
                                color: getColor("gray-700"),
                            },
                            //                 label: {
                            //   show: true,
                            //   position: 'left',
                            //   formatter: '{x|{d}%} \n {y|{b}}',
                            //   rich: {
                            //     x: {
                            //       fontSize: 11.25,
                            //       fontWeight: 800,
                            //       color: getColor('gray-700'),
                            //       padding: [0, 0, 5, 15]
                            //     },
                            //     y: {
                            //       fontSize: 12.8,
                            //       color: getColor('gray-700'),
                            //       fontWeight: 600
                            //     }
                            //   }
                            // },
                            left: "5%",
                            right: "5%",
                            top: 0,
                            bottom: 0,
                        }, ],

                    });

                    const responsiveOptions = {
                        xs: {
                            series: [{
                                radius: "45%",
                            }, ],
                        },
                        sm: {
                            series: [{
                                radius: "60%",
                            }, ],
                        },
                    };

                    echartSetOption(
                        chart,
                        userOptions,
                        getDefaultOptions,
                        responsiveOptions
                    );
                }
            };

            const {
                docReady
            } = window.phoenix.utils;

            docReady(pieEdgeAlignChartInit);
        });
    </script>


    @endpush
