import { API_BASE_URL } from "../constants.js";
import axios from "axios";
export const isLoggedIn = async() => {
    const token = localStorage.getItem("login_token");
		// return !!token; // Returns true if token exists, false otherwise
		const response = await axios.get(API_BASE_URL + "isLoggedIn", {
			headers: { Authorization: `Bearer ${token}` },
		});
		if(response.status === 200) {
			return true;
		}
		return false;
};