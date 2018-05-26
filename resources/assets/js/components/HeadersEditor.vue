<template>
    <div>
        <div class="flex items-baseline" v-for="(header, index) in headers">
            <input type="text" class="input" placeholder="Header name" required
                   :name="nameFieldName(index)" v-model="header.name">
            <input type="text" class="input mh2" placeholder="Header value" :name="valueFieldName(index)"
                   v-model="header.value">
            <a href="#" class="black-70" @click.prevent="removeHeader(index)">Remove</a>
        </div>

        <a href="#" class="dib black-70" :class="{ mt3: headers.length }"
           @click.prevent="addHeader">
            Add custom header
        </a>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                headers: [],
            }
        },
        methods: {
            removeHeader(index) {
                this.headers.splice(index, 1)
            },
            addHeader() {
                this.headers.push({name: '', value: ''})
            },
            valueFieldName(index) {
                return `headers[${index}][value]`
            },
            nameFieldName(index) {
                return `headers[${index}][name]`
            },
        },
    }
</script>
