const colors = [
    {
        backgroundColor: 'transparent',
        borderColor: 'rgba(141,211,199,1)',
    },
    {
        backgroundColor: 'transparent',
        borderColor: 'rgba(188,128,189,1)',
    },
    {
        backgroundColor: 'transparent',
        borderColor: 'rgba(190,186,218,1)',
    },
    {
        backgroundColor: 'transparent',
        borderColor: 'rgba(251,128,114,1)',
    },
    {
        backgroundColor: 'transparent',
        borderColor: 'rgba(128,177,211,1)',
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
