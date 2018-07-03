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
};

type state = {
  text: string
}

class RegisterForm extends React.Component {

  constructor(props) {
    super(props);

    this.state = {
      username: '',
      password: '',
      email: '',
      errors: []
    }
  }

  render() {
    return (
      <View style={{ margin: theme.margin }}>
        <TextInput
          style={styles.form}
          onChangeText={(username) => this.setState({username})}
          value={this.state.username}
          placeholder={'Username'}
        />
        <Separator/>
        <TextInput
          style={styles.form}
          onChangeText={(password) => this.setState({password})}
          value={this.state.password}
          placeholder={'Password'}
          secureTextEntry
        />
        <Separator/>
        <TextInput
          style={styles.form}
          onChangeText={(email) => this.setState({email})}
          value={this.state.email}
          placeholder={'Email'}
        />
        <Button
          text={'Je me connecte'}
          color={config.color.secondary}
          onPress={handleLoginPress}
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

export default RegisterForm;
