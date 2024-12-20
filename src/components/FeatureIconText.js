import React, { useEffect, useState } from "react";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const FeatureIconText = () => {
  // render() {
  const [data, setData] = useState([]);
  // const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  useEffect(() => {
    axios
      .get(API_BASE_URL + "homeservices", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setData(response.data); // Set the fetched data
        // setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        // setLoading(false);
      });
  }, []);
  if (error) return <p>Error: {error}</p>;
  let Datalist = data.map((val, i) => {
    return (
      <div className="col-lg-3 col-md-6" key={i}>
        <div className="single-feature-icon text-center">
          <div className="single-feature-icon__image">
            <img
              src={`${IMAGES_URL}images/services/${val.icon}`}
              className="img-fluid"
              alt={val.title}
              loading="lazy"
            />
          </div>
          <h3 className="single-feature-icon__title">{val.title}</h3>
          <p className="single-feature-icon__content">{val.description}</p>
        </div>
      </div>
    );
  });

  return (
    <div>
      {/*====================  feature icon area ====================*/}
      <div className="feature-icon-area section-space--inner--60">
        <div className="container">
          <div className="row">
            <div className="col-lg-12">
              <div className="feature-icon-wrapper">
                <div className="row">{Datalist}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      {/*====================  End of feature icon area  ====================*/}
    </div>
  );
  // }
};

export default FeatureIconText;
