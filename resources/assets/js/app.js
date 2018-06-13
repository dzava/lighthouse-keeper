import Vue from 'vue'
import HeadersEditor from './components/HeadersEditor'
import Chart from './components/Chart'
import TagsInput from './components/TagsInput'
import Flash from './components/Flash'

Vue.use(require('./services/flash').default)
window.eventBus = new Vue();

new Vue({
    el: '#app',
    components: {HeadersEditor, Chart, TagsInput, Flash},
})
