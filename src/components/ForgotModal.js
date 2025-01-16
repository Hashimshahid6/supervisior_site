import React, { useEffect, useState } from "react";
import { IMAGES_URL, BASE_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const ForgotModal = ({ show, onClose, title, message }) => {
  if (!show) return null; // Hide modal if `show` is false
	const [forgotformData, setForgotFormData] = useState({
		email: "",
	});
	const handleForgotChange = (e) => {
    const { name, value } = e.target;
    setForgotFormData({
      ...forgotformData,
      [name]: value,
    });
  };
	// Handle Forgot Password
	const handleForgotSubmit = async(e) => {
		e.preventDefault();
		// console.log("ddd", JSON.stringify(forgotformData));
		document.querySelector(".errormsg").classList.add("d-none");
		try {
			const response = await axios.post(BASE_URL + "forgotpassword", JSON.stringify(forgotformData), {
				headers: {
					"Content-Type": "application/json",
				},
			});
			if (response.status === 200) {
				// console.log("Forgot Password Response", response.data);
				onClose();
				// showModal();
			} else {
				document.querySelector(".errormsg").classList.remove("d-none");
			}
		} catch (error) {
			console.error("Error:", error);
		}
	} //
  return (
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
              {title}
            </h5>
            <button
              type="button"
              className="btn-close"
              onClick={onClose}
              aria-label="Close"
            ></button>
          </div>
          <div className="modal-body">
						<p>{message}</p>
						<form id="forgot-form" onSubmit={handleForgotSubmit}>
							<div className="row row-10">
								<div className="col-12 section-space--bottom--20">
									<input
										className="form-control"
										name="email"
										type="email"
										placeholder="Enter Your Email"
										value=""
										required
										onChange={handleForgotChange}
									/>
								</div>										
								<div className="col-12">
									<button className="btn btn-primary">Reset Password</button>
								</div>																	                    
							</div>
						</form>
					</div>
          <div className="modal-footer">
            <button type="button" className="btn btn-secondary" onClick={onClose}>
              Cancel
            </button>
            <button type="button" className="btn btn-primary" onClick={handleForgotSubmit}>
              Reset
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ForgotModal;