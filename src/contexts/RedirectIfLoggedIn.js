import React, { useState, useEffect } from "react";
import { Navigate } from "react-router-dom";
import { isLoggedIn } from "./isLoggedIn";

const RedirectIfLoggedIn = ({ children }) => {
  const [loading, setLoading] = useState(true); // To track loading state
  const [loggedIn, setLoggedIn] = useState(false); // To track login status

  useEffect(() => {
    const checkLoginStatus = async () => {
      try {
        const status = await isLoggedIn();
        setLoggedIn(status);
      } catch (error) {
        console.error("Error checking login status:", error);
      } finally {
        setLoading(false); // Stop loading once the status is checked
      }
    };

    checkLoginStatus();
  }, []);

  if (loading) {
    // While checking login status, you can show a loader or nothing
    return null;
  }

  return loggedIn ? <Navigate to={`${process.env.PUBLIC_URL}/pricing`} replace /> : children;
};

export default RedirectIfLoggedIn;