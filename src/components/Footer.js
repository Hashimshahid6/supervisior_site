import React, { Component } from "react";
import { animateScroll as scroll } from "react-scroll";
import withSettings from "../contexts/withSettings";
import { IMAGES_URL } from '../constants';
class Footer extends Component {
  constructor(props) {
    super(props);
    this.state = {};
    this.handleScroll = this.handleScroll.bind(this);
    this.scrollToTop = this.scrollToTop.bind(this);
  }

  handleScroll() {
    if (this.mount) {
      this.setState({ scroll: window.scrollY });
    }
  }

  scrollToTop() {
    scroll.scrollToTop();
  }

  componentDidMount() {
    this.mount = true;
    const el = document.querySelector("nav");
    this.setState({ top: el.offsetTop, height: el.offsetHeight });
    window.addEventListener("scroll", this.handleScroll);
  }

  componentDidUpdate() {
    this.state.scroll > this.state.top
      ? document.getElementById("scroll-top").classList.add("show")
      : document.getElementById("scroll-top").classList.remove("show");
  }

  componentWillUnmount() {
    this.mount = false;
  }

  render() {
		const { settings } = this.props;
    return (
      <div>
        {/*====================  footer area ====================*/}
        <div className="footer-area dark-bg">
          <div className="container">
            <div className="row">
              <div className="col-lg-12">
                <div className="footer-content-wrapper section-space--inner--60">
                  <div className="row">
                    <div className="col-xl-3 col-lg-3 col-md-12">
                      {/* footer intro wrapper */}
                      <div className="footer-intro-wrapper">
                        <div className="footer-logo" style={{marginBottom: '20px'}}>
                          <a href={`${process.env.PUBLIC_URL}/`}>
                            <img style={{backgroundColor: 'white', borderRadius: '10px'}}
                              src={`${IMAGES_URL}images/websiteimages/${settings.site_logo}`}
                              className="img-fluid"
                              alt=""
                              loading="lazy"
                            />
                            <h3 className="site-name"
                            style={{color: 'white', paddingTop: '10px'}}>{settings.site_name}</h3>
                          </a>
                        </div>
                        <div className="footer-desc">
                          {settings.site_description}
                        </div>
                      </div>
                    </div>
                    <div className="col-xl-2 offset-xl-1 col-lg-3 col-md-4">
                      {/* footer widget */}
                      <div className="footer-widget">
                        <h4 className="footer-widget__title">Services</h4>
                        <ul className="footer-widget__navigation">
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/contact-us`}>Delivery Notes</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/contact-us`}>Risk Assessments</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/contact-us`}>Site Plans</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/contact-us`}>Toolbox Talks</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/contact-us`}>To Do Lists</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/contact-us`}>Vehicle & Plant Check Sheets</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div className="col-xl-2 offset-xl-1 col-lg-3 col-md-4">
                      {/* footer widget */}
                      <div className="footer-widget">
                        <h4 className="footer-widget__title">Pages</h4>
                        <ul className="footer-widget__navigation">
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/`}>Home</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/about-us`}>About Us</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/services`}>Services</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/contact-us`}>Contact Us</a>
                          </li>
                          <li>
                            <a href={`${process.env.PUBLIC_URL}/pricing`}>Pricing</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div className="col-xl-2 offset-xl-1 col-lg-3 col-md-4">
                      {/* footer widget */}
                      <div className="footer-widget mb-0">
                        <h4 className="footer-widget__title">CONTACT US</h4>
                        <div className="footer-widget__content">
                          <p className="address">
                            {settings.site_address}
                          </p>
                          <ul className="contact-details">
                            <li>
                              <span>P:</span>{settings.site_phone},<br></br>
                              {settings.site_phone2}
                            </li>
                            <li>
                              <span>E:</span>{settings.site_email},<br></br>
                              {settings.site_email2}
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="footer-copyright-wrapper">
            <div className="footer-copyright text-center">
              <p className="copyright-text">
                &copy; {settings.site_name} {new Date().getFullYear()} supervisesite, design by <a href="https://www.softgate.co.uk/">Softgate</a>
              </p>
            </div>
          </div>
        </div>
        {/*====================  End of footer area  ====================*/}
        {/*====================  scroll top ====================*/}
        <button
          className="scroll-top"
          id="scroll-top"
          onClick={this.scrollToTop}
        >
          <i className="ion-android-arrow-up" />
        </button>
        {/*====================  End of scroll top  ====================*/}
      </div>
    );
  }
}

export default withSettings(Footer);
