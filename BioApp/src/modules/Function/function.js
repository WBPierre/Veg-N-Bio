import { AsyncStorage } from "react-native"

export const requireImage = (name) => {


  switch(name){
    case 'betteraves5ad6055b0dd96': return require('../images/products/betteraves5ad6055b0dd96.png');
    case 'gratin5ad604936377a': return require('../images/products/gratin5ad604936377a.png');
    case 'carpaccio5ad602ae54fa5': return require('../images/products/carpaccio5ad602ae54fa5.png');
    case 'cheesecake5ad604ec770d3': return require('../images/products/cheesecake5ad604ec770d3.png');
    case 'eau5ad605f727951': return require('../images/products/eau5ad605f727951.png');
    case 'pate5ad601e7882ea': return require('../images/products/pate5ad601e7882ea.png');
    case 'soupealoignon5ad60116c13a1': return require('../images/products/soupealoignon5ad60116c13a1.png');
    case 'saumonfume5ad6033361ab6': return require('../images/products/saumonfume5ad6033361ab6.png');
    case 'tapas5ad602f2acf84': return require('../images/products/tapas5ad602f2acf84.png');
    case 'surprise5ad6036eeba8c': return require('../images/products/surprise5ad6036eeba8c.png');
    case 'poulet5ad6044912d0e': return require('../images/products/poulet5ad6044912d0e.png');
    case 'salade5ad605405524f': return require('../images/products/salade5ad605405524f.png');
    case 'fondue5ad6040f091b1': return require('../images/products/fondue5ad6040f091b1.png');
    case 'entrees': return require('../images/entrees.jpg');
    case 'desserts': return require('../images/desserts.jpg');
    case 'plats': return require('../images/plats.jpg');
    case 'boissons': return require('../images/boissons.jpeg');
    case 'salades': return require('../images/salades.jpg');
  }

}


export async function setAsyncStorage(key, value) {
  await AsyncStorage.setItem(key, value);

}

export function getAsyncStorage(Value) {
  return AsyncStorage.getItem(Value).then((value) => {
    return value;
  }).done()
}

