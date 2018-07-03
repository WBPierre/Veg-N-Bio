// @flow

import React from 'react';
import {
  View,
  Text,
  Image,
  StyleSheet,
  TouchableOpacity,
  ScrollView, AsyncStorage
} from 'react-native'
import Carousel from 'react-native-carousel-view';

import Button from '../../components/Button/';
import Box from '../../components/Box'

import theme from '../../modules/theme';
import config from '../../modules/config';

class HomeScreen extends React.Component {

  static navigationOptions = {
    title: 'Home',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
    tabBarIcon: () => (<Image source={config.files.home} style={styles.iconTabBar} width={20} height={20}/>)


  };

  render() {

    return (
      <ScrollView>
        <View style={styles.container}>
          <Carousel
            delay={2000}
            indicatorAtBottom
            indicatorSize={15}
            indicatorText="○"
            indicatorColor={config.color.secondary}
          >
            <View style={styles.contentContainer}>
              <Image source={config.files.carousel1} style={styles.carrousselHomeScreen}/>
            </View>
            <View style={styles.contentContainer}>
              <Image source={config.files.carousel2} style={styles.carrousselHomeScreen}/>
            </View>
            <View style={styles.contentContainer}>
              <Image source={config.files.carousel3} style={styles.carrousselHomeScreen}/>
            </View>
          </Carousel>
          <Box style={styles.box} color={config.color.tertiary}>
            <Button
              text={"M'y rendre"}
              color={config.color.primary}
              onPress={() => this.props.navigation.navigate('Restaurants')}
            />
            <Button
              text={"Passer une commande"}
              color={config.color.secondary}
              onPress={() => this.props.navigation.navigate('Order')}
            />
          </Box>
          <TouchableOpacity onPress={() => this.props.navigation.navigate('Account')}>
            <Box color={config.color.primary}>
              <View style={styles.view}>
                <Image source={config.files.profile} style={styles.carrousselHomeScreen} width={40} height={40}/>
              </View>
              <View>
                <Text style={[styles.text, styles.title, {color: config.color.secondary}]}>Mon compte</Text>
                <Text style={[styles.text, {color: config.color.tertiary}]}>Inscrivez-vous pour pouvoir profiter d'avantages</Text>
              </View>
            </Box>
          </TouchableOpacity>
          <TouchableOpacity onPress={() => this.props.navigation.navigate('Order')}>
            <Box color={config.color.tertiary}>
              <View style={styles.view}>
                <Image source={config.files.vegetables} style={styles.carrousselHomeScreen} width={40} height={50}/>
              </View>
              <View>
                <Text style={[styles.text, styles.title, {color: config.color.primary}]}>Nos produits</Text>
                <Text style={[styles.text, {color: config.color.black}]}>Découvrez tous nos menus, sandwiches, salades, desserts...</Text>
              </View>
            </Box>
          </TouchableOpacity>
        </View>
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  carrousselHomeScreen: {
    height: 200,
    width: window.width
  },
  view: {
    flexDirection: 'row',
    alignSelf : 'center',
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
});

export default HomeScreen;