import React, { PropTypes } from 'react';

const LoginForm = (onLogin, isBusy, displayError) => (
  <form className={isBusy ? 'login busy' : 'login'} ref="form" method="post" onSubmit={onSubmit}>
    <div className="header">wakeau</div>
    <div className={displayError ? 'error active' : 'error'}>login failed.</div>
    <div className="field">
      <label for="username">username</label>
      <input id="username" ref="username" type="text" disabled={isBusy} />
    </div>
    <div className="field">
      <label for="password">password</label>
      <input id="password" ref="password" type="password" disabled={isBusy} />
    </div>
    <div className="field">
      <input type="submit" value="login" disabled={isBusy} />
    </div>
  </form>
);

LoginForm.propTypes = {
  onLogin: PropTypes.func.isRequired,
  isBusy: PropTypes.bool.isRequired,
  displayError: PropTypes.bool.isRequired,
};

export default LoginForm;