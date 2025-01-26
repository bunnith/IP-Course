<template>
    <div class="c0" :style="{ backgroundColor: color }">
        <!-- tp02 -->
        <img :src="'http://localhost:3000/'+image" alt="">
        <h2>{{ title }}</h2>
        <!-- tp02 -->
        <Button :buttonText="'ShopNow'" :clickHandler="shopHere" />
    </div>
</template>
<script>
import Button from './button.vue';

export default {
    name: "Promotion",
    //tp02
    props: {
        title: String,
        color: String,
        image: String
    },
    components: {
        Button,
    },
    // tp02
    methods: {
        shopHere() {
            alert("No Need to wait: " + this.caption);
        }
    }

}
</script>
<style scoped>
.c0 {
    width: 30%;
    height: 50%;
    margin-top: 2px;
    border-radius: 20px;
    position: relative;

}

.c0 img {
    width: 80%;
    height: 75%;
    object-fit: contain;
    position: absolute;
    left: 30%;
    bottom: 0;
}

.c0 h2 {
    color: black;
    position: absolute;
    top: 10%;
    left: 10%;
    width: 50%;

}
</style>