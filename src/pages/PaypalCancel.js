import React, { useEffect, useState } from "react";
import { useLocation } from "react-router-dom";
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import withSettings from "../contexts/withSettings";
import { IMAGES_URL, BASE_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const PaypalCancel = ({ settings }) => {
	const [bannerData, setBannerData] = useState(null);
	const [pageloading, setpageLoading] = useState(true);
	const [error, setError] = useState(null);
	const location = useLocation();
	// Fetch banner data
  useEffect(() => {
    const fetchBanner = async () => {
      try {
        const response = await axios.get(API_BASE_URL + "getbanner/4", {
          headers: { Authorization: `Bearer ${API_TOKEN}` },
        });
        setBannerData(response.data);
      } catch (err) {
        setError("Failed to load banner data");
      } finally {
        setpageLoading(false);
      }
    };
		const doPaypalCancel = async() => {
			// Extract search params from URL
			const queryParams = new URLSearchParams(location.search);
			const paypal_token = queryParams.get("token");
			const user_token = localStorage.getItem("login_token");
			// return !!token; // Returns true if token exists, false otherwise
			const response = await axios.get(API_BASE_URL + "paypalCancelled", {
				headers: { Authorization: `Bearer ${user_token}` },
				params: { paypal_token: paypal_token }
			});
			if(response.status === 200) {
				console.log("HERE")
				// return true;
			}
		} // paypal_cancel
    fetchBanner();
    doPaypalCancel();
  }, []);

  if (pageloading) {
    return <div className="loader"></div>; // Show a loader while fetching settings
  };
  if (error) return <p>Error: {error}</p>;
	return (
    <div>
      {/* Navigation Bar */}
      <NavBar />

      {/* Breadcrumb */}
      <div
        className="breadcrumb-area breadcrumb-bg"
        style={{
          backgroundImage: `url(${IMAGES_URL}images/banners/${bannerData?.image})`,
        }}
      >
        <div className="container">
          <div className="row">
            <div className="col">
              <div className="page-banner text-center">
                <h1>{bannerData?.title || "Paypal Cancelled"}</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>Paypal Cancelled</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Contact Section */}
      <div className="page-wrapper section-space--inner--60">
        <div className="contact-section">
          <div className="container">
            
            {/* Contact Information */}
            <div className="row">
              
              {/* Contact Form */}
              <div className="col-12">
                <div className="contact-form">
                  <h3>Payment Cancelled</h3>
									<p>Your Payment has been Cancelled.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Footer */}
      <Footer />

      {/* Mobile Menu */}
      <MobileMenu />
    </div>
  );
};

export default withSettings(PaypalCancel);