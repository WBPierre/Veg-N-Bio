import { CONNECTED, DISCONNECTED } from '../const'

export const fetchUser = (user) => {
  return {
    type: CONNECTED,
    user
  }
}

export const disconnectUser = () => {
  return {
    type: DISCONNECTED,
  }
}