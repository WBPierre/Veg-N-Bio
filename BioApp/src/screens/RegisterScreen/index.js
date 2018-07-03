// @flow

import React from 'react';
import { View, Text, StyleSheet, ScrollView, WebView } from 'react-native'

import config from '../../modules/config';

class RegisterScreen extends React.Component {

  static navigationOptions = {
    title: 'Register',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
  };

  render() {
    return (
      <ScrollView
        contentContainerStyle={styles.scrollView}
        centerContent
        snapToAlignment="center"
        maximumZoomScale={10}
        minimumZoomScale={1}
      >
        <WebView
          style={styles.pdf}
          source={{uri: 'http://admin.pierredelmer.com/admin'}}

        />
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  scrollView: {
    flex: 1
  },
  webView: {
    borderWidth: 1,
    flex: 1,
    width: '100%',
  },
});

export default RegisterScreen;