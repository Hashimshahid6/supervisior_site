import React, { Component,useEffect, useState } from 'react';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';
import { IMAGES_URL, API_BASE_URL, API_TOKEN } from "../constants.js";
import axios from "axios";

const ServiceTabTwo = () =>{

    // render(){
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
        /* service tab menu */
				let serviceTabMenuData = [];
				data.map((serv) => {
					let eachServ = {
						iconName: serv.icon,
						tabMenuName: serv.title
					}
					serviceTabMenuData.push(eachServ);
				})
				// let serviceTabMenuData = [
				// 	  {iconName: 'flaticon-002-welding', tabMenuName: 'Land Mining'},
        //     {iconName: 'flaticon-004-walkie-talkie', tabMenuName: 'Work Management'},
        //     {iconName: 'flaticon-015-cart', tabMenuName: 'Material Engineering'},
        //     {iconName: 'flaticon-010-tank-1', tabMenuName: 'Power and Energy'}
        // ];

        let serviceTabMenuDatalist = serviceTabMenuData.map((val, i)=>{
            return(
                <Tab key={i}>  <span className="icon"><i className={val.iconName} /></span> <span className="text">{val.tabMenuName}</span></Tab>
            )
        });

        
        /* service tab content */
        
        // let serviceTabContentData = [
        //     {bgUrl: "service-tab1.jpg", contentTitle: 'Land Mining', contentDesc: 'Lorem ipsum dolor sit amet, consectet adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', serviceLink: 'service-details-left-sidebar'},
        //     {bgUrl: "service-tab1.jpg", contentTitle: 'Work Management', contentDesc: 'Lorem ipsum dolor sit amet, consectet adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', serviceLink: 'service-details-left-sidebar'},
        //     {bgUrl: "service-tab1.jpg", contentTitle: 'Material Engineering', contentDesc: 'Lorem ipsum dolor sit amet, consectet adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', serviceLink: 'service-details-left-sidebar'},
        //     {bgUrl: "service-tab1.jpg", contentTitle: 'Power and Energy', contentDesc: 'Lorem ipsum dolor sit amet, consectet adipisicin elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', serviceLink: 'service-details-left-sidebar'}
        // ];

        let serviceTabContentDatalist = data.map((val, i)=>{
            return(
                <TabPanel key={i}>
                    <div className="service-tab__single-content-wrapper" style={{ backgroundImage: `url(${IMAGES_URL}images/services/${val.bgImage})` }}>
                        <div className="service-tab__single-content">
                            <h3 className="service-tab__title">{val.title}</h3>
                            <p className="service-tab__text">{val.description}</p>
                            <a href={`/ServiceDetail/${val.id}`} className="see-more-link">SEE MORE</a>
                        </div>
                    </div>
                </TabPanel>
            )
        });

        return(
            <div>

                {/*====================  service tab area ====================*/}
                <div className="service-tab-area section-space--inner--120">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-12">
                                {/* section title */}
                                <div className="section-title-area text-center section-space--bottom--50">
                                    <h2 className="section-title">Our Services</h2>
                                    <p className="section-subtitle">Lorem ipsum dolor sit amet, consectetur adipisicing</p>
                                </div>

                            </div>
                            <div className="col-lg-12">
                                {/* service tab wrapper */}
                                
                                <div className="service-tab-wrapper">
                                <Tabs>
                                    <div className="row no-gutters">
                                        <div className="col-md-4">
                                            <TabList>
                                                <div className="service-tab__link-wrapper">
                                                    {serviceTabMenuDatalist}
                                                </div>
                                            </TabList>
                                        </div>

                                        <div className="col-md-8">
                                            {serviceTabContentDatalist}
                                        </div>
                                    </div>
                                </Tabs>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {/*====================  End of service tab area  ====================*/}
            </div>
        )
    // }
}

export default ServiceTabTwo;