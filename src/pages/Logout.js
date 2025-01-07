import React, { useEffect, useState } from "react";

const Logout = () => {
	localStorage.removeItem("token"); // Remove the token
	// this.setState({ isAuthenticated: false }); // Update state
	window.location.href = "/login"; // Redirect to login page
	
};

export default Logout;