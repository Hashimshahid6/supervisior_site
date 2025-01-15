import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";
import {isLoggedIn} from "../contexts/isLoggedIn";
import Modal from "../components/Modal";
const Pricing = () => {
  const [bannerData, setBannerData] = useState(null);
  const [pageloading, setpageLoading] = useState(true);
  const [error, setError] = useState(null);
	const [isModalOpen, setIsModalOpen] = useState(false);
	const [selectedForm, setSelectedForm] = useState(null); 
	const handleFormSubmit = (e) => {
    e.preventDefault();
		setSelectedForm(e.target);
    setIsModalOpen(true); // Open modal on form submission
  };

  const handleClose = () => {
    setIsModalOpen(false); // Close the modal
    setSelectedForm(null); // Clear the form reference
  };
	const [loading, setLoading] = useState(false);
  const handleConfirm = async() => {
		setLoading(true); // Show loader
		if (selectedForm) {
      const formData = new FormData(selectedForm); // Use the stored form reference
      console.log("FormData values:");
      for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
      }
			setIsModalOpen(false);
		// Get the form element
			// const form = e.target;
			// Create FormData object from the form
			// const formData = new FormData(form);
			// console.log("ddd", JSON.stringify(formData));
			try {
				const user_token = localStorage.getItem('login_token');
				const response = await axios.post(
					API_BASE_URL+"createPaymentIntent",
					formData, {
					headers: { Authorization: `Bearer ${user_token}` }
					}
				);
				// console.log("Form Submitted Successfully",response);
				if(response.data.status === "PAYER_ACTION_REQUIRED"){
					response.data.paypal_response.links.map((link) => {
						if(link.rel === "payer-action"){
							window.location.href = link.href;
						}
					});
				}
				setSubmitted(true);
			} catch {
				console.log("Error in Form Submission");
			}
		}
    console.log("Form submitted!"); // Replace with your submission logic
  };
	const [submitted, setSubmitted] = useState(false);
	const [loggedIn, setLoggedIn] = useState(false);
  // Fetch banner and service data
  useEffect(() => {
    const fetchData = async () => {
      try {
        const [bannerResponse] = await Promise.all([
          axios.get(API_BASE_URL + "getbanner/4", {
            headers: { Authorization: `Bearer ${API_TOKEN}` },
          }),
        ]);

        setBannerData(bannerResponse.data);
      } catch (err) {
        setError(err.message);
      } finally {
        setpageLoading(false);
      }
    };
    fetchData();
		const checkLoginStatus = async () => {
      const loggedInStatus = await isLoggedIn();
      setLoggedIn(loggedInStatus);
    };

    checkLoginStatus();
  }, []);
	
  if (pageloading) {
    return <div className="loader"></div>;
  }
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
                <h1>{bannerData?.title || "Pricing"}</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>Pricing</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      {/*Projects section start*/}
      <div className="page-wrapper section-space--inner--60">
        <div className="project-section">
          <div className="container">
            <div className="row">
              <div className="col-lg-12">
                <div className="project-item-wrapper">
                  <div className="row text-center">
                    <div className="col-lg-4 col-sm-6 col-12 section-space--bottom--30">
                      <div className="service-grid-item service-grid-item--style2">
                        <div className="service-grid-item__content"
                        style={{minHeight:"440px"}}>
                          <h3 className="title">
                            Bronze Membership
                          </h3>
                          <p className="subtitle">
                            Bronze Package includes 3 Projects at one time
                            available. The specific services included in each
                            project encompass basic supervision and management
                            tasks.
                          </p>
                          <p className="subtitle"><small>£</small><span style={{ fontSize: '2em' }}>35</span> Every month</p>
                          <p className="subtitle">90 day free trial</p>
                          { loggedIn ? 
														<form onSubmit={handleFormSubmit}>
															<input type="hidden" name="package" value="1" />
															<input type="hidden" name="amount" value="5" />
															<input type="hidden" name="currency" value="GBP" />
															<button type="submit" className="ht-btn ht-btn--round" disabled={loading}>
																{loading ? "Processing..." : "START FREE TRIAL"}
																</button>
														</form>
														: 
														<a href={`${process.env.PUBLIC_URL}/login`} className="ht-btn ht-btn--round">START FREE TRIAL</a> 
													}
													{/* <a href="/supervisor_build/login" className="ht-btn ht-btn--round">
                            START FREE TRIAL
                          </a> */}
                        </div>
                      </div>
                    </div>
                    <div className="col-lg-4 col-sm-6 col-12 section-space--bottom--30">
                      <div className="service-grid-item service-grid-item--style2">
                        <div className="service-grid-item__content"
                        style={{minHeight:"440px"}}>
                          <h3 className="title">
                            Silver Package
                          </h3>
                          <p className="subtitle">
                            Silver Package includes the management of 6 projects
                            of one time. This feature is tailored to overseeing
                            more in-depth construction sites to help efficiency,
                            progress report and on site To Do Lists.
                          </p>
                          <p className="subtitle"><small>£</small><span style={{ fontSize: '2em' }}>55</span> Every month</p>
                          <p className="subtitle">90 day free trial</p>
													{ loggedIn ? 
														<form onSubmit={handleFormSubmit}>
															<input type="hidden" name="package" value="2" />
															<input type="hidden" name="amount" value="5" />
															<input type="hidden" name="currency" value="GBP" />
															<button type="submit" className="ht-btn ht-btn--round" disabled={loading}>
																{loading ? "Processing..." : "START FREE TRIAL"}
															</button>
														</form>
														: 
														<a href={`${process.env.PUBLIC_URL}/login`} className="ht-btn ht-btn--round">START FREE TRIAL</a> 
													}
                          {/* <a href="/supervisor_build/login" className="ht-btn ht-btn--round">
                            START FREE TRIAL
                          </a> */}
                        </div>
                      </div>
                    </div>
                    <div className="col-lg-4 col-sm-6 col-12 section-space--bottom--30">
                      <div className="service-grid-item service-grid-item--style2">
                        <div className="service-grid-item__content"
                        style={{minHeight:"440px"}}>
                          <h3 className="title">
                            Gold Package
                          </h3>
                          <p className="subtitle">
                            Gold Package includes 9 Projects at one time. This
                            package is designed for construction companies with
                            multiple large sites running at one time to keep
                            on-top of deliveries , check sheets and targets are
                            met daily.
                          </p>
                          <p className="subtitle"><small>£</small><span style={{ fontSize: '1.5em' }}>75</span> Every month</p>
                          <p className="subtitle">90 day free trial</p>
													{ loggedIn ? 
														<form onSubmit={handleFormSubmit}>
															<input type="hidden" name="package" value="1" />
															<input type="hidden" name="amount" value="5" />
															<input type="hidden" name="currency" value="GBP" />
															<button type="submit" className="ht-btn ht-btn--round" disabled={loading}>
																{loading ? "Processing..." : "START FREE TRIAL"}
															</button>
														</form>
														: 
														<a href={`${process.env.PUBLIC_URL}/login`} className="ht-btn ht-btn--round">START FREE TRIAL</a> 
													}
                          {/* <a href="/supervisor_build/login" className="ht-btn ht-btn--round">
                            START FREE TRIAL
                          </a> */}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
					<Modal
						show={isModalOpen}
						onClose={handleClose}
						onConfirm={handleConfirm}
						title="Payment Confirmation"
						message="You will be charged £5 for the free trial, that will be refunded later. Do you want to continue?"
					/>
        </div>
        {/*Projects section end*/}
      </div>

      {/* Footer */}
      <Footer />

      {/* Mobile Menu */}
      <MobileMenu />
    </div>
  );
};

export default Pricing;
