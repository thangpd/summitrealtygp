import React from 'react';

class AlikeSelectedList extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      isOpen: false,
      panelType: null,
    };
    this.handleEditPanel = this.handleEditPanel.bind(this);
  }

  handleEditPanel(e) {
    this.props.onSelected(e);
  }
  render() {
    const list = (item, index) => {
      return (
        <li key={index} data-key={item.key}>
          <div className="alike-selected-move"><i className="icon-options icons"></i></div>
          <div className="alike-selected-title">
            <h3>{item.title}</h3>
            <h4>{item.key}</h4>
          </div>
          <div className="alike-selected-edit" onClick={this.handleEditPanel.bind(this, item)}><i className="icon-pencil icons"></i></div>
          <div className="clearfix"></div>
        </li>
      );
    };
    return (
      <div>
        <ul className="alike-selected-list">
          {this.props.selected.map(list)}
        </ul>
      </div>
    );
  }
}

AlikeSelectedList.propTypes = {
  'selected': React.PropTypes.array,
  'onSelected': React.PropTypes.func,
};

export default AlikeSelectedList;
