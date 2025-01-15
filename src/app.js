import React, {  Suspense, lazy } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Logout from "./pages/Logout";
import RedirectIfLoggedIn from "./contexts/RedirectIfLoggedIn";

const HomeOne = lazy(() => import("./home/HomeOne"));
const HomeTwo = lazy(() => import("./home/HomeTwo"));
const HomeThree = lazy(() => import("./home/HomeThree"));
const About = lazy(() => import("./pages/About"));
const Services = lazy(() => import("./service/Services"));
const ServiceDetailsLeftSidebar = lazy(() => import("./service/ServiceDetailsLeftSidebar"));
const ServiceDetailsRightSidebar = lazy(() => import("./service/ServiceDetailsRightSidebar"));
const Projects = lazy(() => import("./project/Projects"));
const ProjectDetails = lazy(() => import("./project/ProjectDetails"));
const BlogLeftSidebar = lazy(() => import("./blog/BlogLeftSidebar"));
const BlogRightSidebar = lazy(() => import("./blog/BlogRightSidebar"));
const BlogDetailsLeftSidebar = lazy(() => import("./blog/BlogDetailsLeftSidebar"));
const BlogDetailsRightSidebar = lazy(() => import("./blog/BlogDetailsRightSidebar"));
const Contact = lazy(() => import("./pages/Contact"));
const NoMAtch = lazy(() => import("./pages/404"));
const Pricing = lazy(() => import("./pages/Pricing"));
const Register = lazy(() => import("./pages/Register"));
const Login = lazy(() => import("./pages/Login"));
const PaypalCancel = lazy(() => import("./pages/PaypalCancel"));
const PaypalReturn = lazy(() => import("./pages/PaypalReturn"));

const App = () => {
  return (
	  <Router>
        <Suspense fallback={<div />}>
            <Routes>
                <Route path="/demo/" element={<HomeThree />} />
                <Route path="/demo/home-one" element={<HomeOne />} />
                <Route path="/demo/home-two" element={<HomeTwo />} />
                <Route path="/demo/home-three" element={<HomeThree />} />
                <Route path="/demo/about-us" element={<About />} />
                <Route path="/demo/services" element={<Services />} />
                <Route path="/demo/service-details-left-sidebar" element={<ServiceDetailsLeftSidebar />} />
                <Route path="/demo/service-details-right-sidebar" element={<ServiceDetailsRightSidebar />} />
                <Route path="/demo/projects" element={<Projects />} />
                <Route path="/demo/project-details" element={<ProjectDetails />} />
                <Route path="/demo/blog-left-sidebar" element={<BlogLeftSidebar />} />
                <Route path="/demo/blog-right-sidebar" element={<BlogRightSidebar />} />
                <Route path="/demo/blog-details-left-sidebar" element={<BlogDetailsLeftSidebar />} />
                <Route path="/demo/blog-details-right-sidebar" element={<BlogDetailsRightSidebar />} />
                <Route path="/demo/contact-us" element={<Contact />} />
                <Route path="/demo/pricing" element={<Pricing />} />
                <Route path="/demo/PaypalCancel" element={<PaypalCancel />} />
                <Route path="/demo/PaypalReturn" element={<PaypalReturn />} />
                <Route path="/demo/register" element={
										<RedirectIfLoggedIn>
											<Register />
										</RedirectIfLoggedIn>
									} />
                <Route path="/demo/login" element={
                        <RedirectIfLoggedIn>
                            <Login />
                        </RedirectIfLoggedIn>
                    } />
                <Route path="/demo/logout" element={<Logout />} />
                <Route path="*" element={<NoMAtch />} />
            </Routes>
        </Suspense>
      </Router>			
  )
}

export default App