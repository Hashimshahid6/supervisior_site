import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import withSettings from "../contexts/withSettings";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const Contact = ({ settings }) => {
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
                <h1>{bannerData?.title || "Contact Us"}</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>Contact</li>
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
            <div className="row section-space--bottom--50">
              <div className="col">
                <div className="contact-map">
                  <iframe
                    title="Google Map"
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d392436.93004030554!2d-105.13838587646829!3d39.7265847007123!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1558429398879!5m2!1sen!2sbd"
                    allowFullScreen
                  ></iframe>
                </div>
              </div>
            </div>

            {/* Contact Information */}
            <div className="row">
              <div className="col-lg-4 col-12">
                <div className="contact-information">
                  <h3>Contact Information</h3>
                  <ul>
                    <li>
                      <span className="icon">
                        <i className="ion-android-map"></i>
                      </span>
                      <span className="text">{settings.site_address}</span>
                    </li>
                    <li>
                      <span className="icon">
                        <i className="ion-ios-telephone-outline"></i>
                      </span>
                      <span className="text">
                        <a href={`tel:${settings.site_phone}`}>
                          {settings.site_phone}
                        </a>
                        {settings.site_phone2 && (
                          <a href={`tel:${settings.site_phone2}`}>
                            {settings.site_phone2}
                          </a>
                        )}
                      </span>
                    </li>
                    <li>
                      <span className="icon">
                        <i className="ion-ios-email-outline"></i>
                      </span>
                      <span className="text">
                        <a href={`mailto:${settings.site_email}`}>
                          {settings.site_email}
                        </a>
                        {settings.site_email2 && (
                          <a href={`mailto:${settings.site_email2}`}>
                            {settings.site_email2}
                          </a>
                        )}
                      </span>
                    </li>
                  </ul>
                </div>
              </div>

              {/* Contact Form */}
              <div className="col-lg-8 col-12">
                <div className="contact-form">
                  <h3>Leave Your Message</h3>
                  <form id="contact-form">
                    <div className="row row-10">
                      <div className="col-md-6 col-12 section-space--bottom--20">
                        <input
                          name="con_name"
                          type="text"
                          placeholder="Your Name"
                        />
                      </div>
                      <div className="col-md-6 col-12 section-space--bottom--20">
                        <input
                          name="con_email"
                          type="email"
                          placeholder="Your Email"
                        />
                      </div>
                      <div className="col-12">
                        <textarea
                          name="con_message"
                          placeholder="Your Message"
                        ></textarea>
                      </div>
                      <div className="col-12">
                        <button>Send Message</button>
                      </div>
                    </div>
                  </form>
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

export default withSettings(Contact);