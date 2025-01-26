<template>
    <div class="search">
        <select v-model="CategorySlected" id="Categories">
            <option disabled value="">All Categories</option>
            <option>Milk&Diaries</option>
            <option>Coffees&Teas</option>
            <option>Pet Foods</option>
            <option>Meats</option>
            <option>Vegetables</option>
            <option>Fruits</option>
        </select>
        <input type="search" placeholder="Search for items">
        
    </div>


</template>
<script>
export default {
    name: "SearchBox",
    data() {
        return {
            CategorySlected: '',
        }
    },

};

</script>
<style>
.search {
    display: flex;
    align-items: center;
    border: 1px solid #8ad7ae;
    border-radius: 10px;
    padding: 10px;
    background-color: #fff;
    width: 50%;
    margin: 0 auto;
}

select {
    border: none;
    font-size: 16px;
    color: #2d2d2d;
    /* Text color */
    background-color: transparent;
    padding: 5px;
    margin-right: 10px;
    outline: none;
}

select option {
    color: #2d2d2d;
}

input[type="search"] {
    border: none;
    flex: 1;
    /* Take remaining space */
    font-size: 16px;
    color: #888;
    /* Placeholder text color */
    background-color: transparent;
    padding: 5px;
    outline: none;
}

.search-icon {
    font-size: 18px;
    color: #888;
    /* Grey color for the icon */
    margin-left: 10px;
}

.search:hover {
    border-color: #87cba1;
    /* Slightly darker green on hover */
}

input[type="search"]::placeholder {
    color: #c3c3c3;
    /* Placeholder color */
}

.search-icon:hover {
    cursor: pointer;
    color: #5a9b7b;
    /* Highlight color on hover */
}
</style>
