// @flow

import React from 'react';
import { StyleSheet, View } from 'react-native';

import theme from '../../modules/theme';

type PropsType = {
  small?: boolean,
  large?: boolean,
};
const Space = (props: PropsType) => (
  <View
    style={[
      styles.medium,
      props.small && styles.small,
      props.large && styles.large,
    ]}
  />
);

const styles = StyleSheet.create({
  medium: {
    width: theme.margin,
    height: theme.margin,
  },
  small: {
    width: theme.marginS,
    height: theme.marginS,
  },
  large: {
    width: theme.marginL,
    height: theme.marginL,
  },
});

export default Space;
