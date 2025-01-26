<template>
  <div class="product-list">
    <div class="product-item" @click="goToProductDetail">
      <!-- Product Image -->
      <img
      :src="'http://localhost:3000/' + JSON.parse(product.image)[0]"
    />
      
      <!-- Product Details -->
      <div class="product-details">
        <h3>{{ product.name }}</h3>
        <div class="star">
          ★★★★☆
          <div class="rating">({{ product.rating }})</div>
        </div>

        <p>Size: {{ product.size }}</p>
        <p>Category: {{ product.group }}</p>
        <p>In Stock: {{ product.instock }}</p>
        <p>Sold: {{ product.countSold }}</p>

        <!-- Price with Promotion -->
        <p v-if="product.promotionAsPercentage > 0">
          <span class="discounted-price">
            ${{ (product.price * (1 - product.promotionAsPercentage / 100)).toFixed(2) }}
          </span>
          <span class="original-price">
            ${{ product.price.toFixed(2) }}
          </span>
          <small> ({{ product.promotionAsPercentage }}% off)</small>
        </p>
        <p v-else>${{ product.price.toFixed(2) }}</p>
        <!-- Quantity Selector and Add to Cart Button -->
        <div class="quantity-add-btn-container">
          <button v-if="!product.addedToCart" @click="toggleAddToCart(product)" class="add-btn">
            Add
          </button>

          <div v-if="product.addedToCart" class="quantity-selector">
            <input type="number" v-model.number="product.quantity" :min="1" :max="product.max" class="quantity-input" />
            <!-- <button @click="addToCart(product)" class="add-btn">Add +</button> -->
          </div>
        </div>

      </div>
    </div>
  </div>

</template>

<script>
import { mapState } from "pinia";
import { useProductStore } from "@/stores/product_store";

export default {
  name: "ProductList",
  props: [
    "product"
  ],
  computed: {
    ...mapState(useProductStore, {
      products: "products",
    }),
  },
  methods: {
    handleImageError(event) {
      event.target.src = "default-image.jpg"; // Replace with a placeholder image URL
    },

    toggleAddToCart(product) {
      product.addedToCart = true;
    },
    goToProductDetail() {
      if (this.product.id) {
        this.$router.push({ name: 'productview', params: { id: this.product.id } });
      } else {
        console.error('Product ID is missing');
      }
    },
    getFirstImage(images) {
      if (images) {
        const imageArray = images.split(',').map(images => images.trim());
        return 'http://localhost:3000/' + imageArray[0];
      }
      return "default-image.jpg"; // Fallback if no images
    },
    // Other methods

  },
};
</script>

<style scoped>
/* General Product List Layout */
.product-list {
  padding: 10px;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
}

/* Individual Product Card */
.product-item {
  border: 1px solid #ddd;
  padding: 15px;
  border-radius: 8px;
  background: white;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s, box-shadow 0.2s;
}

.product-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* Product Image */
.product-image {
  width: 100%;
  height: 150px;
  object-fit: fill;
  border-radius: 8px;
  margin-bottom: 10px;
}

/* Product Details */
.product-details h3 {
  font-size: 1.2rem;
  color: #333;
  font-weight: bold;
  margin-bottom: 10px;
}

.product-details p {
  font-size: 0.9rem;
  color: #555;
  margin: 5px 0;
}

.rating {
  display: inline;
  font-size: 16px;
  color: #555;
  margin: 5px 0;
}

.star {
  font-size: 20px;
  color: rgb(255, 221, 0);
}

/* Price Styling */
.original-price {
  text-decoration: line-through;
  color: #999;
  font-size: 0.9rem;
  margin-left: 10px;
}

.discounted-price {
  color: #118116;
  font-weight: bold;
  font-size: 1rem;
}

/* Add to Cart Button */
.quantity-add-btn-container {
  margin-top: 10px;
  display: flex;
  justify-content: end;
}

.add-btn {
  display: block;
  width: 50%;
  padding: 8px;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 0.9rem;
  transition: background 0.3s;
}

.add-btn:hover {
  background: #0056b3;
}

.add-btn:disabled {
  background: #ccc;
  cursor: not-allowed;
}

/* Quantity Selector */
.quantity-selector {
  display: flex;
  justify-content: end;
}

.quantity-btn {
  background: transparent;
  border: none;
  outline: none;
  font-size: 1.2rem;
  color: #118116;
  cursor: pointer;
  width: 30px;
  height: 30px;
}

.quantity-input {
  width: 50px;
  text-align: center;
  border: 1px solid #ccc;
  padding: 5px;
  margin: 0 10px;
  font-size: 1rem;
  border-radius: 5px;
}

.quantity-btn:disabled {
  color: #ccc;
  cursor: not-allowed;
}
</style>
