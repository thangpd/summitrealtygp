import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Select from 'react-select';
import BuilderActions from './action/builderAction';
import AlikeEditPanel from './editPanel';
import KeyStore from './store/keyStore';
import { findIndex } from 'underscore';
import clone from 'clone';
import { Accordion, Panel } from 'react-bootstrap';

class AlikeComponent extends Component {
  constructor(props) {
    super(props);

    this.handleChange = this.handleChange.bind(this);
    this.addPosts = this.addPosts.bind(this);
    this.postValues = [];

    let alikeData = [];
    if (typeof ALIKE_DATA !== undefined) {
      alikeData = clone(ALIKE_DATA);
    }
    this.state = {
      PostTypes: ALIKE_ADMIN.helper.all_post_types ? ALIKE_ADMIN.helper.all_post_types : [],
      buildData: alikeData,
    };
  }
  componentDidMount() {
    KeyStore.listen(this.updateBuildData.bind(this));
    jQuery('.alike-animated-btn').hover(
      function() {
        const item = jQuery(this);
        const slidelem = item.parent();
        slidelem.css({ 'transform': 'matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, -60, 0, 0, 1)' });
      },
      function() {
        const item = jQuery(this);
        const slidelem = item.parent();
        slidelem.css({ 'transform': 'matrix3d(1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1)' });
      },
    );
  }
  updateBuildData(buildData) {
    this.setState({ buildData });
  }

  handleChange(multi, values) {
    this.buildSelected = [];
    const { buildData } = this.state;
    this.postValues = values.split(',');
    this.postValues.forEach((postType) => {
      const Index = findIndex(buildData, { 'post_type': postType });
      if (Index !== -1) {
        this.buildSelected.push(buildData[Index]);
      } else {
        this.buildSelected.push({
          'post_type': postType,
        });
      }
    });
  }
  addPosts(e) {
    e.preventDefault();
    BuilderActions.saveAllData({ allData: this.buildSelected });
  }
  handleOpen(item) {
    const { buildData } = this.state;
    const Index = findIndex(this.state.buildData, { post_type: item.post_type });
    if (Index !== -1) {
      buildData[Index].isOpen = !buildData[Index].isOpen;
    }
    this.setState({ buildData });
  }

  saveData(e) {
    e.preventDefault();
    BuilderActions.saveAllData({ allData: this.state.buildData });
  }

  render() {
    const { buildData } = this.state;

    this.selectOptions = [];
    this.selectedOptions = [];
    this.state.PostTypes.map((item) => {
      this.selectOptions.push({
        label: item,
        value: item,
      });
    });

    this.state.buildData.forEach((item) => {
      this.selectedOptions.push({
        label: item.post_type,
        value: item.post_type,
      });
    });
    const showBuildData = (item, index) => {
      return (
        <Panel header={item.post_type} key={index} eventKey={index}>
          { <AlikeEditPanel {...item} buildData={buildData} /> }
        </Panel>
      );
    };

    let selectedData = [];
    let flag = false;

    if (this.selectedOptions.length === 1) {
      if (this.selectedOptions[0].value === '') {
        selectedData = null;
      } else {
        flag = true;
        selectedData = this.selectedOptions;
      }
    } else {
      flag = true;
      selectedData = this.selectedOptions;
    }

    return (
      <div className="allike-container">
        <h3>{ALIKE_ADMIN.LANG.PLEASE_SELECT_POST_TYPES}</h3>
        <div className="col-md-6 alike-select">
          <Select name="form-field-name" multi options={this.selectOptions} value={selectedData} onChange={this.handleChange.bind(this, true)}/>
        </div>
        <button className="btn btn-add-post" onClick={this.addPosts}><i className="icon-layers icons font-bold"></i> {ALIKE_ADMIN.LANG.ADD_POST_TYPES}</button>
        <div className="clearfix"></div>
        <Accordion>
          {flag ? buildData.map(showBuildData) : <div>
            <h2 style={{ color: '#b1b1b1', textAlign: 'center' }}> {ALIKE_ADMIN.LANG.PLEASE_SELECT_A_POST_TYPE} </h2>
          </div>}
        </Accordion>
        <div className="alike-btn-wrap clearfix">
          <div className="alike-btn-item">
            <button className="btn btn-save alike-animated-btn" onClick={this.saveData.bind(this) }><i className="icon-drawer icons font-bold"></i> {ALIKE_ADMIN.LANG.SAVE}</button>
          </div>
        </div>
      </div>
    );
  }
}

if (document.getElementById('alike-admin')) {
  ReactDOM.render(<AlikeComponent />, document.getElementById('alike-admin'));
}
