import Reflux from 'reflux';
import BuilderActions from '../action/builderAction';

export default Reflux.createStore({
  listenables: BuilderActions,
  onPublishNewPosts: function (posts) {
    this.trigger(posts);
  },
});