import React, { createContext, useState, useEffect } from 'react'
import {API_BASE_URL, API_TOKEN} from '../constants.js';
import axios from "axios";

const SettingsContext = createContext();

export const SettingsProvider = ({ children }) => {
  const [settings, setSettings] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchSettings = async () => {
			axios
				.get(API_BASE_URL + "settings",{
					headers: {
						Authorization: `Bearer ${API_TOKEN}`
					}
				}) // Laravel API endpoint
				.then((response) => {
					setSettings(response.data); // Set the fetched data
					setLoading(false);
				})
				.catch((error) => {
					// setError(error.message);
					setLoading(false);
				});      
    };

    fetchSettings();
  }, []);

  if (loading) {
    return <div>Loading...</div>; // Show a loader while fetching settings
  }

  return (
    <SettingsContext.Provider value={settings}>
      {children}
    </SettingsContext.Provider>
  );
};

export const useSettings = () => React.useContext(SettingsContext);