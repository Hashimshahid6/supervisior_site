import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import FeatureIcon from "../components/FeatureIcon";
import Funfact from "../components/Funfact";
import TeamMemberGrid from "../components/TeamMemberGrid";
import TestimonialSlider from "../components/TestimonialSlider";
import BrandLogoSlider from "../components/BrandLogoSlider";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";
// import ModalVideo from "react-modal-video";
const About = () => {
  // constructor() {
  //   super();
  //   this.state = {
  //     isOpen: false
  //   };
  //   this.openModal = this.openModal.bind(this);
  // }
  // openModal() {
  //   this.setState({ isOpen: true });
  // }
	const [isOpen, setIsOpen] = useState(false);

  const openModal = () => {
    setIsOpen(true);
  };
	const [bannerdata, setbannerData] = useState([]);
	const [data, setData] = useState([]);
	const [seconddata, setsecondData] = useState([]);
	const [thirddata, setthirdData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  useEffect(() => {
    axios
      .get(API_BASE_URL + "getbanner/1", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setbannerData(response.data); // Set the fetched data
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
		axios
      .get(API_BASE_URL + "aboutsectionone", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setData(response.data); // Set the fetched data
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
    axios
      .get(API_BASE_URL + "aboutsectiontwo", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setsecondData(response.data); // Set the fetched data
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
		axios
      .get(API_BASE_URL + "aboutsectionthree", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setthirdData(response.data); // Set the fetched data
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
  }, []);
  // render() {
    return (
      <div>
        {/* Navigation bar */}
        <NavBar />

        {/* breadcrumb */}
        {/*====================  breadcrumb area ====================*/}
        <div
          className="breadcrumb-area breadcrumb-bg"
          style={{
            backgroundImage: `url(${IMAGES_URL}images/banners/${bannerdata.image})`
          }}
        >
          <div className="container">
            <div className="row">
              <div className="col">
                <div className="page-banner text-center">
                  <h1>{data.heading}</h1>
                  <ul className="page-breadcrumb">
                    <li>
                      <a href="/">Home</a>
                    </li>
                    <li>{data.heading}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/*====================  End of breadcrumb area  ====================*/}

        <div className="page-wrapper section-space--inner--top--120">
          {/*About section start*/}
          <div className="about-section section-space--inner--bottom--120">
            <div className="container">
              <div className="row row-25 align-items-center">
                <div className="col-lg-6 col-12 mb-30">
                  <div className="about-image-two">
                    <img src={`${IMAGES_URL}images/sections/${data.image}`} alt="" />
                  </div>
                </div>
                <div className="col-lg-6 col-12 mb-30">
                  <div className="about-content-two">
                    <h3>{data.heading}</h3>
                    <h1>{data.subheading}</h1>
                    <p>
                      {data.content}
                    </p>
                    <a
                      href={data.button_link}
                      className="ht-btn--default ht-btn--default--dark-hover section-space--top--20"
                    >
                      {data.button_text}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {/*About section end*/}

          {/* Feature Icon */}
          <FeatureIcon background="grey-bg" />

          {/*About section start*/}
          <div className="about-section section-space--inner--120">
            <div className="container">
              <div className="about-wrapper row">
                <div className="col-sm-6 col-12 order-1 order-lg-2">
                  <div className="about-image about-image-1">
                    <img src={`${IMAGES_URL}images/sections/${seconddata.image}`} alt="" />
                  </div>
                </div>
                <div className="col-sm-6 col-12 order-2 order-lg-3">
                  <div className="about-image about-image-2">
                    <img src={`${IMAGES_URL}images/sections/${thirddata.image}`} alt="" />
                  </div>
                </div>
                <div className="col-lg-6 col-12 order-3 order-lg-1">
                  <div className="about-content about-content-1">
                    <h1>
                      {seconddata.heading}
                    </h1>
                    <p>
                      {seconddata.content}
                    </p>
                  </div>
                </div>
                <div className="col-lg-6 col-12 order-4">
                  <div className="about-content about-content-2">
                    <p>
                      {thirddata.content}
                    </p>
                    <a
                      href={`${process.env.PUBLIC_URL}/contact-us`}
                      className="ht-btn--default ht-btn--default--dark-hover section-space--top--20"
                    >
                      Contact us
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {/*About section end*/}

          {/* Fun fact */}
          {/* <Funfact /> */}

          {/* Team member */}
          {/* <TeamMemberGrid /> */}

          {/* Testimonial Slider */}
          <TestimonialSlider />

          {/* Brand logo */}
          <BrandLogoSlider background="" />
        </div>

        {/* Footer */}
        <Footer />

        {/* Mobile Menu */}
        <MobileMenu />
      </div>
    );
  // }
}

export default About;
