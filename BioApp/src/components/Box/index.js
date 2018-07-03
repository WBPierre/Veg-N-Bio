// @flow


import React from 'react';
import { StyleSheet, View } from 'react-native';
import theme from '../../modules/theme'

const Box = (props: PropsType) => {
  const { color, style, ...defaultProps } = props;

  return <View style={[styles.box, style, { backgroundColor: color}]} {...defaultProps} />;
};

const styles: ReactNative$StyleSheet = StyleSheet.create({
  box: {
    margin: theme.margin,
    padding: theme.margin,
    flexDirection: 'row',
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

export default Box;
