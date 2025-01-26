<template>
    <div class="pageCategory">
        <!-- Menu Bar -->
        <menu-item />

        <!-- Page Header with Category Information -->
        <div class="pageHeader">
            <div class="showcase">
                <div class="titleCase">
                    <h1 class="pageTitle">
                        {{ categoryName }}
                    </h1>
                </div>
                <div class="description">
                    <p class="breadcrumb">Home > Categories > {{ categoryName }}</p>
                </div>
            </div>
        </div>

        <!-- Products Filtered by Category -->
        <div class="productCom" v-if="filteredProducts.length > 0">
            <product :products="filteredProducts" />
        </div>
        <div class="productCom" v-else>
            <p>No products available in this category.</p>
        </div>
    </div>
</template>

<script>
import { useProductStore } from "@/stores/product_store";
import MenuItem from "./MenuItem.vue";
import product from "@/components/product.vue";

export default {
    name: "CategoryPage",
    components: {
        MenuItem,
        product,
    },
    data() {
        return {
            categoryName: "Loading...",
            filteredProducts: [],
        };
    },
    computed: {
        categoryId() {
            // Access and parse the route parameter safely
            const id = this.$route.params.id;
            return id ? parseInt(id, 10) : null;
        },
    },
    methods: {
        async fetchData() {
            try {
                const productStore = useProductStore();

                // Fetch products and categories if not already available
                if (!productStore.products.length) {
                    await productStore.fetchProducts();
                }
                if (!productStore.categories.length) {
                    await productStore.fetchCategories();
                }

                // Find the current category by ID
                const category = productStore.categories.find(
                    (cat) => cat.id === this.categoryId
                );

                if (category) {
                    this.categoryName = category.name;

                    // Filter products by the category ID
                    this.filteredProducts = productStore.products.filter(
                        (product) => product.categoryId === this.categoryId
                    );
                } else {
                    this.categoryName = "Category Not Found";
                }
            } catch (error) {
                console.error("Error fetching data:", error);
                this.categoryName = "Error loading category";
                this.filteredProducts = [];
            }
        },
    },
    watch: {
        // Re-fetch data if the route parameter changes
        categoryId: "fetchData",
    },
    mounted() {
        this.fetchData();
    },
};
</script>


<style scoped>
.pageCategory {
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: column;
    margin-top: 20px;
}

.pageHeader {
    background-color: #e9f7ef;
    border-radius: 8px;
    padding: 80px;
    margin: 20px 0;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    
}

.showcase {
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: start;
}

.pageTitle {
    font-weight: bold;
    font-size: 2rem;
    color: #333;
    margin: 0;
}

.breadcrumb {
    margin-top: 10px;
    font-size: 1rem;
    color: #777;
}

.productCom {
    margin-top: 20px;
}
</style>
