// @flow

import React from 'react';
import {
  View,
  Text,
  Platform,
  StyleSheet,
  TouchableOpacity,
  Animated,
  ScrollView,
  Image, AsyncStorage,
  Modal,
  TouchableHighlight
} from 'react-native';

import QRCode from 'react-native-qrcode-svg';

import { connect } from 'react-redux';
import { removeProducts } from '../../redux/actions/addProducts';

import CartList from '../../components/CartList';
import Separator from '../../components/Separator';
import Button from '../../components/Button';
import Box from '../../components/Box';

import theme from '../../modules/theme';
import config from '../../modules/config';



class CartScreen extends React.Component {
  static navigationOptions = {
    title: 'Cart',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
    tabBarIcon: () => {
      return (
        <View>
          <Image source={config.files.cart} style={styles.iconTabBar} width={20} height={20}/>
        </View>
      )
    }
  };


  constructor(props) {
    super(props);

    this.state = {
      price: 0,
      isConnected: this.props.products.authReducer.user,
      modalVisible: false,
      modal2Visible: false,
      token: undefined
    }
  }


  handleCancelPress = () => {

    this.props.removeProducts();
  }

  handleOrderPress = () => {

    this.setState({"modalVisible": true});

  }

  handleSeeProducts = () => {
    this.props.navigation.navigate('Order');
  }

  generateToken = () => {

    let chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let token = '';
    for(let i = 0; i < 25; i++) {
      token += chars[Math.floor(Math.random() * chars.length)];
    }

    return token;
  }

  handlePayPress = (sum) => {

    const token  = this.generateToken();

    fetch("https://pool2.pierredelmer.com/mobile/cartPaiement.php", {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json; charset=utf-8'
      },
      body:  JSON.stringify({
        products: this.props.products.productsReducer.products,
        user: this.props.products.authReducer.user,
        total: sum,
        token: token
      })
    })
      .then((response) => response.json())
      .then((responseJson) => {
        this.setState({"modalVisible": false});
        this.setState({"modal2Visible": true});
        this.setState({ token: responseJson });


      })
      .catch((error) => {
        console.log(error);
      });
  }


  render(){

    const cart = this.props.products.productsReducer.products;
    const price = this.props.products.productsReducer.price;



    const sum = price && price.reduce((memo, val) => {
      return parseInt(memo) + parseInt(val);
    });


    return(
      <ScrollView style={styles.list}>
        {cart && cart.map((products, index) => {

          return (
              <View key={index}>
                <CartList
                  name={products.name}
                  price={products.price}
                  total={price}
                />
                <Separator/>
              </View>
          )
        })}
        {sum ?
          <View>
            <View style={styles.box} color={config.color.tertiary}>
              <Text style={{ fontWeight: 'bold', padding: theme.margin }}> Total: {sum}€</Text>
            </View>
              <View style={styles.button} color={config.color.tertiary}>
              <Button
              color={config.color.primary}
              text={'Annuler'}
              onPress={this.handleCancelPress}
              />
              <Button
              color={config.color.secondary}
              text={'Commander'}
              onPress={this.handleOrderPress}
              />
              </View>
          </View>
          :
          <View>
            <Text style={styles.empty}>Vous n'avez rien dans votre panier...</Text>
            <Button
              color={config.color.secondary}
              text={'Voir les produits'}
              onPress={this.handleSeeProducts}
            />
          </View>
        }
        <Modal
          animationType="slide"
          transparent={false}
          visible={this.state.modalVisible}
          onRequestClose={() => {
            alert('Modal has been closed.');
          }}>
          <TouchableOpacity style={{ marginTop: 25 }} onPress={this.handlePayPress.bind(this, sum)}>
            <Box color={config.color.primary}>
              <View>
                <Text style={[styles.text, styles.title, {color: config.color.secondary}]}>Paiement</Text>
                <Text style={[styles.text, {color: config.color.tertiary}]}>Utiliser ma carte bleue enregistrée</Text>
              </View>
            </Box>
          </TouchableOpacity>
          <TouchableOpacity onPress={() => this.setState({ modalVisible: false })}>
            <Box color={config.color.secondary}>
              <View>
                <Text style={[styles.text, styles.title, {color: config.color.tertiary}]}>Panier</Text>
                <Text
                  style={[styles.text, {color: config.color.tertiary}]}
                >Cliquez ici pour revenir au panier</Text>
              </View>
            </Box>
          </TouchableOpacity>
        </Modal>
        <Modal
          animationType="slide"
          transparent={false}
          visible={this.state.modal2Visible}
          onRequestClose={() => {
            alert('Modal has been closed.');
          }}>
          {console.log(this.state.token)}

          <View style={styles.header}>
            <Text style={styles.headerTitle}>Validation de la commande</Text>
          </View>
          <View style={styles.qrcode}>
            <QRCode
              value={"https://pool2.pierredelmer.com/mobile/cartPaiement.php?token=" + this.state.token}
              size={250}
            />
          </View>
          <Button
            style={{ flexDirection: 'row' }}
            color={config.color.secondary}
            text={'Voir mes commandes'}
            onPress={() => this.setState({ modal2Visible: false })}
          />
        </Modal>
      </ScrollView>
    )}
}

const styles = StyleSheet.create({
  box: {
    backgroundColor: 'white',
    padding: 3*theme.margin,
  },
  text: {
    fontWeight: 'bold'
  },
  empty:{
    padding: theme.margin
  },
  button: {
    flexDirection: 'row',
  },
  view: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    marginLeft: theme.margin,
  },
  box: {
    justifyContent: 'center',
  },
  title: {
    color: config.color.secondary,
    fontWeight: 'bold',
    fontSize: 16,
  },
  text: {
    padding: theme.margin,
    marginLeft: theme.margin,
    marginRight: theme.margin,
    color: 'white',

    borderRadius: theme.radius,
    shadowColor: '#000000',
    shadowOffset: {
      width: 0,
      height: 0,
    },
    shadowRadius: theme.radius,
    shadowOpacity: 0.1,
  },
  qrcode: {
    paddingTop: theme.margin,
    justifyContent: 'center',
    alignItems: 'center',
    marginTop: theme.marginL
  },
  header: {
    backgroundColor: config.color.primary,
    padding: theme.margin,
    alignItems: 'center'
  },
  headerTitle: {
    color: 'white',
    fontWeight: 'bold',
    fontSize: 20,
    marginTop: 2*theme.marginL,
    marginBottom: theme.marginL,
  },
  counter: {
    backgroundColor: 'red',
    position: 'absolute',
    right: -10,
    padding: 3,
    fontSize: 14,
    borderRadius: theme.circleRadius
  }
});

export default connect(( products, auth ) => ({ products, auth }), {removeProducts})(CartScreen);