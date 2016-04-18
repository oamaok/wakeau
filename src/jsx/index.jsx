require('../sass/main.sass');

import React from 'react';
import ReactDOM from 'react-dom';
import { Router, Route, Link, hashHistory } from 'react-router';
import { combineReducers, createStore } from 'redux';
import { Provider } from 'react-redux';

import BackgroundPlasma from './components/BackgroundPlasma';
import AuthIndex from './containers/AuthIndex';

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