import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import BrandLogoSlider from "../components/BrandLogoSlider";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";
const Services = () => {
  // render() {
  const [servicedata, setserviceData] = useState([]);
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  useEffect(() => {
    axios
      .get(API_BASE_URL + "allservices", {
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
      .get(API_BASE_URL + "getServiceSection", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setserviceData(response.servicedata); // Set the fetched data
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
  }, []); // Empty array means effect will only run on mount

  let Datalist = data.map((val, i) => {
    return (
      <div
        className="col-lg-4 col-md-6 col-12 section-space--bottom--30"
        key={i}
      >
        <div className="service-grid-item">
          <div className="service-grid-item__image">
            <div className="service-grid-item__image-wrapper">
              <a href={`/ServiceDetail/${val.id}`}>
                <img
                  src={`${IMAGES_URL}images/services/${val.bgImage}`}
                  className="img-fluid"
                  alt="Service Grid"
                  style={{
                    width: "480px",
                    height: "270px",
                    objectFit: "cover",
                  }}
                />
              </a>
            </div>
            <div className="icon">
              <img
                src={`${IMAGES_URL}images/services/${val.icon}`}
                className="img-fluid"
                alt={val.title}
                style={{
                  width: "40px",
                  height: "40px",
                  objectFit: "cover",
                  filter: "invert(1) brightness(2)",
                }}
              />
            </div>
          </div>
          <div className="service-grid-item__content">
            <h3 className="title">
              <a href={`/ServiceDetail/${val.id}`}>{val.title}</a>
            </h3>
            <p className="subtitle">{val.description}</p>
            <a href={`/ServiceDetail/${val.id}`} className="see-more-link">
              SEE MORE
            </a>
          </div>
        </div>
      </div>
    );
  });

  return (
    <div>
      {/* Navigation bar */}
      <NavBar />

      {/* breadcrumb */}
      {/*====================  breadcrumb area ====================*/}
      <div
        className="breadcrumb-area breadcrumb-bg"
        style={{
          backgroundImage: `url(${IMAGES_URL}images/sections/${servicedata.image})`,
        }}
      >
        <div className="container">
          <div className="row">
            <div className="col">
              <div className="page-banner text-center">
                <h1>Service</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>{servicedata.heading}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      {/*====================  End of breadcrumb area  ====================*/}

      {/*====================  service page content ====================*/}
      <div className="page-wrapper section-space--inner--120">
        {/*Service section start*/}
        <div className="service-section">
          <div className="container">
            <div className="row">
              <div className="col-lg-12">
                <div className="service-item-wrapper">
                  <div className="row">{Datalist}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/*Service section end*/}
      </div>

      {/*====================  End of service page content  ====================*/}

      {/* Brand logo */}
      <BrandLogoSlider background="grey-bg" />

      {/* Footer */}
      <Footer />

      {/* Mobile Menu */}
      <MobileMenu />
    </div>
  );
  // }
};

export default Services;
