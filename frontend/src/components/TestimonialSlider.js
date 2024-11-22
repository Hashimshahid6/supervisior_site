import React, { useEffect, useState } from "react";
import SwiperSlider, { SwiperSlide } from "./swiper";
import { EffectFade } from "swiper";
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const TestimonialSlider = () => {
  // render() {
    const params = {
      slidesPerView: 1,
      loop: true,
      autoplay: false,
      effect: "fade",
      pagination: {
        el: ".swiper-pagination",
        type: "bullets",
        clickable: true
      },
      modules: [EffectFade]
    };
    const [data, setData] = useState([]);
		const [loading, setLoading] = useState(true);
		const [error, setError] = useState(null);
		useEffect(() => {
			axios
				.get(API_BASE_URL + "testimonials",{
					headers: {
						Authorization: `Bearer ${API_TOKEN}`
					}
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
		let bgImage = ""; 
		let DataList = data.map((val, i) => {
			bgImage = val.bgImage;
			return (
        <SwiperSlide key={i}>
          <div className="testimonial-slider__single-slide">
            <div className="author">
              <div className="author__image">
                <img
                  src={`${IMAGES_URL}images/testimonials/${val.avatar}`}
                  alt=""
                />
              </div>
              <div className="author__details">
                <h4 className="name">{val.name}</h4>
                <div className="designation">{val.designation}</div>
              </div>
            </div>
            <div className="content">{val.description}</div>
          </div>
        </SwiperSlide>
      );
    });

    return (
      <div>
        {/*====================  testimonial slider area ====================*/}
        <div
          className="testimonial-slider-area testimonial-slider-area-bg section-space--inner--120"
          style={{
            backgroundImage: `url(${IMAGES_URL}images/testimonials/${bgImage})`
          }}
        >
          <div className="container">
            <div className="row">
              <div className="col-lg-10 offset-lg-1">
                <div className="testimonial-slider">
                  <div className="testimonial-slider__container-area">
                    <SwiperSlider options={params}>{DataList}</SwiperSlider>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        {/*====================  End of testimonial slider area  ====================*/}
      </div>
    );
  // }
}

export default TestimonialSlider;
