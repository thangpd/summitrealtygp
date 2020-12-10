import Reflux from 'reflux';
import BuilderActions from '../action/builderAction';

const keyStore = Reflux.createStore({
  listenables: BuilderActions,
  onPublishData(data) {
    this.trigger(data);
  },
});

export default keyStore;
