import React from 'react';
import SettingsContext from "./SettingsContext";

const withSettings = (WrappedComponent) => {
	return (props) => (
    <SettingsContext.Consumer>
      {(settings) => <WrappedComponent {...props} settings={settings} />}
    </SettingsContext.Consumer>
  );
}

export default withSettings;