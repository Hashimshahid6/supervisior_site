import React, { Component } from "react";
import { Link } from "react-router-dom";
import MobileMenu from "./MobileMenu";
import withSettings from "../contexts/withSettings";
import { IMAGES_URL } from "../constants";
class NavBar extends Component {
  constructor(props) {
    super(props);
    this.state = {};
    this.handleScroll = this.handleScroll.bind(this);

    this.mobileMenuElement = React.createRef();
  }

  activeMobileMenu = () => {
    this.mobileMenuElement.current.toggleMobileMenu();
  };

  handleScroll() {
    if (this.mount) {
      this.setState({ scroll: window.scrollY });
    }
  }

  componentDidMount() {
    this.mount = true;
    const el = document.querySelector("nav");
    this.setState({ top: el.offsetTop, height: el.offsetHeight });
    window.addEventListener("scroll", this.handleScroll);
  }

  componentDidUpdate() {
    this.state.scroll > this.state.top
      ? (document.body.style.paddingTop = `${this.state.height}px`)
      : (document.body.style.paddingTop = 0);
  }

  componentWillUnmount() {
    this.mount = false;
  }

  render() {
    const { settings } = this.props;
    return (
      <div>
        {/*====================  header area ====================*/}
        <div
          className={`header-area header-sticky header-sticky--default ${
            this.state.scroll > this.state.top ? "is-sticky" : ""
          }`}
        >
          <div className="header-area__desktop header-area__desktop--default">
            {/*=======  header info area  =======*/}
            <div className="header-info-area" style={{padding: '0px'}}>
              <div className="container">
                <div className="row align-items-center">
                  <div className="col-lg-12">
                    <div className="header-info-wrapper align-items-center">
                    {/* logo */}
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
                    {/* header contact info */}
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
                      {/* mobile menu */}
                      <div
                        className="mobile-navigation-icon"
                        id="mobile-menu-trigger"
                        onClick={this.activeMobileMenu}
                      >
                        <i />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {/*=======  End of header info area =======*/}
            {/*=======  header navigation area  =======*/}
            <div className="header-navigation-area default-bg">
              <div className="container">
                <div className="row">
                  <div className="col-lg-12">
                    {/* header navigation */}
                    <div className="header-navigation header-navigation--header-default position-relative">
                      <div className="header-navigation__nav position-static">
                        <nav>
                          <ul>
                            <li>
                              <Link to={`${process.env.PUBLIC_URL}/`}>
                                {" "}
                                HOME{" "}
                              </Link>
                            </li>
                            <li>
                              <Link to={`${process.env.PUBLIC_URL}/about-us`}>
                                ABOUT
                              </Link>
                            </li>
                            <li>
                              <Link to={`${process.env.PUBLIC_URL}/services`}>
                                SERVICE
                              </Link>
                            </li>
                            {/* <li>
                                <Link to={`${process.env.PUBLIC_URL}/projects`} >PROJECTS</Link>
                            </li>
                            <li>
                                <Link to={`${process.env.PUBLIC_URL}/blog-left-sidebar`}>BLOGS</Link>
                            </li> */}
                            <li>
                              <Link to={`${process.env.PUBLIC_URL}/contact-us`}>
                                CONTACT
                              </Link>{" "}
                            </li>
                            <li>
                              <Link to={`${process.env.PUBLIC_URL}/pricing`}>
                                PRICING
                              </Link>{" "}
                            </li>
                          </ul>
                        </nav>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {/*=======  End of header navigation area =======*/}
          </div>
        </div>
        {/*====================  End of header area  ====================*/}

        {/* Mobile Menu */}
        <MobileMenu ref={this.mobileMenuElement} />
      </div>
    );
  }
}

export default withSettings(NavBar);