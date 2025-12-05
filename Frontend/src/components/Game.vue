<template>
    <div class="h-100 w-100 bg-light custom-background" :style="`background-image: url('`+currentBackground+`')`">
<!--        <div class="position-absolute p-3">-->
<!--            <div class="bg-danger ">-->
<!--                ici-->
<!--            </div>-->
<!--        </div>-->
        <div class="d-flex flex-column h-100 p-4">
            <div class="flex-grow-1">

            </div>

            <div class="">
                <div class="row">
                    <div class="col d-flex justify-content-center" v-for="sprite in sprites">

                        <div class="position-relative">
                            <img :src="sprite.name" class="sprite"
                            :class="{
                                'dark': !sprite.is_speaking
                            }"/>
                        </div>


                    </div>
                </div>
                <div class="text bg-white border border-3 border-dark custom-border-2 shadow conversation fs-5 position-relative"
                 @click="nextConversation(null)"
                :class="{
                    'cursor-pointer': currentTexts.length == 1
                }">
                    <div class="position-absolute px-4">
                        <div class="rounded-3 px-3 text-white translateY" :style="'background-color: '+currentColor">
                            {{currentName}}
                        </div>
                    </div>

                    <div class="p-4">
                        <div
                        class="py-2"
                        v-for="(text, i) in currentTexts"
                        :key="currentId + '-' + i">
                            <Writer
                            :text="text.text"
                            :is-choice="current?.has_choice"
                            :class="{'choice-line': current?.has_choice}"
                            :ref="'writer-'+i"
                            @finished="finished = true"
                            @click.stop="nextConversation(text)" />
                        </div>

                    </div>

                    <div class="position-absolute px-4 py-4 bottom-0 custom-right" v-if="!current?.has_choice">
                        <img src="/images/skip.png" class="skip-image" />
                    </div>

                </div>
            </div>


        </div>

        <audio ref="audio" :src="currentAudio" autoplay loop></audio>

    </div>
</template>

<script>
import Writer from "@/components/Writer.vue";

export default {
    components: {Writer},
    data() {
        return {
            items: [],
            waifuId: null,
            current: null,
            currentId: 1,
            finished: false,
            text: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium assumenda blanditiis cum dignissimos dolorem facere molestias quasi repudiandae. Aspernatur at dolores eos eum impedit maxime officiis perferendis, quidem quis tempora?                          ipsum dolor sit amet, consectetur adipisicing elit. Debitis dolorem ducimus error et eveniet facilis ipsa iste laborum non officia possimus rerum, suscipit voluptatum? Earum fugit necessitatibus temporibus velit voluptatum."
        }
    },

    computed:{
        sprites(){
            return this.current ? this.current.sprite : []
        },

        currentBackground(){
            return this.current ? this.current.bg: ""
        },

        currentColor(){
            return this.current ? this.current.color : ""
        },

        currentName(){
            return this.current ? this.current.name : ""
        },

        currentTexts(){
            return this.current ? this.current.choices : []
        },

        currentAudio(){
            return this.current ? this.current.sound : ""
        }
    },

    methods: {
        async loadData(){
            const data = await import('/public/game.json')
            this.items = data.default
            this.getCurrentData()
        },

        getCurrentData(){
            this.current = this.items.find(item => item.id === this.currentId)
        },

        nextConversation(text){
            let id_suivant = text?.id_suivant
            if(!id_suivant){
                if(this.current.has_choice){
                    return;
                }
                if(!this.finished){
                    this.$refs['writer-0'][0].forceFinish();
                    return;
                }
                id_suivant = this.current.choices[0].id_suivant
            }
            if(text?.id_waifu){
                this.waifuId = text.id_waifu
            }

            this.currentId = id_suivant
            this.getCurrentData()

            if(this.current?.waifu_choice){
                const next = this.current.waifu_choice.find(item => item.id === this.waifuId)
                if(next) {
                    this.currentId = next.id_suivant
                    this.getCurrentData()
                }
            }
            this.finished = false
        }
    },

    mounted(){
        this.loadData();
        if (localStorage.getItem("token") === null) {
            window.location.replace("/login");
        }
    }
}
</script>

<style lang="scss">
.custom-background{
    background-repeat: no-repeat;
    background-size: cover;
}

.custom-border-1{
    border-radius: 30px;
    padding: 3px;
}

.custom-border-2{
    border-radius: 27px;
}

.conversation{
    min-height: 200px;
    transition: transform 0.1s ease;

    cursor: pointer;
    &:hover{
        transform: scale(101%);
    }
}

.translateY{
    transform: translateY(-50%);
}

.custom-right{
    right: 1px;
}

.sprite{
    height: 50vh;
    transition: filter 0.3s ease;

    &.dark{
        filter: brightness(30%);
    }
}

.black-overlay {
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    pointer-events: none;
}

.choice-line{
    &:hover{
        text-decoration: underline;
    }
}

.text{
    user-select: none;
}

.skip-image{
    user-select: none;
}
</style>