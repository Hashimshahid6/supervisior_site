import React, { Component, useEffect, useState } from "react";
import SwiperSlider, { SwiperSlide } from "./swiper";
import { EffectFade } from "swiper";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const HeroSliderThree = () => {
  // render(){
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
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  useEffect(() => {
    axios
      .get(API_BASE_URL + "herosections", {
        headers: {
          Authorization: `Bearer ${API_TOKEN}`,
        },
      }) // Laravel API endpoint
      .then((response) => {
        setData(response.data.data); // Set the fetched data
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
  }, []);

  let DataList = data.map((val, i) => {
    return (
      <SwiperSlide key={i}>
        <div
          className="hero-slider__single-item"
          style={{
            backgroundImage: `url(${IMAGES_URL}images/hero-section/${val.image})`,
          }}
        >
          <div className="hero-slider__content-wrapper">
            <div className="container">
              <div className="row">
                <div className="col-lg-12">
                  <div className="hero-slider__content m-auto text-center" style={{ height: '730px', width: '100%'}}>
                    <h2 className="hero-slider__title">{val.title}</h2>
                    <p className="hero-slider__text">{val.subtitle}</p>
                    <a
                      className="hero-slider__btn hero-slider__btn--style2"
                      href={val.button_url}
                    >
                      {" "}
                      {val.button_text}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </SwiperSlide>
    );
  });

  return (
    <div>
      {/*====================  hero slider area ====================*/}
      <div className="hero-alider-area">
        <SwiperSlider options={params}>{DataList}</SwiperSlider>
      </div>
      {/*====================  End of hero slider area  ====================*/}
    </div>
  );
  // }
};

export default HeroSliderThree;