import { combineReducers } from 'redux';
import productsReducer from './reducers/addProducts';
import authReducer from './reducers/auth';

const rootReducers = combineReducers({
  productsReducer,
  authReducer
});

export default rootReducers;