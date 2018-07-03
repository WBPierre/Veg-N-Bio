import { ADD_PRODUCTS, REMOVE_PRODUCTS } from '../const';

// actions

export const addProducts = (products) => {
  return {
    type: ADD_PRODUCTS,
    products: products,
    price: products.price
  }
};

export const removeProducts = () => {
  return {
    type: REMOVE_PRODUCTS,
  }
};

