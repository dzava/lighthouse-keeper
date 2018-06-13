<style>
</style>

<template>
    <div class="fixed bottom-1 right-0 right-2-ns pa3 z-5" :class="classes" v-show="show">
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
                    info: 'bg-dark-blue white',
                    success: 'bg-green white',
                    error: 'bg-red white',
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
                this.hide()
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
