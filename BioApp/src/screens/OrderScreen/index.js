// @flow

import React from 'react';
import { View, Text, StyleSheet, ScrollView, Image } from 'react-native'

import Box from '../../components/Box';
import BoxProducts from '../../components/BoxProducts';
import CartScreen from '../../screens/CartScreen';
import config from '../../modules/config';
import theme from '../../modules/theme';
import AddCart from '../../components/AddCart'



class OrderScreen extends React.Component {

  static navigationOptions = {
    title: 'Order',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
    tabBarIcon: () => (<Image source={config.files.list} style={styles.iconTabBar} width={20} height={20}/>)
  };


  handleBoxPress = (id) => {
    this.props.navigation.navigate('Products', {
      type: id
    });
  }


  render() {

    return (
      <ScrollView>
        <View style={styles.container}>
          <View style={styles.view}>
            <Box color={config.color.tertiary} style={styles.box}>
              <BoxProducts
                source={'entrees'}
                text={'Entrées'}
                color={config.color.secondary}
                handleBoxPress={this.handleBoxPress.bind(this, 0)}
              />
            </Box>
            <Box color={config.color.tertiary} style={styles.box}>
              <BoxProducts
                source={'plats'}
                text={'Plats'}
                color={config.color.secondary}
                handleBoxPress={this.handleBoxPress.bind(this, 1)}
              />
            </Box>
            <Box color={config.color.tertiary} style={styles.box}>
              <BoxProducts
                source={'salades'}
                text={'Salades'}
                color={config.color.secondary}
                handleBoxPress={this.handleBoxPress.bind(this, 2)}
              />
            </Box>
            <Box color={config.color.tertiary} style={styles.box}>
              <BoxProducts
                source={'desserts'}
                text={'Dessert'}
                color={config.color.secondary}
                handleBoxPress={this.handleBoxPress.bind(this, 3)}
              />
            </Box>
            <Box color={config.color.tertiary} style={styles.box}>
              <BoxProducts
                source={'boissons'}
                text={'Boissons'}
                color={config.color.secondary}
                handleBoxPress={this.handleBoxPress.bind(this, 4)}
              />
            </Box>
          </View>
        </View>
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    flexDirection: 'column'
  },
  view: {
    margin: theme.margin,
  },
  box: {
    justifyContent: 'center',
  }
});

export default OrderScreen;