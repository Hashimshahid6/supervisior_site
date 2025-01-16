import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import withSettings from "../contexts/withSettings";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const Register = ({ settings }) => {
	const [bannerData, setBannerData] = useState(null);
	const [pageloading, setpageLoading] = useState(true);
	const [error, setError] = useState(null);
	// Fetch banner data
  useEffect(() => {
    const fetchBanner = async () => {
      try {
        const response = await axios.get(API_BASE_URL + "getbanner/3", {
          headers: { Authorization: `Bearer ${API_TOKEN}` },
        });
        setBannerData(response.data);
      } catch (err) {
        setError("Failed to load banner data");
      } finally {
        setpageLoading(false);
      }
    };
    fetchBanner();
  }, []);

	const [formData, setFormData] = useState({
    name: "",
    email: "",
    message: "",
  });
  const [submitted, setSubmitted] = useState(false);
  // Handle form input changes
  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value,
    });
  };
  //
  const handleSubmit = async(e) => {
    e.preventDefault();
    // console.log("ddd", JSON.stringify(formData));
    try {
			if(formData.password !== formData.password_confirmation) {
				// alert("Passwords do not match");
				document.querySelector(".errormsg").innerHTML = "Passwords do not match";
				document.querySelector(".errormsg").classList.remove("d-none");
				return;				
			}
      const response = await axios.post(
        API_BASE_URL+"RegisterUser",
        formData, {
        headers: { Authorization: `Bearer ${API_TOKEN}` }
				}
      );
			if(response.status === 200) {
      // console.log("Form Submitted Successfully");
      	setSubmitted(true);
				window.location.href = "/supervisor_build/login";
			}else{
				alert("Error in Form Submission");
			}
    } catch(error) {
			console.log(error.response.data.errors)
			const errorMessages = error.response.data.errors;
			let errorMessageHtml = "";
			for (const key in errorMessages) {
				if (errorMessages.hasOwnProperty(key)) {
					errorMessageHtml += `<p>${errorMessages[key]}</p>`;
				}
			}
			document.querySelector(".errormsg").innerHTML = errorMessageHtml;
			document.querySelector(".errormsg").classList.remove("d-none");
			// document.querySelector(".errormsg").innerText = error.response.data.message || "Error in Form Submission";
      // console.log("Error in Form Submission", error.response.data.message);
    }
  }; //

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
                <h1>{bannerData?.title || "Register"}</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>Register</li>
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
            <div className="row justify-content-center">
              {/* Contact Form */}
              <div className="col-md-6 col-12">
                <div className="contact-form text-center">
                  <h3>Register Now</h3>
									<p>Already registered? <a href={`${process.env.PUBLIC_URL}/login`} style={{ color: "blue" }}>Click Here to Login</a></p>
									<div className="alert alert-danger errormsg d-none"></div>
									{ !submitted ?
                  <form id="contact-form" onSubmit={handleSubmit}>
                    <div className="row row-10">
                      <div className="col-12 section-space--bottom--20">
                        <input
                          name="name"
                          type="text"
                          placeholder="Your Name"
													value={formData.name}
													required
													onChange={handleChange}
                        />
                      </div>
                      <div className="col-12 section-space--bottom--20">
                        <input
                          name="email"
                          type="email"
                          placeholder="Your Email"
													value={formData.email}
													required
													onChange={handleChange}
                        />
                      </div>
											<div className="col-12 section-space--bottom--20">
                        <input
                          name="password"
                          type="password"
                          placeholder="Password"
													value={formData.password}
													required
													onChange={handleChange}
                        />
                      </div>
											<div className="col-12 section-space--bottom--20">
                        <input
                          name="password_confirmation"
                          type="password"
                          placeholder="Confirm Password"
													value={formData.password_confirmation}
													required
													onChange={handleChange}
                        />
                      </div>                      
                      <div className="col-12">
                        <button>Register Now</button>
                      </div>
                    </div>
                  </form>
									: <div className="alert alert-success">Registered Successfully. Please Login to continue.</div>}
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

export default withSettings(Register);