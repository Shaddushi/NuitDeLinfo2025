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
            displayedText: ''
        }
    },
    mounted() {
        let index = 0
        const interval = setInterval(() => {
            this.displayedText += this.text[index]
            index++
            if (index >= this.text.length) clearInterval(interval)
        }, this.speed)
    }
}
</script>
