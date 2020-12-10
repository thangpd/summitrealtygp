import Reflux from 'reflux';
import NProgress from 'nprogress';
import http from '../helper/ajax';

const BuildActions = Reflux.createActions([
  'publishNewPosts',
  'saveAllPosts',
  'publishData',
  'saveAllData',
]);

NProgress.configure({ easing: 'ease', speed: 500 });

BuildActions.saveAllData.preEmit = (buildData) => {
  NProgress.start();
  http.post('save_all_data', buildData).end((error, res) => {
    if (res) {
      NProgress.done();
      BuildActions.publishData(JSON.parse(res.text));
    }
  });
};


export default BuildActions;
