// @flow

import React from 'react';
import { View, Text, StyleSheet, ScrollView, AsyncStorage, Image } from 'react-native'
import { connect } from 'react-redux';

import Box from '../../components/Box';
import Button from '../../components/Button'
import config from '../../modules/config';
import theme from '../../modules/theme';
import PersonnalScreen from '../PersonnalScreen';
import { disconnectUser } from '../../redux/actions/auth';


class AccountScreen extends React.Component {

  static navigationOptions = {
    title: 'Account',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
    tabBarIcon: () => (<Image source={config.files.account} style={styles.iconTabBar} width={20} height={20}/>)
  };

  constructor(props) {
    super(props);

    this.state = {
      isConnected: this.props.auth.authReducer.user
    }

    console.log(this.state.isConnected);
  }

  handleLoginPress = () => {
    this.props.navigation.navigate('Login');
  }

  handleLogoutPress = () => {

    this.props.disconnectUser();
    this.props.navigation.navigate('Account');
    this.props.navigation.navigate('Home');
  }

  handleRegisterPress = () => {
    this.props.navigation.navigate('Register');
  }

  render() {
    if(Object.keys(this.state.isConnected).length === 0) {
      return(
        <ScrollView>
          <View style={styles.container}>
            <Box style={styles.box} color={config.color.tertiary}>
              <Text style={styles.text}>Déjà client ?</Text>
              <View style={styles.flexButton}>
                <Button
                  text={'Se connecter'}
                  color={config.color.secondary}
                  onPress={this.handleLoginPress}
                />
              </View>
              <Text style={styles.register} onPress={this.handleRegisterPress}>Pas encore inscrit ?</Text>
            </Box>
          </View>
        </ScrollView>
      )
    } else {
      return(
        <PersonnalScreen handleLogoutPress={this.handleLogoutPress} user={this.props.auth.authReducer.user}/>
      )
    }
  }
}

const styles = StyleSheet.create({
  container: {
    marginTop: theme.marginL
  },
  box: {
    flexDirection: 'column',
    alignItems: 'center',
    margin: theme.margin
  },
  text: {
    color: config.color.primary,
    fontSize: 16,
    fontWeight: 'bold',
    margin: theme.margin,
  },
  flexButton: {
    flex: 1,
    flexDirection: 'row',
  },
  register: {
    paddingTop: theme.marginL,
    color: 'blue'
  }
});

export default connect(( auth ) => ({ auth }), {
  disconnectUser,
})(AccountScreen);