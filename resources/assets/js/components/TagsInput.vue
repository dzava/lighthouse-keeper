<style>
</style>

<template>
    <div class="flex flex-wrap items-baseline">
        <span class="flex items-center ba br2 b--dark-blue pa2 pr0 mr2 mb2 break-all" v-for="tag in tags">
            <input type="hidden" :name="name" :value="tag">
            <span>{{ tag }}</span>
            <button type="button" class="input-reset bn bg-transparent dark-blue ml1 pointer" @click="removeTag(tag)">&times;</button>
        </span>

        <input class="input w-auto flex-grow-1 bn" :type="type" :placeholder="placeholder" v-model="newTag"
               @keydown.enter.prevent="addTag()" ref="input">
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
        },
        data() {
            return {
                newTag: '',
                tags: this.dataTags,
            }
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
