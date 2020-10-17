<style>
</style>

<template>
    <div class="fixed rounded shadow-xl top-0 right-0 mt-12 p-3 z-5" :class="classes" v-show="show">
        {{ body }}
    </div>
</template>

<script>
    export default {
        props: {
            message: {
                type: String,
                default: '',
            },
            level: {
                type: String,
                default: 'info',
            },
        },
        data: function () {
            return {
                body: this.message,
                type: this.level,
                show: false,
                timeoutId: null,
                classesForType: {
                    info: 'bg-blue-600 text-white',
                    success: 'bg-green-600 text-white',
                    error: 'bg-red-600 text-white',
                },
            }
        },
        computed: {
            classes() {
                return this.classesForType[this.type]
            },
        },
        methods: {
            flash(data) {
                if (data) {
                    this.body = data.message
                    this.type = data.type
                }

                this.show = true
                // this.hide()
            },
            hide() {
                clearTimeout(this.timeoutId)
                this.timeoutId = setTimeout(() => {
                    this.show = false
                }, 3000)
            },
        },
        created() {
            if (this.message) {
                this.flash()
            }

            window.eventBus.$on('flash', this.flash)
        },
    }
</script>
