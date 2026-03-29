import { store } from '@wordpress/interactivity'
import { navigate } from '@wordpress/interactivity-router';

// Utilisation.
const { state, actions } = store('my-store', {
  state: {
    count: 0
  },
  actions: {
    increment() {
      state.count++;
    }
  }
});

