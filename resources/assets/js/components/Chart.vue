<style>
</style>

<template>
    <canvas class="h5"></canvas>
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
                    scales: {
                        yAxes: [{
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 100,
                            },
                        }],
                    },
                },
                plugins: [AutoColors],
                data: {
                    labels: this.labels,
                    datasets: this.datasets,
                },
            })
        },
    }
</script>
