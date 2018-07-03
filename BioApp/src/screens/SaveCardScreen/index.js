// @flow

import React from 'react';
import { View, Text, StyleSheet, ScrollView, AsyncStorage } from 'react-native'

import LoginForm from '../../components/LoginForm';
import config from '../../modules/config';

import { connect } from 'react-redux'
import { setIsConnected } from '../../redux/actions/auth';
import { getAsyncStorage, setAsyncStorage } from '../../modules/Function/function'



class SaveCardScreen extends React.Component {

  static navigationOptions = {
    title: 'Save Card',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },

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
      .then(data => {

        if(data._bodyText.trim() === 'true'){
          setAsyncStorage('isConnected', 'true');
          this.props.navigation.navigate('Home');
        }

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

export default SaveCardScreen;