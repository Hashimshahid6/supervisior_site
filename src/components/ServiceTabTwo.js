import React, { useEffect, useState } from "react";
import { Tab, Tabs, TabList, TabPanel } from "react-tabs";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const ServiceTabTwo = () => {
  const [services, setServices] = useState([]);
  const [serviceSection, setServiceSection] = useState({});
  // const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchServices = async () => {
      try {
        const [servicesResponse, serviceSectionResponse] = await Promise.all([
          axios.get(`${API_BASE_URL}homeservices`, {
            headers: { Authorization: `Bearer ${API_TOKEN}` },
          }),
          axios.get(`${API_BASE_URL}servicesection`, {
            headers: { Authorization: `Bearer ${API_TOKEN}` },
          }),
        ]);

        setServices(servicesResponse.data);
        setServiceSection(serviceSectionResponse.data);
      } catch (err) {
        setError(err.message);
      } finally {
        // setLoading(false);
      }
    };

    fetchServices();
  }, []);

  // if (loading) return <div>Loading...</div>;
  // if (error) return <div>Error: {error}</div>;

const renderServiceTabs = () =>
    services.map((service, index) => (
        <Tab key={index}>
            <span className="icon" style={{ marginRight: "10px" }}>
                <img
                    src={`${IMAGES_URL}images/services/${service.icon}`}
                    className="img-fluid"
                    alt={service.icon}
                    loading="lazy"
                    style={{ width: "50px", height: "50px" }}
                />
            </span>
            <span className="text">{service.title}</span>
        </Tab>
    ));

  const renderServiceContent = () =>
    services.map((service, index) => (
      <TabPanel key={index}>
        <div
          className="service-tab__single-content-wrapper"
          style={{
            backgroundImage: `url(${IMAGES_URL}images/services/${service.bgImage})`,
          }}
        >
          <div className="service-tab__single-content">
            <h3 className="service-tab__title">{service.title}</h3>
            <p className="service-tab__text">{service.description}</p>
            <a href={service.button_url} className="see-more-link">
              {service.button_text}
            </a>
          </div>
        </div>
      </TabPanel>
    ));

  return (
    <div className="service-tab-area section-space--inner--60">
      <div className="container">
        <div className="row">
          <div className="col-lg-12">
            {/* Section Title */}
            <div className="section-title-area text-center section-space--bottom--50">
              <h2 className="section-title">{serviceSection.heading}</h2>
              <p className="section-subtitle">{serviceSection.content}</p>
              <a
                href={serviceSection.button_link}
                className="ht-btn--default ht-btn--default--dark-hover section-space--top--20"
              >
                {serviceSection.button_text}
              </a>
            </div>
          </div>
          <div className="col-lg-12">
            {/* Service Tab Wrapper */}
            <div className="service-tab-wrapper">
              <Tabs>
                <div className="row no-gutters">
                  <div className="col-md-4">
                    <TabList>
                      <div className="service-tab__link-wrapper">
                        {renderServiceTabs()}
                      </div>
                    </TabList>
                  </div>
                  <div className="col-md-8">{renderServiceContent()}</div>
                </div>
              </Tabs>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ServiceTabTwo;