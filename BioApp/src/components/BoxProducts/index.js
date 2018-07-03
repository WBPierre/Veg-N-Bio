// @flow

import React from 'react';
import {
  StyleSheet,
  TouchableOpacity,
  Text,
  View,
  Image
} from 'react-native';

import theme from '../../modules/theme';
import images from '../../modules/config';
import Button from '../Button';
import { requireImage } from '../../modules/Function/function'


type PropsType = {
  text?: string,
  color?: string,
  source?: string,
  handleBoxPress?: Function
};

const BoxProducts = (props: PropsType) => {

  const { text, color, source, handleBoxPress } = props;

  const name = typeof source === 'string' && source.split('.');

  return (
    <View style={styles.container}>
      <View style={styles.image}>
        <Image source={requireImage(name[0] || 'notFound')} style={{width: 145, height: 100, overflow: 'visible'}}/>
      </View>
      <Text style={styles.text}>{text}</Text>
      <Button
        text={'Choisir'}
        color={color}
        onPress={handleBoxPress}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    alignItems: 'center',
    flex: 1,
  },
  image: {
    width: 145,
    height: 100,
    overflow: 'scroll',
    borderRadius: theme.radius
  },
  text: {
    padding: theme.margin,
    fontWeight: 'bold'
  }

});

export default BoxProducts;
