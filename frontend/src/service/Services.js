import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import BrandLogoSlider from "../components/BrandLogoSlider";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const Services = () => {
  const [bannerData, setBannerData] = useState(null);
  const [serviceData, setServiceData] = useState([]);
  // const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // Fetch banner and service data
  useEffect(() => {
    const fetchData = async () => {
      try {
        const [bannerResponse, servicesResponse] = await Promise.all([
          axios.get(API_BASE_URL + "getbanner/2", {
            headers: { Authorization: `Bearer ${API_TOKEN}` },
          }),
          axios.get(API_BASE_URL + "allservices", {
            headers: { Authorization: `Bearer ${API_TOKEN}` },
          }),
        ]);

        setBannerData(bannerResponse.data);
        setServiceData(servicesResponse.data);
      } catch (err) {
        setError(err.message);
      } finally {
        // setLoading(false);
      }
    };

    fetchData();
  }, []);

  // if (loading) return <p>Loading...</p>;
  // if (error) return <p>Error: {error}</p>;

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
                <h1>{bannerData?.title || "Services"}</h1>
                <ul className="page-breadcrumb">
                  <li>
                    <a href="/">Home</a>
                  </li>
                  <li>Services</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      {/* Services Section */}
      <div className="page-wrapper section-space--inner--120">
        <div className="service-section">
          <div className="container">
            <div className="row">
              {serviceData.map((val, i) => (
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
                            loading="lazy"
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
                          loading="lazy"
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
                      <a
                        href={`/ServiceDetail/${val.id}`}
                        className="see-more-link"
                      >
                        SEE MORE
                      </a>
                    </div>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>

      {/* Brand Logo */}
      <BrandLogoSlider background="grey-bg" />

      {/* Footer */}
      <Footer />

      {/* Mobile Menu */}
      <MobileMenu />
    </div>
  );
};

export default Services;