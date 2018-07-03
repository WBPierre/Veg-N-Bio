// @flow

import React from 'react';
import {
  StyleSheet,
  TouchableOpacity,
  Text,
  TextInput,
  View
} from 'react-native';

import Separator from '../Separator';
import Button from '../Button';
import theme from '../../modules/theme'
import config from '../../modules/config'


type PropsType = {
  text?: string,
  color?: string,
  onPress?: Function,
  submit?: Function
};

type state = {
  text: string
}

class LoginForm extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      email: '',
      password: '',
      errors: []
    }
  }

  handleSubmitPress = () => {

    const credentials = {
      email: this.state.email,
      password: this.state.password
    }

    this.props.submit(credentials)
  }


  render() {

    return (
      <View style={{ margin: theme.margin }}>
        <TextInput
          style={styles.form}
          onChangeText={(email) => this.setState({email})}
          value={this.state.email}
          placeholder={'email'}
        />
        <Separator/>
        <TextInput
          style={styles.form}
          onChangeText={(password) => this.setState({password})}
          value={this.state.password}
          placeholder={'Password'}
          secureTextEntry
        />
        <Button
          text={'Se connecter'}
          color={config.color.secondary}
          onPress={this.handleSubmitPress}
        />
      </View>
    );
  }
}

const styles = StyleSheet.create({
  form: {
    backgroundColor: config.color.tertiary,
    height: 40,
    padding: 10,
    borderRadius: theme.radius,
  },
});

export default LoginForm;
