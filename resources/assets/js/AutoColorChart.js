const colors = [
    {
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255,99,132,1)',
    },
    {
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
    },
    {
        backgroundColor: 'rgba(255, 206, 86, 0.2)',
        borderColor: 'rgba(255, 206, 86, 1)',
    },
    {
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
    },
    {
        backgroundColor: 'rgba(153, 102, 255, 0.2)',
        borderColor: 'rgba(153, 102, 255, 1)',
    },
    {
        backgroundColor: 'rgba(255, 159, 64, 0.2)',
        borderColor: 'rgba(255, 159, 64, 1)',
    },
]

export default {
    beforeInit(chart, options) {
        const datasets = chart.data.datasets

        for (let i = 0; i < datasets.length; i++) {
            datasets[i] = Object.assign({}, datasets[i], colors[i % colors.length])
        }
    },
}
