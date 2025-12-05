<template>
    <span>{{ displayedText }}</span>
</template>

<script>
export default {
    props: {
        text: { type: String, required: true },
        speed: { type: Number, default: 20 },
        isChoice: { type: Boolean, default: false }
    },
    data() {
        return {
            displayedText: this.isChoice ? '> ' : '',
            interval: null
        }
    },

    methods: {
        forceFinish() {
            this.displayedText = this.text
            this.$emit('finished')
            clearInterval(this.interval)
        }
    },

    mounted() {
        let index = 0
        this.interval = setInterval(() => {
            this.displayedText += this.text[index]
            index++
            if (index >= this.text.length){
                clearInterval(this.interval)
                this.$emit('finished')
            }
        }, this.speed)
    }
}
</script>
