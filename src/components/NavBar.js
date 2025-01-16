import React, { useState, useEffect, useRef } from "react";
import { Link, useNavigate, useLocation } from "react-router-dom";
import MobileMenu from "./MobileMenu";
import withSettings from "../contexts/withSettings";
import { IMAGES_URL } from "../constants";
import { isLoggedIn } from "../contexts/isLoggedIn";

const NavBar = ({ settings }) => {
  const [scroll, setScroll] = useState(0);
  const [top, setTop] = useState(0);
  const [height, setHeight] = useState(0);
  const [loggedIn, setLoggedIn] = useState(false);
  const mobileMenuElement = useRef();
  const navigate = useNavigate();
	const location = useLocation();

  const handleScroll = () => {
    setScroll(window.scrollY);
  };

  const activeMobileMenu = () => {
    mobileMenuElement.current.toggleMobileMenu();
  };

  const checkLoginStatus = async () => {
    try {
      const loggedInStatus = await isLoggedIn();
      setLoggedIn(loggedInStatus);
    } catch (error) {
      console.error("Error checking login status:", error);
    }
  };

  useEffect(() => {
    const el = document.querySelector("nav");
    if (el) {
      setTop(el.offsetTop);
      setHeight(el.offsetHeight);
    }
    window.addEventListener("scroll", handleScroll);
    checkLoginStatus();

    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  useEffect(() => {
    document.body.style.paddingTop = scroll > top ? `${height}px` : 0;
  }, [scroll, top, height]);

  return (
    <div>
      {/* Header Area */}
      <div
        className={`header-area header-sticky header-sticky--default ${
          scroll > top ? "is-sticky" : ""
        }`}
      >
        <div className="header-area__desktop header-area__desktop--default">
          {/* Header Info Area */}
          <div className="header-info-area" style={{ padding: "0px" }}>
            <div className="container">
              <div className="row align-items-center">
                <div className="col-lg-12">
                  <div className="header-info-wrapper align-items-center">
                    {/* Logo */}
                    <div className="logo">
                      <Link to={`/`}>
                        <img
                          src={`${IMAGES_URL}images/websiteimages/${settings.site_logo}`}
                          className="img-fluid"
                          alt="Logo"
                          loading="lazy"
                        />
                      </Link>
                      <h3>{settings.site_name}</h3>
                    </div>
                    {/* Header Contact Info */}
                    <div className="header-contact-info">
                      <div className="header-info-single-item">
                        <div className="header-info-single-item__icon">
                          <i className="zmdi zmdi-smartphone-android" />
                        </div>
                        <div className="header-info-single-item__content">
                          <h6 className="header-info-single-item__title">
                            Phone
                          </h6>
                          <p className="header-info-single-item__subtitle">
                            {settings.site_phone}
                          </p>
                        </div>
                      </div>
                      <div className="header-info-single-item">
                        <div className="header-info-single-item__icon">
                          <i className="zmdi zmdi-home" />
                        </div>
                        <div className="header-info-single-item__content">
                          <h6 className="header-info-single-item__title">
                            Address
                          </h6>
                          <p className="header-info-single-item__subtitle">
                            {settings.site_address}
                          </p>
                        </div>
                      </div>
                    </div>
                    {/* Mobile Menu */}
                    <div
                      className="mobile-navigation-icon"
                      id="mobile-menu-trigger"
                      onClick={activeMobileMenu}
                    >
                      <i />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          {/* Header Navigation Area */}
          <div className="header-navigation-area default-bg">
            <div className="container">
              <div className="row">
                <div className="col-lg-12">
                  <div className="header-navigation header-navigation--header-default position-relative">
                    <div className="header-navigation__nav position-static">
                      <nav>
                        <ul>
                          <li>
                            <Link to="/" className={location.pathname === "/" ? "active" : ""}>HOME</Link>
                          </li>
                          <li>
                            <Link to="/about-us" className={location.pathname === "/about-us" ? "active" : ""}>ABOUT</Link>
                          </li>
                          <li>
                            <Link to="/services" className={location.pathname === "/services" ? "active" : ""}>SERVICE</Link>
                          </li>
                          <li>
                            <Link to="/contact-us" className={location.pathname === "/contact-us" ? "active" : ""}>CONTACT</Link>
                          </li>
                          <li>
                            <Link to="/pricing" className={location.pathname === "/pricing" ? "active" : ""}>PRICING</Link>
                          </li>
                          {loggedIn ? (
                            <li
                              style={{
                                position: "absolute",
                                right: "10px",
                                display: "flex",
                              }}
                            >
                              <a
                                href="/admin/dashboard"
                                style={{ marginRight: "20px" }}
                              >
                                WELCOME{" "}
                                {JSON.parse(localStorage.getItem("user")).name}
                              </a>
                              <Link to="/logout">LOGOUT</Link>
                            </li>
                          ) : (
                            <li
                              style={{
                                position: "absolute",
                                right: "10px",
                                display: "flex",
                              }}
                            >
                              <Link to="/login" className={location.pathname === "/login" ? "active" : ""}>LOGIN</Link>
                            </li>
                          )}
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      {/* Mobile Menu */}
      <MobileMenu ref={mobileMenuElement} />
    </div>
  );
};

export default withSettings(NavBar);