export default {
    install(Vue, options = {}) {
        if (this.installed) {
            return
        }

        this.installed = true

        Vue.prototype.$flash = {
            info(message) {
                this.flash({type: 'info', message})
            },

            success(message) {
                this.flash({type: 'success', message})
            },

            error(message) {
                this.flash({type: 'error', message})
            },

            flash(data) {
                window.eventBus.$emit('flash', data)
            },
        }
    },
}
