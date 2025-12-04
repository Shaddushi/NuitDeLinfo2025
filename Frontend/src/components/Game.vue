<template>
    <div class="h-100 w-100 bg-light custom-background">
        <div class="d-flex flex-column h-100 p-4">
            <div class="flex-grow-1">
                ici
            </div>

            <div class="">
                <div class="bg-white border border-3 border-dark custom-border-2 shadow conversation fs-5 position-relative">
                    <div class="position-absolute px-4">
                        <div class="bg-primary rounded-3 px-3 text-white translateY">
                            Eric Ramat
                        </div>
                    </div>
                    <div class="p-4">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium assumenda blanditiis cum dignissimos dolorem facere molestias quasi repudiandae. Aspernatur at dolores eos eum impedit maxime officiis perferendis, quidem quis tempora?
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis dolorem ducimus error et eveniet facilis ipsa iste laborum non officia possimus rerum, suscipit voluptatum? Earum fugit necessitatibus temporibus velit voluptatum.
                    </div>

                </div>
            </div>


        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {}
    }
}
</script>

<style>
.custom-background{
    background-image: url('test.jpg');
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
}

.translateY{
    transform: translateY(-50%);
}
</style>