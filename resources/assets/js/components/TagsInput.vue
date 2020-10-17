<style>
</style>

<template>
    <div class="flex flex-wrap items-baseline">
        <span class="flex items-center border rounded mb-2 mr-2 p-2 border-blue-400 break-all" v-for="tag in tags">
            <input type="hidden" :name="name" :value="tag">
            <span>{{ tag }}</span>
            <button type="button" class="text-blue-800 ml-2" @click="removeTag(tag)">&times;</button>
        </span>

        <input type="hidden" :name="name" :value="newTag" v-if="newTag.length">
        <input class="input w-auto flex-grow" :type="type" :placeholder="placeholder" :required="isRequired"
               v-model="newTag" @keydown.enter.prevent="addTag()" ref="input">
    </div>
</template>

<script>
    export default {
        props: {
            dataTags: {
                type: Array,
                default: [],
            },
            placeholder: {
                type: String,
                default: 'Add tag...',
            },
            type: {
                type: String,
                default: 'text',
            },
            name: {
                type: String,
                required: true,
            },
            required: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                newTag: '',
                tags: this.dataTags,
            }
        },
        computed: {
            isRequired() {
                return this.required && this.tags.length === 0
            },
        },
        methods: {
            addTag() {

                if (!this.$refs.input.reportValidity()) {
                    return
                }

                const tag = this.newTag.trim()

                if (tag.length === 0 || this.tags.includes(tag)) {
                    return
                }

                this.tags.push(tag)
                this.newTag = ''
            },
            removeTag(tag) {
                this.tags = this.tags.filter(t => t !== tag)
            },
        },
    }
</script>
