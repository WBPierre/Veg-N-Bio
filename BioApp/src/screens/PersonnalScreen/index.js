// @flow

import React from 'react';
import { View, Text, StyleSheet, ScrollView, Modal, TouchableOpacity, TextInput } from 'react-native'

import Button from '../../components/Button'
import Box from '../../components/Box';
import Separator from '../../components/Separator';
import config from '../../modules/config/index';
import theme from '../../modules/theme/index';




class PersonnalScreen extends React.Component {

  static navigationOptions = {
    title: 'My space',
    headerStyle: {
      backgroundColor: config.color.primary,
    },
    headerTintColor: '#fff',
    headerTitleStyle: {
      fontWeight: 'bold',
    },
  };

  constructor(props) {
    super(props);
    this.state = {
      modalVisible: false,
      cardNumber: '',
      cryptogramme: '',
      data: []
    }
  }



  componentDidMount() {

     fetch("https://pool2.pierredelmer.com/mobile/accountOrder.php", {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json; charset=utf-8'
      },
      body:  JSON.stringify({
        id: this.props.user.id
      })
    })
      .then((response) => response.json())
      .then((responseJson) => {
        this.setState({
          data: responseJson
        });
        console.log(this.state.data);
      })
      .catch((error) => {
        console.log(error);
      });
  }

  handleSaveCardPress = () => {
    console.log(this.state.data);
    this.setState({"modalVisible": true});
  }

  handleConfirmCard = () => {

    this.setState({"modalVisible": false});
  }

  render() {

    const { user } = this.props;

    return (
      <ScrollView>
        <View style={styles.container}>
          <Box style={{ flexDirection: 'row' }} color={config.color.tertiary}>
            <Button
              text={'Enregistrer une carte bleue'}
              color={config.color.primary}
              onPress={this.handleSaveCardPress}
            />
            <Button
              text={'Me déconnecter'}
              color={config.color.secondary}
              onPress={this.props.handleLogoutPress}
            />
          </Box>
          <Box style={styles.box} color={config.color.tertiary}>
            <Text style={styles.title}>Commandes de {user.firstname} :</Text>
            {
              this.state.data.map( (data, index) => {
                return(
                  <View key={index} style={styles.orderBox}>
                    <Text style={styles.price}>{index+1} - </Text>
                    <Text style={styles.date}>{data.total}€ -> </Text>
                    <Text style={styles.date}>{data.date_inserted}</Text>
                  </View>
                );
              })
            }
          </Box>
        </View>
        <Modal
          animationType="slide"
          transparent={false}
          visible={this.state.modalVisible}
          onRequestClose={() => {
            alert('Modal has been closed.');
          }}>
          <View style={{ marginTop: 25 }}>
            <Box color={config.color.primary} style={{ padding: 15 }}>
              <View style={styles.boxContainer}>
                <Text style={styles.textPay}>Numéro de carte :</Text>
                <TextInput
                style={styles.form}
                onChangeText={(cardNumber) => this.setState({cardNumber})}
                value={this.state.cardNumber}
                placeholder={'Numéro de carte'}
                />
                <Separator/>
                <Text style={styles.textPay}>Cryptogramme :</Text>
                <TextInput
                style={styles.form}
                onChangeText={(cryptogramme) => this.setState({cryptogramme})}
                value={this.state.cryptogramme}
                placeholder={'Cryptogramme'}
                />
              </View>
            </Box>
          </View>
          <TouchableOpacity onPress={this.handleConfirmCard}>
            <Box color={config.color.secondary}>
              <View>
                <Text style={[styles.text, styles.title, {color: config.color.tertiary}]}>Confirmation</Text>
                <Text
                  style={[styles.text, {color: config.color.tertiary}]}
                >Cliquez ici pour confirmer</Text>
              </View>
            </Box>
          </TouchableOpacity>
        </Modal>
      </ScrollView>
    );
  }
}

const styles = StyleSheet.create({
  container: {
    marginTop: theme.marginL
  },
  box: {
    flexDirection: 'column',
    alignItems: 'center',
    margin: theme.margin
  },
  title: {
    fontWeight: 'bold'
  },
  textCommand: {
    alignItems: 'flex-start'
  },
  form: {
    backgroundColor: config.color.tertiary,
    height: 30,
    padding: 0,
    borderRadius: theme.radius,
  },
  textPay: {
    color: 'white',
    fontWeight: 'bold',
    paddingBottom: theme.margin,
    paddingTop: theme.margin,
  },
  boxContainer: {
    justifyContent: 'center'
  },
  orderBox: {
    flexDirection: 'row',
    backgroundColor: config.color.secondary,
    margin: theme.margin,
    padding: theme.margin,
    borderRadius: theme.radius
  },
  price: {
    color: 'white',
    fontWeight: 'bold',
  },
  date: {
    color: 'white',
    fontWeight: 'bold',

  }
});

export default PersonnalScreen;