<template>
    <div class="b0" :style="{ backgroundColor: color }" @click="goToCategoryDetail">
        <div class="b0-image">
            <img :src="'http://localhost:3000/' + image" alt="name">
        </div>
        <div class="b0-text">
            <h4>{{ name }}</h4>
            <p>{{ productCount }} items</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "Category",
    props: {
        id: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        image: {
            type: String,
            required: true,
        },
        productCount: {
            type: String,
            required: true,
        },
        color: {
            type: String,
            default: "#fff",
        },
    },
    methods: {
        goToCategoryDetail() {
            if (this.id) {
                this.$router.push({ name: "categoryview", params: { id: this.id } });
            } else {
                console.error("Category ID is missing");
            }
        },
    },
};
</script>

<style scoped>
.b0 {
    color: black;
    border: 1px solid greenyellow;
    border-radius: 10px;
    width: 20%;
    height: 80%;
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.b0:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.b0-image {
    width: 100%;
    height: 50%;
    border-radius: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.b0-image img {
    width: 80%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
}

.b0-text {
    width: 100%;
    height: 40%;
    border-radius: 10px;
    padding: 3px;
    text-align: center;
}

.b0-text h4 {
    margin: 5px 0;
    font-size: 1rem;
    font-weight: bold;
}

.b0-text p {
    opacity: 0.8;
    font-size: 0.875rem;
    margin: 0;
}
</style>
