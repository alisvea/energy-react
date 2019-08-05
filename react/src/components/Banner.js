import React from 'react';
import banner from "../banner.png";

class Banner extends React.Component {
    render() {
        return (
            <div className="middle-banner">
                <img src={banner} className="App-logo" alt="logo" />
                <div className="banner-content">
                    <div className="wrapper">
                        <ul>
                            <li>This is first line on our banner</li>
                            <li>This is second line on our banner</li>
                        </ul>
                    </div>
                </div>
            </div>
        )
    }
}

export default Banner;