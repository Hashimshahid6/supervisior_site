import React, { useEffect, useState } from "react";
import { API_BASE_URL } from "../constants.js";
import axios from "axios";
const Logout = async() => {
	// localStorage.removeItem("token"); // Remove the token
	const token = localStorage.getItem("token");
	const response = await axios.get(API_BASE_URL + "LogoutUser", {
		headers: { Authorization: `Bearer ${token}` },
	});
	// this.setState({ isAuthenticated: false }); // Update state
	window.location.href = `${process.env.PUBLIC_URL}/login`; // Redirect to login page
};

export default Logout;