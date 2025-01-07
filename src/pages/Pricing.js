import React, { useEffect, useState } from "react";
import NavBar from "../components/NavBar";
import Footer from "../components/Footer";
import MobileMenu from "../components/MobileMenu";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const Pricing = () => {
  const [bannerData, setBannerData] = useState(null);
  const [pageloading, setpageLoading] = useState(true);
  const [error, setError] = useState(null);
	const isAuthenticated = !!localStorage.getItem('token');
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
                          { isAuthenticated ? <a href="/admin/dashboard" className="ht-btn ht-btn--round"> Go to Dashboard </a> : <a href="/login" className="ht-btn ht-btn--round">START FREE TRIAL</a> }
													{/* <a href="/login" className="ht-btn ht-btn--round">
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
													{ isAuthenticated ? <a href="/admin/dashboard" className="ht-btn ht-btn--round"> Go to Dashboard </a> : <a href="/login" className="ht-btn ht-btn--round">START FREE TRIAL</a> }
                          {/* <a href="/login" className="ht-btn ht-btn--round">
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
													{ isAuthenticated ? <a href="/admin/dashboard" className="ht-btn ht-btn--round"> Go to Dashboard </a> : <a href="/login" className="ht-btn ht-btn--round">START FREE TRIAL</a> }
                          {/* <a href="/login" className="ht-btn ht-btn--round">
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
