import React, { useEffect, useState } from "react";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";
const AboutText = () => {
  const [data, setData] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
//   console.log('image2',data.image);
  useEffect(() => {
    axios
      .get(API_BASE_URL + "aboutsection", {
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
  }, []);
  // render(){
  return (
    <div>
      {/*====================  about text area ====================*/}
      <div className="about-text-area grey-bg section-space--inner--120">
        <div className="container">
          <div className="row align-items-center">
            <div className="col-lg-6 col-md-6">
              <div className="video-cta-content">
                <h4 className="video-cta-content__small-title">
                  {data.heading}
                </h4>
                <h3 className="video-cta-content__title">{data.subheading}</h3>
                <p className="video-cta-content__text">{data.content}</p>
                <a href={data.button_url} className="ht-btn ht-btn--round">
                  {data.button_text}
                </a>
              </div>
            </div>
            <div className="col-md-6">
              <div className="cta-video-image__image">
                <img
                  src={`${IMAGES_URL}images/sections/${data.image}`}
                  className="img-fluid"
                  alt=""
                />
              </div>
            </div>
          </div>
        </div>
      </div>
      {/*====================  End of about text area  ====================*/}
    </div>
  );
  // }
};

export default AboutText;
