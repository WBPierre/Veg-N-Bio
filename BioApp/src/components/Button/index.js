// @flow

import React from 'react';
import {
  StyleSheet,
  TouchableOpacity,
  Text
} from 'react-native';

import theme from '../../modules/theme'


type PropsType = {
  text?: string,
  color?: string,
  onPress?: Function,
  style?: StyleSheet,
};

const Button = (props: PropsType) => {

  const { text, color, onPress, style } = props;

  return (
    <TouchableOpacity
      onPress={onPress}
      style={[style, styles.container , {backgroundColor: color} ]}
    >
      <Text style={styles.text}>{text}</Text>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    padding: theme.margin,
    margin: theme.margin,
    height: 40,
    width: 130,
    alignSelf: 'center',
    justifyContent: 'center',
    alignItems: 'center',
    borderRadius: theme.radius,
    shadowColor: '#000000',
    shadowOffset: {
      width: 0,
      height: 0,
    },
    shadowRadius: theme.radius,
    shadowOpacity: 0.1,
  },
  text: {
    color: 'white',
    fontWeight: 'bold',
  }
});

export default Button;
