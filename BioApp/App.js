// @flow


import React from 'react';
import { StackNavigator, TabNavigator } from 'react-navigation';
import { Provider } from 'react-redux';
import { createStore } from 'redux';
import rootReducers from './src/redux/rootReducers';

import config from './src/modules/config';

import HomeScreen from './src/screens/HomeScreen/index.js';
import RestaurantsScreen from './src/screens/RestaurantsScreen';
import OrderScreen from './src/screens/OrderScreen';
import CartScreen from './src/screens/CartScreen';
import AccountScreen from './src/screens/AccountScreen';
import RegisterScreen from './src/screens/RegisterScreen';
import LoginScreen from './src/screens/LoginScreen';
import ProductsScreen from './src/screens/ProductsScreen';
import PersonnalScreen from './src/screens/PersonnalScreen';
import SaveCardScreen from './src/screens/SaveCardScreen';



const HomeStack = StackNavigator({
  Home: { screen: HomeScreen },
});

const RestaurantsStack = StackNavigator({
  Restaurants: { screen: RestaurantsScreen },
});

const OrderStack = StackNavigator({
  Order: { screen: OrderScreen },
  Products: { screen : ProductsScreen }
});

const CartStack = StackNavigator({
  Cart: { screen: CartScreen },
});

const AccountStack = StackNavigator({
  Account: { screen: AccountScreen },
  Register: { screen: RegisterScreen},
  Login: { screen: LoginScreen},
  MySpace: { screen: PersonnalScreen},
  SaveCard: { screen: SaveCardScreen}
});


const RootStack = TabNavigator(
  {
    Home: { screen: HomeStack },
    Restaurants: { screen: RestaurantsStack },
    Order: { screen: OrderStack },
    Cart: { screen: CartStack },
    Account: { screen: AccountStack }
  },
  {
    navigationOptions: {
      headerStyle: {
        backgroundColor: config.color.primary,
      },
      headerTintColor: '#fff',
      headerTitleStyle: {
        fontWeight: 'bold',
      },
    }, /* Other configuration remains unchanged */
  }
);


const store = createStore(rootReducers);

export default class App extends React.Component {

  render() {
    return(
      <Provider store={store}>
        <RootStack />
      </Provider>
    );
  }
}

