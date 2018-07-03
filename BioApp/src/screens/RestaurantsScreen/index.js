// @flow

import React from 'react';
import {
  View,
  Text,
  Image,
  StyleSheet,
  ScrollView,
  ActivityIndicator,
  TouchableOpacity,
  Alert,
  Platform
} from 'react-native'
import MapView from 'react-native-maps';

import config from '../../modules/config';
import theme from '../../modules/theme';
import Box from '../../components/Box'


const LATITUDE_DELTA = 0.01;
const LONGITUDE_DELTA = 0.01;



class RestaurantsScreen extends React.Component {

  static navigationOptions = {
    title: 'Restaurants',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
    tabBarIcon: () => (<Image source={config.files.restaurant} style={styles.iconTabBar} width={20} height={20}/>)
  };

  constructor (props) {
    super(props);
    this.state = {
      data: [],
      region: {
        latitude: 48.849145,
        longitude: 2.389659100000017,
        latitudeDelta: 0.0072,
        longitudeDelta: 0.0072,
      },
      ready: true,
    }
  }

  componentDidMount() {

    this.getCurrentPosition();

    return fetch('https://pool2.pierredelmer.com/mobile/map.php')
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


  handlePressRestaurant = (restaurant) => {
    _mapView.animateToCoordinate({
      latitude: restaurant.lat,
      longitude: restaurant.lon
    }, 1000);
    this.refs._scrollView.scrollTo({y: 0, x:0});
  }


  setRegion(region) {
    if(this.state.ready) {
      setTimeout(() => _mapView.animateToRegion(region), 10);
    }
    this.setState({ region });
  }

  getCurrentPosition() {
    try {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const region = {
            latitude: position.coords.latitude,
            longitude: position.coords.longitude,
            latitudeDelta: LATITUDE_DELTA,
            longitudeDelta: LONGITUDE_DELTA,
          };
          this.setRegion(region);
        },
        (error) => {
          switch (error.code) {
            case 1:
              if (Platform.OS === "ios") {
                Alert.alert("", "Veuillez activer votre localisation");
              } else {
                Alert.alert("", "Veuillez activer votre localisation");
              }
              break;
            default:
              Alert.alert("", "Une erreur est survenue");
          }
        }
      );
    } catch(e) {
      alert(e.message || "");
    }
  };


  render () {

    const { data, isFetching } = this.state;


    return (
     <ScrollView ref='_scrollView'>
       <View>
          <MapView
            ref = {(mapView) => { _mapView = mapView; }}
            initialRegion={this.state.region}
            showsUserLocation
            style={styles.map}
          >
            {data.map((restaurant, index) => {

              const coordinates = {
                latitude: Number(restaurant.lat),
                longitude: Number(restaurant.lon)
              }

              return(
                <MapView.Marker
                  key={index}
                  coordinate={coordinates}
                  title={restaurant.name}
                  description={restaurant.address}
                />
              )
            })}
          </MapView>
       </View>
       <View>
          { isFetching && <ActivityIndicator style={{ marginTop: window.height/2.5 }} size="large" color={config.color.primary} />}
          {data.map((restaurant, index) => {
            return (
              <TouchableOpacity key={index} onPress={this.handlePressRestaurant.bind(this,restaurant)}>
                <Box color={config.color.tertiary} style={styles.box}>
                    <Text style={styles.title}>{restaurant.name}</Text>
                    <Text>{restaurant.address}</Text>
                </Box>
              </TouchableOpacity>
            )

          })}
       </View>
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  map: {
    height: 300
  },
  backgroundImage: {
    alignItems: 'center'
  },
  espaceText: {
    marginTop: 15,
    marginLeft:10
  },
  button: {
    padding: theme.margin
  },
  title: {
    fontWeight: 'bold',
     flexDirection: 'row'
  },
  box: {
    flexDirection: 'column',
    padding: theme.marginL
  }
});


export default RestaurantsScreen;