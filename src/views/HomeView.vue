<template>
  <div class="container">
    <menu-item/>
    <ShowCase />
    <div class="block0">
      <h2 class="menu-title">Featured Categories</h2>
      <Menu :menuItems="store.groups" @menuItemSelected="handleCategoryGroupClick" />
    </div>
    <div class="block1">
      <Category
        v-for="(category, index) in filteredCategories"
        :key="index"
        :id="category.id"
        :image="category.image"
        :name="category.name"
        :productCount="category.productCount"
        :color="category.color"
      />
    </div>
    <div class="block2">
      <Promotion v-for="(promotion, index1) in promotions" :key="index1" :image="promotion.image"
        :title="promotion.title" :color="promotion.color" />
    </div>
    <div class="block-1">
      <div class="block0">
        <h2 class="menu-title" @click="resetProductSelection">Popular Products</h2>
        <Menu :menuItems="store.groups" @menuItemSelected="handleProductGroupClick" />
      </div>
      <div class="products-grid">
        <product v-for="product in filteredProducts" :key="product.id" :product="product" />
      </div>
    </div>

  </div>
</template>

<script>
import Category from '../components/category.vue';
import Promotion from '../components/promotion.vue';
import product from '@/components/product.vue';
import Menu from '../components/Menu.vue';
import ShowCase from '@/components/ShowCase.vue';
import { useProductStore } from '../stores/product_store';
import { mapState } from 'pinia';
import { computed, ref } from 'vue';
import MenuItem from '@/views/MenuItem.vue';


export default {
  name: 'App',
  components: {
    Category,
    Promotion,
    Menu,
    product,
    ShowCase,
    MenuItem
  },

  setup() {
    const store = useProductStore();
    const selectedCategoryGroup = ref(null);
    const selectedProductGroup = ref(null);

    const resetProductSelection = () => {
      selectedProductGroup.value = null;
    };
    // Handle group click and set selected group
    const handleCategoryGroupClick = (group) => {
      selectedCategoryGroup.value = selectedCategoryGroup.value === group ? null : group;
    };

    const handleProductGroupClick = (group) => {
      selectedProductGroup.value = selectedProductGroup.value === group ? null : group;
    };
    // Filter categories by selected group
    const filteredCategories = computed(() =>
      selectedCategoryGroup.value
        ? store.categories.filter((category) => category.group === selectedCategoryGroup.value)
        : store.categories
    );

    // Filter products by selected group
    const filteredProducts = computed(() =>
      selectedProductGroup.value
        ? store.products.filter((product) => product.group === selectedProductGroup.value)
        : store.products
    );

    return {
      store,
      selectedCategoryGroup,
      selectedProductGroup,
      handleCategoryGroupClick,
      handleProductGroupClick,
      filteredCategories,
      filteredProducts,
      resetProductSelection,
    };
  },
  async mounted() {
    await this.store.fetchCategories();
    await this.store.fetchPromotions();
    await this.store.fetchProducts();
    await this.store.fetchGroups();
  },
  computed: {
    ...mapState(useProductStore, {
      categories: 'categories',
      promotions: 'promotions',
      products: 'products',
      groups: 'groups',
    }),
  },
};
</script>

<style>
.container {
  width: 100vw;
  height: 110vh;
  padding: 10px;
}

.block1 {
  display: flex;
  justify-content: space-between;
  gap: 10px;
  width: 100%;
  height: 20%;
  padding: 10px;
}

.block2 {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  width: 100%;
  height: 59%;
  padding: 10px;
}

.block0 {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
}

.block-1 {
  position: relative;
  bottom: 250px;
}

.menu-title {
  font-size: 26px;
  font-weight: 600;
  color: #333;
  margin: 0;
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 20px;

}
</style>