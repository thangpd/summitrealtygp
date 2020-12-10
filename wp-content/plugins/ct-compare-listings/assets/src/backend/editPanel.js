import React, { Component, PropTypes } from 'react';
import clone from 'clone';
import AlikeSelectedList from './selectedList';
import { findIndex } from 'underscore';
import BuilderAction from './action/builderAction';
import Modal from 'react-modal';
import Toggle from 'react-toggle';
import { Accordion, Panel } from 'react-bootstrap';

const customStyles = {
  content: {
    top: '50%',
    left: '50%',
    right: 'auto',
    width: '50%',
    bottom: 'auto',
    marginRight: '-50%',
    borderRadius: '0',
    transform: 'translate(-50%, -50%)',
  },
};

class AlikeEditPanel extends Component {
  static propTypes = {
    selectedData: PropTypes.array,
    buildData: PropTypes.array,
    taxonomy_keys: PropTypes.array,
    meta_keys: PropTypes.array,
    // post_keys: PropTypes.array,
    post_type: PropTypes.string,
    logout: PropTypes.func,
  }

  constructor(props) {
    super(props);
    this.state = {
      selected: this.props.selectedData ? this.props.selectedData : [],
      temp: null,
      modalIsOpen: false,
      selectedForEdit: {},
    };
    this.handleSelected = this.handleSelected.bind(this);
    this.makeChangesIntoStore = this.makeChangesIntoStore.bind(this);
    this.closeModal = this.closeModal.bind(this);
    this.editTitle = this.editTitle.bind(this);
    this.handleTopValue = this.handleTopValue.bind(this);
    this.handleRatingValue = this.handleRatingValue.bind(this);
  }
  componentDidMount() {
    jQuery('.alike-selected-list').sortable({
      handle: '.alike-selected-move',
      stop: this.handleSort.bind(this),
    });
  }

  componentWillReceiveProps(nextProps) {
    if (nextProps) {
      this.setState({ selected: nextProps.selectedData });
    }
  }

  handleSort(event) {
    const latestSelectedList = [];
    const { selected } = this.state;
    jQuery(event.target).children().each((index, item) => {
      const key = String(jQuery(item).data('key'));
      const Index = findIndex(selected, { key });
      latestSelectedList.push(selected[Index]);
    });
    const { buildData, post_type } = this.props;
    const BuildIndex = findIndex(buildData, { post_type });
    if (BuildIndex !== -1) {
      buildData[BuildIndex].selectedData = latestSelectedList;
    }

    BuilderAction.saveAllData({ allData: buildData, noreturn: true });
  }

  handleChangeTax(item, e) {
    const selected = clone(this.state.selected);
    const index = findIndex(selected, { key: item });
    if (e.target.checked) {
      if (index === -1) {
        const taxData = {
          'type': 'taxonomy',
          'key': item,
          'title': item,
          'isShown': false,
        };
        selected.push(taxData);
      }
    } else {
      if (index !== -1) {
        selected.splice(index, 1);
      }
    }
    this.makeChangesIntoStore(selected);
    this.setState({
      selected,
    });
  }

  handleChangeMeta(item, e) {
    const selected = clone(this.state.selected);
    const index = findIndex(selected, { key: item });
    if (e.target.checked) {
      if (index === -1) {
        const metaData = {
          'type': 'meta',
          'key': item,
          'title': item,
          'isShown': false,
        };
        selected.push(metaData);
      }
    } else {
      if (index !== -1) {
        selected.splice(index, 1);
      }
    }
    this.makeChangesIntoStore(selected);
    this.setState({
      selected,
    });
  }

  // handleChangePostKey(item, e) {
  //   const selected = clone(this.state.selected);
  //   const index = findIndex(selected, { key: item });
  //   if (e.target.checked) {
  //     if (index === -1) {
  //       const postData = {
  //         'type': 'post_keys',
  //         'key': item,
  //         'title': item,
  //         'isShown': false,
  //       };
  //       selected.push(postData);
  //     }
  //   } else {
  //     if (index !== -1) {
  //       selected.splice(index, 1);
  //     }
  //   }
  //   this.makeChangesIntoStore(selected);
  //   this.setState({
  //     selected,
  //   });
  // }

  handleChangeTerm(item, key, e) {
    const selected = clone(this.state.selected);
    const index = findIndex(selected, { key: item.slug });
    if (e.target.checked) {
      if (index === -1) {
        const postData = {
          'type': 'term',
          'key': item.slug,
          'title': item.value,
          'taxonomy': key,
          'isShown': false,
        };
        selected.push(postData);
      }
    } else {
      if (index !== -1) {
        selected.splice(index, 1);
      }
    }
    this.makeChangesIntoStore(selected);
    this.setState({
      selected,
    });
  }

  handleSelected(e) {
    const index = findIndex(this.state.selected, { key: e.key });
    if (index !== -1) {
      const data = this.state.selected[index];
      this.setState({
        selectedForEdit: data,
        modalIsOpen: true,
      });
    }
  }
  editTitle(value, item) {
    const selected = clone(this.state.selected);
    const index = findIndex(selected, { key: item.key });
    if (index !== -1) {
      selected[index].title = value;
      this.makeChangesIntoStore(selected);
      this.setState({ selected });
    }
  }
  closeModal() {
    this.setState({ modalIsOpen: false });
  }

  handleEditForm(event) {
    event.preventDefault();
    this.state.selectedForEdit.title = this.refs.editTitle.value;
    const selected = clone(this.state.selected);
    const { key } = this.state.selectedForEdit;
    const Index = findIndex(selected, { key });
    if (Index !== -1) {
      selected[Index] = this.state.selectedForEdit;
    }
    this.makeChangesIntoStore(selected);
    this.setState({ selected, modalIsOpen: false });
  }

  handleTopValue(event) {
    if (event.target.checked === true) {
      this.state.selectedForEdit.onTop = event.target.checked;
    } else {
      delete this.state.selectedForEdit.onTop;
    }
  }
  handleRatingValue(event) {
    if (event.target.checked === true) {
      this.state.selectedForEdit.showRating = event.target.checked;
    } else {
      delete this.state.selectedForEdit.showRating;
    }
  }

  makeChangesIntoStore(selected) {
    const { buildData, post_type } = this.props;
    const Index = findIndex(buildData, { post_type });
    if (Index !== -1) {
      buildData[Index].selectedData = clone(selected);
    }
    BuilderAction.publishData(buildData);
  }
  render() {
    const { selected } = this.state;
    const itemKeys = [];
    selected.forEach((data) => {
      itemKeys.push(data.key);
    });
    const title = 'title' in this.state.selectedForEdit ? this.state.selectedForEdit.title : '';
    const onTop = 'onTop' in this.state.selectedForEdit ? this.state.selectedForEdit.onTop : false;
    const showRating = 'showRating' in this.state.selectedForEdit ? this.state.selectedForEdit.showRating : false;

    const showTaxonomyList = (item, index) => {
      return (
          <div key={index}>
            <label><input type="checkbox" value={item} defaultChecked={itemKeys.indexOf(item) !== -1 ? true : false} onChange={this.handleChangeTax.bind(this, item)} />{item}</label>
          </div>
        );
    };
    // const showPostKeyList = (item, index) => {
    //   return (
    //       <div key={index}>
    //         <label><input type="checkbox" value={item} defaultChecked={itemKeys.indexOf(item) !== -1 ? true : false} onChange={this.handleChangePostKey.bind(this, item)} />{item}</label>
    //       </div>
    //     );
    // };
    const showMetaKeyList = (item, index) => {
      return (
          <div key={index}>
            <label><input type="checkbox" value={item} defaultChecked={itemKeys.indexOf(item) !== -1 ? true : false} onChange={this.handleChangeMeta.bind(this, item)} />{item}</label>
          </div>
        );
    };

    const termData = [];
    for (const termKey in this.props.term_keys) {
      if (termKey) {
        termData.push({
          key: termKey,
          data: this.props.term_keys[termKey].linear,
        });
      }
    }

    const showTermData = (term, index) => {
      return (
        <Panel header={term.key} key={index} eventKey={index}>
          {term.data.map((single, sec) => {
            const mainkey = single.slug;
            return (<div key={'term-' + sec}>
              <label><input type="checkbox" value={mainkey} defaultChecked={itemKeys.indexOf(mainkey) !== -1 ? true : false} onChange={this.handleChangeTerm.bind(this, single, term.key)} />{single.value}</label>
            </div>);
          }) }
        </Panel>
      );
    };

    return (
      <div>
        <div className="col-md-6 pl0">
          <Accordion>
            <Panel header="Taxonomies" eventKey="1">
              { this.props.taxonomy_keys.map(showTaxonomyList) }
            </Panel>
            {
              termData.map(showTermData)
            }
            <Panel header="Meta" eventKey="2">
              { this.props.meta_keys.map(showMetaKeyList) }
            </Panel>
          </Accordion>
        </div>
        <div className="col-md-6 pr0">
           <AlikeSelectedList selected={this.state.selected} onSelected={this.handleSelected} />
        </div>


        <Modal isOpen={this.state.modalIsOpen} onRequestClose={this.closeModal} style={customStyles} >
          <form className="alike-modal-form" onSubmit={this.handleEditForm.bind(this)}>
            {
              // <pre>{JSON.stringify(this.state.selectedForEdit, null, 2)}</pre>
            }
            <div className="form-group">
              <input type="text" ref="editTitle" placeholder="Title" className="form-control" defaultValue={title} />
            </div>
            <div className="form-group alike-toggle">
              <label>
                <Toggle
                  defaultChecked={onTop}
                  onChange={this.handleTopValue}
                />
                <span className="alike-toggle-label">{ALIKE_ADMIN.LANG.SHOW_ON_TOP}</span>
              </label>
            </div>
            <div className="form-group alike-toggle">
              <label>
                <Toggle
                  defaultChecked={showRating}
                  onChange={this.handleRatingValue}
                />
                <span className="alike-toggle-label">{ALIKE_ADMIN.LANG.SHOW_RATING_BOX}</span>
              </label>
            </div>
            <div className="clearfix">
              <button className="btn btn-update">{ALIKE_ADMIN.LANG.UPDATE}</button>
            </div>
          </form>
        </Modal>


        <div className="clearfix"></div>
      </div>
    );
  }
}

export default AlikeEditPanel;
