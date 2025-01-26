import { defineStore } from 'pinia';
import axios from 'axios';

export const useProductStore = defineStore('product', {
  state: () => ({
    groups: [],
    promotions: [], 
    categories: [], 
    products: [],
  }),
  getters: {
    getCategoriesByGroup: (state) => {
      return (groupName) => state.categories.filter((category) => category.groupName === groupName);
    },
    getProductsByGroup: (state) => {
      return (groupName) => state.products.filter((product) => product.groupName === groupName);
    },
    getProductsByCategory: (state) => {
      return (categoryId) => state.products.filter((product) => product.categoryId === categoryId);
    },
    getPopularProducts: (state) => {
      return state.products.filter((product) => product.countSold > 10);
    },
  },
  actions: {
    async fetchCategories() {
      try {
        const response = await axios.get('http://localhost:3000/api/categories');
        console.log('Categories fetched:', response.data); // Debug log
        this.categories = response.data; // Fixed property name
      } catch (error) {
        console.error('Error fetching categories:', error.response?.data || error.message);
      }
    },
    async fetchPromotions() {
      try {
        const response = await axios.get('http://localhost:3000/api/promotions');
        console.log('Promotions fetched:', response.data); // Debug log
        this.promotions = response.data; // Fixed property name
      } catch (error) {
        console.error('Error fetching promotions:', error.response?.data || error.message);
      }
    },
    async fetchProducts() {
      try {
        const response = await axios.get('http://localhost:3000/api/products');
        console.log('Products fetched:', response.data); // Debug log
        this.products = response.data;
      } catch (error) {
        console.error('Error fetching products:', error.response?.data || error.message);
      }
    },
    async fetchGroups() {
      try {
        const response = await axios.get('http://localhost:3000/api/groups');
        this.groups = response.data;
      } catch (error) {
        console.error('Error fetching groups:', error.response?.data|| error.message);
      }
    }
  },
});
