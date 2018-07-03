import { ADD_PRODUCTS, REMOVE_PRODUCTS } from '../const'

const initialState = {
  products: [],
  price: 0,
};

export default productsReducer = (state = initialState, action) => {
  switch (action.type) {
    case ADD_PRODUCTS:
      return {
        ...state,
        products: [...state.products, action.products],
        price: [...state.price, action.price]
      };
    case REMOVE_PRODUCTS:
      return {
        ...state,
        products: [],
        price: 0
      };
    default:
      return state;
  }
};

