<template>
    <div>
        <div class="navbar">
            <!-- <img src="/image/Logo.png" alt="Logo" class="logo"> -->
            <SearchBox class="searchbar" />
            <div class="setting">
                <div class="content">
                    <img src="/image/icons/account.png" alt="Account Icon">
                    <p>Account</p>
                </div>
                <div class="content">
                    <img src="/image/icons/compare.png" alt="Compare Icon">
                    <p>Compare</p>
                </div>
                <div class="content">
                    <img src="/image/icons/wishlist.png" alt="Wishlist Icon">
                    <p>Wishlist</p>
                </div>
                <div class="content">
                    <img src="/image/icons/cart.png" alt="Cart Icon">
                    <p>Cart</p>
                </div>
            </div>
        </div>
        <hr>
        <nav class="contain">
            <div class="category-dropdown">
                <img src="/image/icons/fi-rs-apps.png" alt="Dropdown Icon">
                <select v-model="categorySelected" id="browse" @change="goToCategory">
                    <option disabled value="">Browse all the categories</option>
                    <option value="all">All Categories</option>
                    <option value="food">Food</option>
                    <option value="vegetables">Vegetables</option>
                    <option value="meat-seafood">Meat & Seafood</option>
                    <option value="bakery">Bakery</option>
                </select>
            </div>

            <ul class="nav-links">
                <li>
                    <router-link :to="{ name: 'categoryview', params: { id: 'hot' } }">
                        <img src="/image/icons/flame.png" alt="Hot Deals Icon">Hot Deals
                    </router-link>
                </li>
                <li><router-link to="/">Home</router-link></li>
                <li><router-link :to="{ name: 'categoryview', params: { id: 'food' } }">Food</router-link></li>
                <li><router-link :to="{ name: 'categoryview', params: { id: 'vegetables' } }">Vegetables</router-link></li>
                <li><router-link :to="{ name: 'categoryview', params: { id: 'drink' } }">Drink</router-link></li>
                <li><router-link :to="{ name: 'categoryview', params: { id: 'cookies' } }">Cookies</router-link></li>
                <li><router-link :to="{ name: 'categoryview', params: { id: 'meat-seafood' } }">Meat & Seafood</router-link></li>
                <li><router-link :to="{ name: 'categoryview', params: { id: 'bakery' } }">Bakery</router-link></li>
            </ul>
        </nav>
        <hr>
    </div>
</template>

<script>
import SearchBox from "../components/SearchBox.vue";

export default {
    name: "MenuItem",
    components: { SearchBox },
    data() {
        return {
            categorySelected: "",
        };
    },
    methods: {
        goToCategory() {
            if (this.categorySelected) {
                console.log(`Navigating to category: ${this.categorySelected}`);
                this.$router.push({ name: "categoryview", params: { id: this.categorySelected } });
            } else {
                console.error("No category selected");
            }
        },
    },
};
</script>

<style>
/* General Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: "Poppins", sans-serif;
    background-color: #f8f9fa;
}

p {
    font-size: 16px;
    color: #444;
}

hr {
    border-top: 1px solid #ddd;
    margin-top: 10px;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.logo {
    width: 150px;
}

.searchbar {
    flex-grow: 1;
    margin: 0 20px;
    max-width: 500px;
}

.searchbar input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
}

.setting {
    display: flex;
    gap: 20px;
}

.setting .content {
    display: flex;
    align-items: center;
    gap: 5px;
    cursor: pointer;
}

.setting img {
    width: 25px;
    height: 25px;
}

.contain {
    display: flex;
    justify-content: center;
    padding: 10px 0;
    background-color: #fff;
}

.nav-links {
    display: flex;
    gap: 15px;
}

.nav-links li {
    list-style: none;
}

.nav-links a {
    text-decoration: none;
    color: #555;
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.nav-links a:hover {
    background-color: #28a745;
    color: #fff;
}

.category-dropdown {
    display: flex;
    align-items: center;
    gap: 10px;
    background-color: #28a745;
    color: #fff;
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
}

.category-dropdown select {
    background: transparent;
    border: none;
    color: #fff;
    outline: none;
    cursor: pointer;
}
</style>
