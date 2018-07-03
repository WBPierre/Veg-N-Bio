import { CONNECTED, DISCONNECTED } from '../const';

const initialState = {
  user: {},
  isFetching: true
};

export default authReducer = (state = initialState, action) => {
  switch (action.type) {
    case CONNECTED:
      return {
        ...state,
        user: action.user,
      };
    case DISCONNECTED: {
      console.log('je renttre dans redux');
      return {
        ...state,
        user: {}
      }
    }
    default:
      return state;
  }
};

