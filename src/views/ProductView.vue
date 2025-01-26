<template>
  <div class="product-detail" v-if="product">
    <div>
      <menu-item />
    </div>

    <!-- Main Layout: Image and Details -->
    <div class="product-content">
      <!-- Product Image Gallery -->
      <div class="image-container">
        <div class="image-gallery">
          <img :src="'http://localhost:3000/' + currentImage" />
        </div>
        <!-- Thumbnails and Navigation -->
        <div class="thumbnail-container">

          <!-- Thumbnails -->
          <div class="thumbnails">
            <img v-for="(image, index) in thumbnails" :key="index" :src="'http://localhost:3000/' + image"
              :alt="'Thumbnail ${index + 1}'" class="thumbnail" :class="{ active: image === currentImage }"
              @click="changeImage(image)" />
          </div>

        
        </div>

      </div>


      <!-- Product Details -->
      <div class="details">
        <div class="availability">
          <span v-if="product.instock > 0" class="in-stock">In Stock</span>
          <span v-else class="out-of-stock">Out of Stock</span>
        </div>
        <h1 class="product-title">{{ product.name }}</h1>
        <div class="star">
          ★★★★☆ <span class="rating">({{ product.rating || 0 }})</span>
        </div>

        <!-- Pricing -->
        <div class="pricing">
          <p v-if="product.promotionAsPercentage > 0">
            <span class="discounted-price">
              ${{ (product.price * (1 - product.promotionAsPercentage / 100)).toFixed(2) }}
            </span>
            <span class="original-price">
              ${{ product.price.toFixed(2) }}
            </span>
            <small>({{ product.promotionAsPercentage }}% off)</small>
          </p>
          <p v-else class="regular-price">${{ product.price.toFixed(2) }}</p>
        </div>
        <div class="decontent">
          <p>{{ details }}</p>
        </div>


        <!-- Quantity and Add to Cart -->
        <div class="quantity-add-btn-container button">
          <div v-if="product.instock > 0">
            <input type="number" v-model.number="product.quantity" :min="1" :max="product.instock"
              class="quantity-input" />
            <button @click="addToCart" class="add-btn"
              :disabled="product.quantity < 1 || product.quantity > product.instock">
              Add to Cart
            </button>
            <button class="icon-btn">
              <img src="/image/icons/heart.png" alt="">
            </button>
            <button class="icon-btn">
              <img src="/image/icons/shuffle.png" alt="">
            </button>
          </div>
          <p v-else class="out-of-stock-msg">This product is currently unavailable.</p>
        </div>

        <!-- Product Info -->
        <p class="vendor">Vendor: {{ product.vendor || 'N/A' }}</p>
        <p class="sku">SKU: {{ product.sku || 'N/A' }}</p>
      </div>
    </div>

    <!-- Tabs Section -->
    <div class="tabs">
      <button class="tab-btn" :class="{ active: activeTab === 'description' }" @click="activeTab = 'description'">
        Description
      </button>
      <button class="tab-btn" :class="{ active: activeTab === 'additionalInfo' }" @click="activeTab = 'additionalInfo'">
        Additional Info
      </button>
      <button class="tab-btn" :class="{ active: activeTab === 'reviews' }" @click="activeTab = 'reviews'">
        Reviews ({{ product.reviews?.length || 0 }})
      </button>

      <div v-if="activeTab === 'description'" class="tab-content">
        <p>{{ description }}</p>
      </div>
      <div v-if="activeTab === 'additionalInfo'" class="tab-content">
        <p>{{ additionalInfo }}</p>
      </div>
      <div v-if="activeTab === 'reviews'" class="tab-content">
        <ul>
          <li v-for="(reviews, index) in reviews || []" :key="index">
            <strong>{{ reviews }}</strong>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div v-else>
    <p>Loading product details...</p>
  </div>
</template>

<script>
import { useProductStore } from "@/stores/product_store";
import MenuItem from './MenuItem.vue';

export default {
  components: { MenuItem },
  name: "ProductView",
  props: ["productID"],
  data() {
    return {
      product: null,
      activeTab: "description", // Default tab
      description:
        "Uninhibited carnally hired played in whimpered dear gorilla koala depending and much yikes off far quetzal goodness and from for grimaced goodness unaccountably and meadowlark near unblushingly crucial scallop tightly neurotic hungrily some and dear furiously this apart.",
      additionalInfo:
        "Spluttered narrowly yikes left moth in yikes bowed this that grizzly much hello on spoon-fed that alas rethought much decently richly and wow against the frequent fluidly at formidable acceptably flapped besides and much circa far over the bucolically hey precarious goldfinch mastodon goodness gnashed a jellyfish and one however because.",
      reviews: [
        "Review 1: Excellent product! Highly recommended.",
        "Review 2: Worth the price, great quality!",
        "Review 3: Delivered on time, satisfied with the purchase.",
      ],
      thumbnails: [],
      currentImage: "",
      details: "Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam rem officia, corrupti reiciendis minima nisi modi, quasi, odio minus dolore impedit fuga eum eligendi? Officia doloremque facere quia. Voluptatum, accusantium!"
    };
  },
  async mounted() {
    const store = useProductStore();
    const productId = parseInt(this.$route.params.id); // Get product ID from route
    this.product = store.products.find((p) => p.id === productId);

    if (!this.product) {
      try {
        await store.fetchProducts();
        this.product = store.products.find((p) => p.id === productId);
      } catch (error) {
        console.error("Failed to fetch products:", error);
      }
    }
    if (this.product) {
      const images = JSON.parse(this.product.image);
      this.thumbnails = images;
      this.currentImage = images[0];
    }
  },


  methods: {
    addToCart() {
      if (this.product.quantity > 0 && this.product.quantity <= this.product.instock) {
        alert(`Added ${this.product.quantity} to cart!`);
      } else {
        alert("Invalid quantity");
      }
    },
    changeImage(image) {
      this.currentImage = image; // Update the current image when a thumbnail is clicked
    },
    navigateThumbnails(direction) {
      const currentIndex = this.thumbnails.indexOf(this.currentImage);
      if (direction === "left" && currentIndex > 0) {
        this.currentImage = this.thumbnails[currentIndex - 1];
      } else if (direction === "right" && currentIndex < this.thumbnails.length - 1) {
        this.currentImage = this.thumbnails[currentIndex + 1];
      }
    },
  },
};
</script>

<style scoped>
/* Layout */
.product-detail {
  width: 100%;
  height: 100vh;
  padding: 20px;
  margin-bottom: 200px;
}

.product-content {
  display: flex;
  gap: 40px;
  margin-top: 100px;
}

/* Image Gallery */
.image-container {
  width: 60%;
  display: flex;
  justify-content: center;
  flex-direction: column;
  
}

.image-gallery {
  display: flex;
  justify-content: center;
  margin-bottom: 50px;
  border: 2px solid rgb(171, 169, 169);
  border-radius: 8px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  transition: box-shadow 0.3s ease-in-out;
}

.image-gallery img {
  width: 70%;
  height: auto;
  /* Ensures aspect ratio is maintained */
  object-fit:fill;

}

.thumbnail-container {
  display: flex;
  align-items: center;
  gap: 10px;
}

.thumbnails {
  display: flex;
  gap: 10px;
  overflow-x: auto;
  justify-content: center;
  align-items: center;
}

.thumbnail {
  width: 20%;
  height: 20%;
  cursor: pointer;
  border: 2px solid rgb(171, 169, 169);
  border-radius: 8px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  transition: box-shadow 0.3s ease-in-out;
}

.thumbnail.active {
  border: 3px solid rgb(0, 255, 4);

}

.button {
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1.5rem;
}

/* Details */
.details {
  flex: 2;
  display: flex;
  flex-direction: column;
  margin-left: 5%;


}

.product-title {
  font-size: 1.8rem;
  font-weight: bold;
}

.pricing {
  display: flex;
  gap: 10px;
  align-items: baseline;
}

.discounted-price {
  color: #0db862;
  font-weight: bold;
  font-size: 48px;
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

.original-price {
  text-decoration: line-through;
  color: gray;
}

/* detail content */
.decontent {
  color: #9b9b9b;
  font-weight: lighter;
  font-size: smaller;
}

.add-btn {
  padding: 10px;
  margin: 20px;
  font-size: 1rem;
  border: 1px solid #ffffff;
  border-radius: 10px;
  cursor: pointer;
  background: rgb(75, 192, 131);


}


.quantity-input {
  width: 80px;
  padding: 10px;
  text-align: center;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-right: 10px;
  cursor: pointer;

}

.quantity-input:focus {
  border-color: #38a169;
  /* Green border on focus */
  outline: none;
  /* Remove the default blue outline */
}

/* Tabs */
.tabs {
  margin-top: 100px;
  border-top: 1px solid #ccc;
  padding-top: 20px;

}

.tab-btn {
  padding: 10px 20px;
  background: none;
  border: none;
  cursor: pointer;
  font-weight: bold;
}

.tab-btn.active {
  border-bottom: 2px solid #007bff;
}

.tab-content {
  margin-top: 20px;

}

.icon-btn {
  margin-left: 10px;
  margin-top: 20px;
  border: 1px solid rgb(194, 194, 194);
  border-radius: 10px;
  background: transparent;
  position: relative;
  top: 8px;
}

.icon-btn img {
  width: 30px;
}
</style>
