// @flow

import React from 'react';
import { ColorPropType, StyleSheet, View } from 'react-native';

import config from '../../modules/config';

type PropsType = {
  color?: ColorPropType,
};

const Separator = (props: PropsType) => {
  const { color = config.color.secondary } = props;
  return <View style={[styles.line, { backgroundColor: config.color.darkGrey }]} />;
};

const styles = StyleSheet.create({
  line: {
    height: 1,
  },
});

export default Separator;
