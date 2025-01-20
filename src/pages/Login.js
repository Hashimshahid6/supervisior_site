import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import withSettings from "../contexts/withSettings";
import { IMAGES_URL, BASE_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const Login = ({ settings }) => {
	const [bannerData, setBannerData] = useState(null);
	const [pageloading, setpageLoading] = useState(true);
	const [error, setError] = useState(null);
	// FORGOT PASSWORD
	const [isForgotPasswordOpen, setIsForgotPasswordOpen] = useState(false);
  const [email, setEmail] = useState("");
  const [loading, setLoading] = useState(false);
  const [forgotmessage, setForgotMessage] = useState("");

  const handleForgotPassword = async (e) => {
    e.preventDefault();
    setLoading(true);
    setForgotMessage("");

		const forgoterrormsgdiv = document.querySelector(".forgoterrormsg");
    try {
      const response = await axios.post(`${API_BASE_URL}forgotPassword`, {
        email,
      }, {
        headers: { Authorization: `Bearer ${API_TOKEN}` }
				});
      setForgotMessage("Password reset email sent. Please check your inbox.");
			// document.querySelector(".forgotsuccessmsg").setHTMLUnsafe("Password reset email sent. Please check your inbox.");
			document.querySelector(".forgotsuccessmsg").classList.remove("d-none");
    } catch (error) {
			forgoterrormsgdiv.textContent = error.response.data.message;
			// document.querySelector(".forgoterrormsg").innerHTML("Error sending password reset email. Please try again.");
			document.querySelector(".forgoterrormsg").classList.remove("d-none");
      setForgotMessage("Error sending password reset email. Please try again.");
    } finally {
      setLoading(false);
			setTimeout(() => {
        setIsForgotPasswordOpen(false); // Close modal after submission
      }, 3000); // 3 seconds delay
    }
  };
	const handleClose = () => {
    setIsForgotPasswordOpen(false); // Close the modal
    // setSelectedForm(null); // Clear the form reference
  };
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
		document.querySelector(".errormsg").classList.add("d-none");
    try {
			const response = await axios.post(
        API_BASE_URL+"LoginUser",
        formData, {
        headers: { Authorization: `Bearer ${API_TOKEN}` }
				}
      );
			if(response.status === 200) {
      	// console.log("Form Submitted Successfully",response.data);
				// Save token to localStorage or cookies
				localStorage.setItem("login_token", response.data.access_token);
				// console.log(response.data.user)
				// Optionally store user details
				const user_loggedin = response.data.user;
				localStorage.setItem("user", JSON.stringify(response.data.user));
      	setSubmitted(true);
				if(user_loggedin.role == 'Admin'){
					window.location.href=`${process.env.PUBLIC_URL}/admin/dashboard`;
				}else if(user_loggedin.role == 'Company'){
					if(user_loggedin.package_id == '0' || user_loggedin.package_id == null){
						window.location.href=`${process.env.PUBLIC_URL}/pricing`;
					}else{
						window.location.href=`${process.env.PUBLIC_URL}/admin/projects`;
					}
				}else if(user_loggedin.role == 'Employee'){
					window.location.href=`${process.env.PUBLIC_URL}/admin/projects`;
				}
			}else{
				alert("Error in Form Submission");
			}
    } catch(error) {
			console.log(error.response.data.message)
			const errorMessages = error.response.data.message;
			let errorMessageHtml = error.response.data.message;
			// for (const key in errorMessages) {
			// 	if (errorMessages.hasOwnProperty(key)) {
			// 		errorMessageHtml += `<p>${errorMessages[key]}</p>`;
			// 	}
			// }
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
                <h1>{bannerData?.title || "Login"}</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>Login</li>
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
                  <h3>Login Now</h3>
									<p>Not Registered? <a href={`${process.env.PUBLIC_URL}/register`} style={{ color: '#007bff' }}>Click Here to Register</a></p>
									<div className="alert alert-danger errormsg d-none"></div>
									{ !submitted ?
                  <form id="contact-form" onSubmit={handleSubmit}>
                    <div className="row row-10">
                      <div className="col-12 section-space--bottom--20">
                        <input
                          className="form-control"
                          name="email"
                          type="email"
                          placeholder="Email"
													value={formData.email}
													required
													onChange={handleChange}
                        />
                      </div>	
											<div className="col-12 section-space--bottom--20">
                        <input
                          className="form-control"
                          name="password"
                          type="password"
                          placeholder="Password"
													value={formData.password}
													required
													onChange={handleChange}
                        />
                      </div>	
                      <div className="col-12">
                        <button className="btn btn-primary">Login Now</button>
											<p>Forgot Password? <a onClick={() => setIsForgotPasswordOpen(true)} style={{ color: '#007bff', marginTop:'20px' }}> Click Here to Reset</a>
												</p>									                    
                      </div>
                    </div>
                  </form>
									: <div className="alert alert-success">Logged In Successfully.</div>}
                </div>
              </div>
            </div>
          </div>
        </div>
				{isForgotPasswordOpen && (
        <div
						className="modal fade show"
						style={{ display: "block", backgroundColor: "rgba(0, 0, 0, 0.5)" }}
						role="dialog"
						aria-labelledby="modalLabel"
						aria-hidden="true"
					>
					<div className="modal-dialog" role="document">

						<div className="modal-content">
							<div className="modal-header">
            <h5 className="modal-title" id="modalLabel">
              Reset Password
            </h5>
            <button
              type="button"
              className="btn-close"
              onClick={handleClose}
              aria-label="Close"
            ></button>
          </div>
						<div className="modal-body">	
							<form onSubmit={handleForgotPassword}>
								<div>
									<div className="alert alert-danger forgoterrormsg d-none">Error sending password reset email. Please try again later.</div>
									<div className="alert alert-success forgotsuccessmsg d-none">Password reset email sent. Please check your inbox.</div>
									<label>Email:</label>
									<input
										type="email"
										value={email}
										onChange={(e) => setEmail(e.target.value)}
										className="form-control"
										placeholder="Enter your Email here"
										required
									/>
								</div>
								<div className="mt-2 text-center">
									<button type="submit" className="btn btn-success" style={{marginRight:"10px"}} disabled={loading}>
										{loading ? "Sending..." : "Submit"}
									</button>
									<button type="button" className="btn btn-primary ml-2" onClick={() => setIsForgotPasswordOpen(false)}>
										Cancel
									</button>
								</div>
							</form>
						</div>
						<div className="modal-footer">
							&nbsp;
						</div>
							{/* {message && <p>{message}</p>} */}
						</div>
					</div> {/* end modal dialog */}
        </div>
      )}
      </div>

      {/* Footer */}
      <Footer />

      {/* Mobile Menu */}
      <MobileMenu />
    </div>
  );
};

export default withSettings(Login);