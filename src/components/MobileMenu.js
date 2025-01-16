import React, { Component } from "react";
import { Link } from "react-router-dom";
import {isLoggedIn} from "../contexts/isLoggedIn";
class MobileMenu extends Component {
	constructor(props) {
		super(props);
		this.state = {
			loggedIn: false, // Initial state to track login status
			// isAuthenticated: localStorage.getItem("token"),
		};
		// const user = JSON.parse(localStorage.getItem('user'));
	}
  state = {
    active: false,
  };

  toggleMobileMenu = () => {
    this.setState({
      active: !this.state.active,
    });
  };

  componentDidMount() {
    var offCanvasNav = document.getElementById("offcanvas-navigation");
    var offCanvasNavSubMenu = offCanvasNav.querySelectorAll(".sub-menu");

    for (let i = 0; i < offCanvasNavSubMenu.length; i++) {
      offCanvasNavSubMenu[i].insertAdjacentHTML(
        "beforebegin",
        "<span class='menu-expand'><i></i></span>"
      );
    }

    var menuExpand = offCanvasNav.querySelectorAll(".menu-expand");
    var numMenuExpand = menuExpand.length;

    function sideMenuExpand() {
      if (this.parentElement.classList.contains("active") === true) {
        this.parentElement.classList.remove("active");
      } else {
        for (let i = 0; i < numMenuExpand; i++) {
          menuExpand[i].parentElement.classList.remove("active");
        }
        this.parentElement.classList.add("active");
      }
    }

    for (let i = 0; i < numMenuExpand; i++) {
      menuExpand[i].addEventListener("click", sideMenuExpand);
    }
		this.checkLoginStatus();
  }
	checkLoginStatus = async () => {
		try {
			const loggedInStatus = await isLoggedIn();
			this.setState({ loggedIn: loggedInStatus });
		} catch (error) {
			console.error("Error checking login status:", error);
		}
	};
  render() {
		const { loggedIn } = this.state;
    return (
      <div>
        {/*=======  offcanvas mobile menu  =======*/}
        <div
          className={`offcanvas-mobile-menu ${
            this.state.active ? "active" : ""
          } `}
          id="mobile-menu-overlay"
        >
          <a
            href="#/"
            className="offcanvas-menu-close"
            id="mobile-menu-close-trigger"
            onClick={this.toggleMobileMenu}
          >
            <i className="ion-android-close" />
          </a>
          <div className="offcanvas-wrapper">
            <div className="offcanvas-inner-content">
              <div className="offcanvas-mobile-search-area">
                <form action="#">
                  <input type="search" placeholder="Search ..." />
                  <button type="submit">
                    <i className="fa fa-search" />
                  </button>
                </form>
              </div>
              <nav className="offcanvas-navigation" id="offcanvas-navigation">
                <ul>
                  <li>
                    <Link to={`${process.env.PUBLIC_URL}/`}> HOME </Link>
                  </li>
                  <li>
                    <Link to={`${process.env.PUBLIC_URL}/about-us`}>ABOUT</Link>
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
                    </Link>
                  </li>
                  <li>
                    <Link to={`${process.env.PUBLIC_URL}/pricing`}>PRICING</Link>
                  </li>
                </ul>
								{
									loggedIn ?
									<ul>
										<li>
											<a href={`${process.env.PUBLIC_URL}/admin/dashboard`} style={{marginRight: '20px'}}>
																WELCOME {JSON.parse(localStorage.getItem('user')).name}
															</a>
										</li>
										<li>
											<Link to={`${process.env.PUBLIC_URL}/logout`}>LOGOUT</Link>
										</li>
									</ul>
									:
									<ul>
										<li>
											<Link to={`${process.env.PUBLIC_URL}/login`}>LOGIN</Link>
										</li>
										<li>
											<Link to={`${process.env.PUBLIC_URL}/register`}>REGISTER</Link>
										</li>
									</ul>
								}
              </nav>
              <div className="offcanvas-widget-area">
                <div className="off-canvas-contact-widget">
                  <div className="header-contact-info">
                    <ul className="header-contact-info__list">
                      <li>
                        <i className="ion-android-phone-portrait" />{" "}
                        <a href="tel://12452456012">07495 511690 </a>
                      </li>
                      <li>
                        <i className="ion-android-mail" />{" "}
                        <a href="mailto:info@supervisesite.co.uk">
                          info@supervisesite.co.uk
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                {/*Off Canvas Widget Social Start*/}
                {/* <div className="off-canvas-widget-social">
                  <a href="#/" title="Facebook">
                    <i className="fa fa-facebook" />
                  </a>
                  <a href="#/" title="Twitter">
                    <i className="fa fa-twitter" />
                  </a>
                  <a href="#/" title="LinkedIn">
                    <i className="fa fa-linkedin" />
                  </a>
                  <a href="#/" title="Youtube">
                    <i className="fa fa-youtube-play" />
                  </a>
                  <a href="#/" title="Vimeo">
                    <i className="fa fa-vimeo-square" />
                  </a>
                </div> */}
                {/*Off Canvas Widget Social End*/}
              </div>
            </div>
          </div>
        </div>
        {/*=======  End of offcanvas mobile menu  =======*/}
      </div>
    );
  }
}

export default MobileMenu;
