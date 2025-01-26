<template>
    <nav class="menu">
      <ul>
        <li
          v-for="item in menuItems"
          :key="item"
          :class="['menu-item', { active: item === activeItem }]"
          @click="selectMenuItem(item)"
        >
          {{ item }}
        </li>
      </ul>
    </nav>
</template>

<script>
import { mapState } from 'pinia';
import { useProductStore } from '@/stores/product_store';

export default {
  name: 'Menu',
  props: {
    menuItems: {
      type: Array,
      required: true,
      default: () => [],
    },
  },
  data() {
    return {
      activeItem: null, // Tracks the currently selected menu item
    };
  },
  computed: {
    ...mapState(useProductStore, {
      popularProducts: 'groups',
    }),
  },
  methods: {
    selectMenuItem(item) {
      this.activeItem = item; 
      this.$emit('menuItemSelected', item);
    },
  },
};
</script>

<style>

/* .menu-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 1.5rem; 
} */



.menu {
  display: flex;
}

.menu ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 1.5rem; /* Space between menu items */
}

.menu-item {
  font-size: 1rem;
  color: #333;
  font-weight: 400;
  cursor: pointer;
  transition: color 0.3s ease;
}

.menu-item:hover {
  color: #000;
}

.menu-item.active {
  font-weight: 700; /* Bold font for the active item */
  color: #000;
}
</style>
