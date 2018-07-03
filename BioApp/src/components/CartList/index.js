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

type PropsType = {
  name?: string,
  price?: number,
  total?: Array<number>
};

const CardList = (props: PropsType) => {

  const { name, price, total } = props;

  return (
    <View style={styles.list}>
      <View style={{ flexDirection: 'row', flex: 1}}>
        <Text style={styles.quantity}>1x  </Text>
        <Text style={styles.name}>{name}</Text>
      </View>
      <Text style={styles.price}>{price}€</Text>
    </View>
  );
};

const styles = StyleSheet.create({
  list: {
    backgroundColor: 'white',
    padding: 3*theme.margin,
    flexDirection: 'row',
  },
  quantity: {
    flexDirection: 'row',
  },
  name: {
    fontWeight: 'bold',
    flexDirection: 'row',
  },
  price: {
    flexDirection: 'row',
    alignSelf: 'flex-end'
  }
});

export default CardList;
