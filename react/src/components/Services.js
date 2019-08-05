import React from 'react';
import { Link } from 'react-router-dom';

class Services extends React.Component {
    render() {
        return (
            <section id="services">
                <div className="wrapper">
                    <ul className="focus-box">
                        <li>
                            <Link to={'/news'}>
                                <div className="service-icon">
                                    <i style={Styles.parraImg}
                                       className="pixeden glyphicon"></i>
                                    <p id="cat">خبریں</p>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link to={'/interesting'}>
                                <div className="service-icon">
                                    <i style={Styles.roundImg}
                                       className="pixeden glyphicon"></i>
                                    <p id="cat"> دلچسپ </p>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link to={'/mazahia'}>
                                <div className="service-icon">
                                    <i style={Styles.parraImg}
                                       className="pixeden glyphicon"></i>
                                    <p id="cat">مزاخیہ</p>
                                </div>
                            </Link>
                        </li>

                    </ul>

                    <ul className="focus-box">
                        <li>
                            <Link to={'/international'}>
                                <div className="service-icon">
                                    <i style={Styles.parraImg}
                                       className="pixeden glyphicon"></i>
                                    <p id="cat">بین الاقوامی</p>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <Link to={'/science'}>
                                <div className="service-icon">
                                    <i style={Styles.roundImg}
                                       className="pixeden glyphicon"></i>
                                    <p id="cat"> سائنس </p>
                                </div>
                            </Link>
                        </li>
                        <li>
                            <div className="service-icon">
                                <i style={Styles.parraImg}
                                   className="pixeden glyphicon"></i>
                                <p id="cat"> ملک</p>
                            </div>
                        </li>

                    </ul>

                    <ul className="focus-box">
                        <li>
                            <div className="service-icon">
                                <i style={Styles.parraImg}
                                   className="pixeden glyphicon"></i>
                                <p id="cat">مارشل</p>
                            </div>
                        </li>
                        <li>
                            <div className="service-icon">
                                <i style={Styles.roundImg}
                                   className="pixeden glyphicon"></i>
                                <p id="cat"> پیپلز </p>
                            </div>
                        </li>
                        <li>
                            <div className="service-icon">
                                <i style={Styles.parraImg}
                                   className="pixeden glyphicon"></i>
                                <p id="cat"> ملک</p>
                            </div>
                        </li>

                    </ul>

                </div>
            </section>
        )
    }
}

const Styles = {
    roundImg: {
        background: "url(images/ti-logo.png) no-repeat center",
        width: "100%",
        height: "100%"
    },

    parraImg: {
        background: "url(images/parallax.png) no-repeat center",
        width: "100%",
        height: "100%"
    }
};
export default Services;
