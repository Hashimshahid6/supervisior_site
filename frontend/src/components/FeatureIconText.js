import React, { useEffect, useState } from 'react';
import { BASE_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const FeatureIconText = () => {
    // render() {
			const [data, setData] = useState([]);
			const [loading, setLoading] = useState(true);
			const [error, setError] = useState(null);
			useEffect(() => {
				axios
					.get(API_BASE_URL + "homeservices",{
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
        // let data = [
        //     {featureIcon: "feature-4.png", featureTitle: "Land Mining", featureDescription: "Lorem ipsum dolor sit consect adipisicing elit, sed do eiusmo tempor incididu."},
        //     {featureIcon: "feature-5.png", featureTitle: "Work Management", featureDescription: "Lorem ipsum dolor sit consect adipisicing elit, sed do eiusmo tempor incididu."},
        //     {featureIcon: "feature-6.png", featureTitle: "Material Engineering", featureDescription: "Lorem ipsum dolor sit consect adipisicing elit, sed do eiusmo tempor incididu."},
        //     {featureIcon: "feature-7.png", featureTitle: "Power & Energy", featureDescription: "Lorem ipsum dolor sit consect adipisicing elit, sed do eiusmo tempor incididu."}
        // ];

        let Datalist = data.map((val, i)=>{
            return(
         
                <div className="col-lg-3 col-md-6" key={i}>
                    <div className="single-feature-icon text-center">
                        <div className="single-feature-icon__image">
                            {/* <img src={`${BASE_URL}images/services/${val.icon}`} className="img-fluid" alt="" /> */}
														<i className={`${val.icon} fa-3x`}></i>
                        </div>
                        <h3 className="single-feature-icon__title">{val.title}</h3>
                        <p className="single-feature-icon__content">{val.description}</p>
                    </div>
                </div>
            )
        });

        return (
            <div>
                {/*====================  feature icon area ====================*/}
                <div className="feature-icon-area section-space--inner--120">
                    <div className="container">
                        <div className="row">
                        <div className="col-lg-12">
                            <div className="feature-icon-wrapper">
                                <div className="row">
                                    {Datalist}
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                {/*====================  End of feature icon area  ====================*/}
            </div>
        )
    // }
}

export default FeatureIconText;
