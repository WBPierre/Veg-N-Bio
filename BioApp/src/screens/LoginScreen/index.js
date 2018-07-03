// @flow

import React from 'react';
import { View, Text, StyleSheet, ScrollView, AsyncStorage } from 'react-native'

import LoginForm from '../../components/LoginForm';
import config from '../../modules/config';

import { connect } from 'react-redux'
import { fetchUser } from '../../redux/actions/auth';


class LoginScreen extends React.Component {

  static navigationOptions = {
    title: 'Login',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },

  }

  constructor(props) {
    super(props);

    this.state = {
      user: []
    }
  }

  submit = (data) => {

    fetch("https://pool2.pierredelmer.com/mobile/form.php", {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json; charset=utf-8'
      },
      body:  JSON.stringify({
        email: data.email,
        password: data.password
      })
    })
      .then((response) => response.json())
      .then((responseJson) => {
        this.setState({
          user: responseJson
        });
        this.props.fetchUser(this.state.user);
        this.props.navigation.navigate('Account');
        this.props.navigation.navigate('Home');
      })
      .catch((error) => {
        console.log(error);
      });
  }

  render() {
    return (
      <ScrollView>
        <LoginForm submit={this.submit}/>
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({

});

export default connect(( auth ) => ({ auth }), {
  fetchUser,
})(LoginScreen);