// @flow

import React from 'react';
import { View, Text, StyleSheet, ScrollView, ListView, ActivityIndicator, Dimensions, Image } from 'react-native'

import Box from '../../components/Box';
import BoxProducts from '../../components/BoxProducts';
import config from '../../modules/config';

import { connect } from 'react-redux'
import { addProducts } from '../../redux/actions/addProducts';


const window = Dimensions.get('window');

class ProductsScreen extends React.Component {

  static navigationOptions = {
    title: 'Products',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
    tabBarIcon: () => (<Image source={config.files.list} style={styles.iconTabBar} width={20} height={20}/>)
  };

  constructor(props) {
    super(props);

    this.state = {
      isFetching: true,
      data: [],
    }
  }


  componentDidMount() {
    return fetch('https://pool2.pierredelmer.com/mobile/products.php')
      .then((response) => response.json())
      .then((responseJson) => {
        this.setState({
          isFetching: false,
          data: responseJson
        });
      })
      .catch((error) => {
        console.log(error);
      });
  }

  handleSelectProduct = (products) => {

    this.props.addProducts(products);

  }
  render() {

    const { data , isFetching} = this.state;

    return(
      <ScrollView style={styles.list}>
        { isFetching && <ActivityIndicator style={{ marginTop: window.height/2.5 }} size="large" color={config.color.primary} />}
        {data.map((products, index) => {
          if(products.type == this.props.navigation.state.params.type) {
            return (
                <View key={index}>
                  <Box color={config.color.tertiary} style={styles.box}>
                    <BoxProducts
                      text={products.name}
                      color={config.color.secondary}
                      source={products.img}
                      handleBoxPress={this.handleSelectProduct.bind(this, products)}
                    />
                  </Box>
              </View>
            )
          }
        })}
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  box: {
    flexDirection: 'row',
  }
});


export default connect( null, {
  addProducts,
})(ProductsScreen);