import React, { useEffect, useState } from "react";
import SwiperSlider, { SwiperSlide } from "./swiper";
import { EffectFade } from "swiper";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const HeroSliderThree = () => {
  const params = {
    slidesPerView: 1,
    loop: true,
    effect: "fade",
    navigation: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: true,
    },
    modules: [EffectFade],
  };
  const [data, setData] = useState([]);
  // const [loading, setLoading] = useState(true);
  // const [error, setError] = useState(null);

  // Fetch data on component mount
  useEffect(() => {
    axios
      .get(API_BASE_URL + "herosections", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setData(response.data.data); // Set the fetched data
        // setLoading(false);
      })
      .catch((error) => {
        // setError(error.message);
        // setLoading(false);
      });
  }, []);

  // Ensure Swiper reloads properly when the data changes
  useEffect(() => {
    if (data.length > 0) {
      // Force a re-render by triggering a state update or reinitializing the slider
      // setLoading(false);
    }
  }, [data]);

  // Map through the fetched data and render the slides
  const DataList = data.map((val, i) => {
    return (
      <div
      className="hero-slider__single-item"
      style={{
        backgroundImage: `url(${IMAGES_URL}images/hero-section/${val.image})`,
        backgroundPosition: "center center",
        backgroundSize: "cover",
      }}
      >
      <div className="hero-slider__content-wrapper">
        <div className="container">
        <div className="row">
          <div className="col-lg-12">
          <div
            className="hero-slider__content"
            style={{
            height: "730px",
            ...(window.innerWidth <= 768 && { height: "400px" }),
            }}
          >
            <h2 className="hero-slider__title"
            style={{marginBottom:"10px"}}>{val.title}</h2>
            <p className="hero-slider__text"
            style={{fontSize:'24px'}}>{val.subtitle}</p>
            <a
            className="hero-slider__btn"
            href={val.button_url}
            loading="lazy"
            >
            {val.button_text}
            </a>
          </div>
          </div>
        </div>
        </div>
      </div>
      </div>
    );
  });

  // if (loading) {
  //   return <div>Loading...</div>;
  // }

  // if (error) {
  //   return <div>Error loading slider content: {error}</div>;
  // }

  return (
    <div>
      {/*====================  hero slider area ====================*/}
      <div className="hero-slider-area">
        <SwiperSlider options={params}>{DataList}</SwiperSlider>
      </div>
      {/*====================  End of hero slider area  ====================*/}
    </div>
  );
};

export default HeroSliderThree;
