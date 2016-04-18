require('../sass/main.sass');

import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, Link, hashHistory } from 'react-router';
import { combineReducers, createStore } from 'redux';
import { Provider } from 'react-redux';

import BackgroundPlasma from './components/BackgroundPlasma';
import AuthIndex from './containers/AuthIndex';

class Wakeau extends React.Component
{
  render ()
  {
    return (
      <div className="wakeau">
        <BackgroundPlasma
          resolution={[320, 180]} speed={.003} lod={0.0125}
          palette={["0c080a", "180b1b", "39191f", "481e27", "57232f", "783c39", "a0553b"]} />
        {this.props.children}
      </div>
    );
  } 
}


const store = createStore(() => null);

const routes = <Route component={Wakeau}>
  <Route path="/" component={AuthIndex} />
  <Route path="/resources" component={ResourceBrowser} />
  <Route path="/events" component={EventBrowser} />
</Route>;

ReactDOM.render(
  <Provider store={store}>
    <Router history={hashHistory}>{routes}</Router>
  </Provider>,
  document.getElementById('wakeau')
);