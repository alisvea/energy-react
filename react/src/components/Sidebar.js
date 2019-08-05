import React from 'react';
import {Link} from 'react-router-dom';
import QRCode from 'qrcode.react';

class Sidebar extends React.Component {
    render() {
        return (
            <div className="sidebar" style={{backgroundColor: 'transparent'}}>
                <div className="user" style={{flexDirection: 'column'}}>
                    <h1 style={{marginBottom: '1rem'}}>Scan with your camera</h1>
                    <QRCode value="exp://83.252.175.1:19000" />
                </div>
                <div className="sidebar__navigation">
                    <ul>
                        <li>
                            <Link to={'/shows'} className="btn-text">
                                <i className="fas fa-video"></i> Add Show
                            </Link>
                        </li>

                        <li>
                            <Link to={'/posts'} className="btn-text">
                                <i className="fas fa-blog"></i> Add Post
                            </Link>
                        </li>

                        <li><a className="btn-text" href="#"><i className="fas fa-photo-video"></i>Add Image</a></li>
                        <li><a className="btn-text" href="#"><i className="fas fa-users"></i> Add User</a></li>
                        <li><a className="btn-text" href="#"><i className="fas fa-chart-bar"></i> View Report</a></li>
                        <li><a className="btn-text" href="#"><i className="fas fa-cogs"></i> Settings</a></li>
                        <li><a className="btn-text" href="#"><i className="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        )
    }
}

export default Sidebar;
