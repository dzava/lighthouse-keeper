<style>
</style>

<template>
    <canvas style="height: 16rem;"></canvas>
</template>

<script>
    import Chart from 'chart.js'
    import AutoColors from '../AutoColorChart'

    export default {
        props: {
            labels: {
                type: Array,
                required: true,
            },
            datasets: {
                type: Array,
                required: true,
            },
        },
        data: function () {
            return {
                chart: null,
            }
        },
        mounted() {
            this.chart = new Chart(this.$el.getContext('2d'), {
                type: 'line',
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        position: 'right',
                    },
                    spanGaps: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 100,
                            },
                        }],
                    },
                },
                plugins: [
                    AutoColors,
                    { // Hide the legend on small screens
                        resize(chart, {width}) {
                            if (width >= 670) {
                                chart.options.legend.display = true
                                return
                            }
                            chart.options.legend.display = false
                        },
                    },
                ],
                data: {
                    labels: this.labels,
                    datasets: this.datasets,
                },
            })
        },
    }
</script>
