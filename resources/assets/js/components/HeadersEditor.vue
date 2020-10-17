<template>
    <div>
        <div class="flex items-baseline" v-for="(header, index) in headers">
            <input type="text" class="input" placeholder="Header name" required
                   :name="nameFieldName(index)" v-model="header.name">
            <input type="text" class="input mx-2" placeholder="Header value" :name="valueFieldName(index)"
                   v-model="header.value">
            <a href="#" class="text-gray-800" @click.prevent="removeHeader(index)">Remove</a>
        </div>

        <a href="#" class="inline-block text-gray-800" :class="{ mt3: headers.length }"
           @click.prevent="addHeader">
            Add custom header
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            dataHeaders: {
                type: Array,
                default: [],
            },
        },
        data: function () {
            return {
                headers: this.dataHeaders || [],
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
