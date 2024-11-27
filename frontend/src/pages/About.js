import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import FeatureIcon from "../components/FeatureIcon";
import TestimonialSlider from "../components/TestimonialSlider";
import BrandLogoSlider from "../components/BrandLogoSlider";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const About = () => {
  const [bannerdata, setBannerData] = useState(null);
  const [data, setData] = useState(null);
  const [seconddata, setSecondData] = useState(null);
  const [thirddata, setThirdData] = useState(null);
  const [pageloading, setpageLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    // Fetch all data with Promise.all
    Promise.all([
      axios.get(`${API_BASE_URL}getbanner/1`, {
        headers: { Authorization: `Bearer ${API_TOKEN}` },
      }),
      axios.get(`${API_BASE_URL}aboutsectionone`, {
        headers: { Authorization: `Bearer ${API_TOKEN}` },
      }),
      axios.get(`${API_BASE_URL}aboutsectiontwo`, {
        headers: { Authorization: `Bearer ${API_TOKEN}` },
      }),
      axios.get(`${API_BASE_URL}aboutsectionthree`, {
        headers: { Authorization: `Bearer ${API_TOKEN}` },
      }),
    ])
      .then(([bannerRes, sectionOneRes, sectionTwoRes, sectionThreeRes]) => {
        setBannerData(bannerRes.data);
        setData(sectionOneRes.data);
        setSecondData(sectionTwoRes.data);
        setThirdData(sectionThreeRes.data);
        setpageLoading(false);
      })
      .catch((err) => {
        setError(err.message);
        setpageLoading(false);
      });
  }, []);

  if (pageloading) {
    return <div className="loader"></div>; // Show a loader while fetching settings
  };
  if (error) return <p>Error: {error}</p>;

  return (
    <div>
      {/* Navigation Bar */}
      <NavBar />

      {/* Breadcrumb Area */}
      <div
        className="breadcrumb-area breadcrumb-bg"
        style={{
          backgroundImage: `url(${IMAGES_URL}images/banners/${bannerdata?.image})`,
        }}
      >
        <div className="container">
          <div className="row">
            <div className="col">
              <div className="page-banner text-center">
                <h1>{bannerdata?.heading || 'About Us'}</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>{bannerdata?.subheading || 'About Us'}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div className="page-wrapper section-space--bottom--60">
        {/* About Section 1 */}
        <div className="about-section section-space--inner--60">
          <div className="container">
            <div className="row row-25 align-items-center">
              <div className="col-lg-6 col-12 mb-30">
                <div className="about-image-two">
                  <img
                  loading="lazy"
                    src={`${IMAGES_URL}images/sections/${data?.image}`}
                    alt={data?.heading || "About Section"}
                  />
                </div>
              </div>
              <div className="col-lg-6 col-12 mb-30">
                <div className="about-content-two">
                  <h3>{data?.heading}</h3>
                  <h1>{data?.subheading}</h1>
                  <p style={{fontSize:"18px"}}>{data?.content}</p>
                  <a
                    href={data?.button_link || "#"}
                    className="ht-btn--default ht-btn--default--dark-hover section-space--top--20"
                  >
                    {data?.button_text}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div className="about-section section-space--inner--60 grey-bg">
          <div className="container">
            <div className="row row-25 align-items-center">
              <div className="col-lg-6 col-12 mb-30">
                <div className="about-content-two">
                  <h3>{seconddata?.heading}</h3>
                  <h1>{seconddata?.subheading}</h1>
                  <p style={{fontSize:"18px"}}>{seconddata?.content}</p>
                </div>
              </div>
              <div className="col-lg-6 col-12 mb-30">
                <div className="about-image-two">
                  <img
                  loading="lazy"
                    src={`${IMAGES_URL}images/sections/${seconddata?.image}`}
                    alt={seconddata?.heading || "About Section"}
                  />
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* Feature Icon */}
        <FeatureIcon />

        {/* Testimonial Slider */}
        <TestimonialSlider />

        {/* Brand Logo Slider */}
        <BrandLogoSlider />
      </div>

      {/* Footer */}
      <Footer />

      {/* Mobile Menu */}
      <MobileMenu />
    </div>
  );
};

export default About;
