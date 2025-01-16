import React from "react";
import axios from "axios";
import { API_BASE_URL } from "../constants";

// const Logout = async () => {
//     try {
//         const token = localStorage.getItem("token");

//         if (!token) {
//             console.error("No token found. Redirecting to login.");
//             window.location.href = `${process.env.PUBLIC_URL}/login`;
//             return;
//         }

//         // Send logout request
//         const response = await axios.get(`${API_BASE_URL}/LogoutUser`, {
//             headers: { Authorization: `Bearer ${token}` },
//         });

//         if (response.status === 200) {
//             console.log("Logout successful");
//             localStorage.removeItem("token"); // Remove token
//             window.location.href = `${process.env.PUBLIC_URL}/login`; // Redirect
//         }
//     } catch (error) {
//         console.error("Logout failed:", error.message);

//         // Handle specific error codes
//         if (error.response?.status === 401) {
//             console.error("Unauthorized. Redirecting to login.");
//             localStorage.removeItem("token");
//             window.location.href = `${process.env.PUBLIC_URL}/login`;
//         } else {
//             console.error("An unexpected error occurred:", error);
//         }
//     }
// };
const Logout = async () => {
    try {
      const token = localStorage.getItem("login_token");
  
      if (!token) {
        console.error("No token found. Redirecting to login.");
        window.location.href = `${process.env.PUBLIC_URL}/login`;
        return;
      }
  
      // Send logout request
      await axios.get(`${API_BASE_URL}/LogoutUser`, {
        headers: { Authorization: `Bearer ${token}` },
      });
  
      localStorage.removeItem("login_token"); // Clear token
      localStorage.removeItem("user"); // Clear user details
      window.location.href = `${process.env.PUBLIC_URL}/login`; // Redirect
    } catch (error) {
      console.error("Logout failed:", error.message);
      localStorage.removeItem("login_token"); // Ensure logout
      window.location.href = `${process.env.PUBLIC_URL}/login`;
    }
  };  

export default Logout;