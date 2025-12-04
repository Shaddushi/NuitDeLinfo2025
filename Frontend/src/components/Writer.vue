<template>
    <p>{{ displayedText }}</p>
</template>

<script>
export default {
    props: {
        text: { type: String, required: true },
        speed: { type: Number, default: 20 }
    },
    data() {
        return {
            displayedText: '',
            interval: null
        }
    },

    methods: {
        forceFinish() {
            console.log('forceFinished called')
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
