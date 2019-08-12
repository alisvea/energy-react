import React from 'react';
import {Link} from 'react-router-dom';

class Header extends React.Component {
    render() {
        return (
            <header>
                <nav id="main-nav">
                    <div className="wrapper">
                        <ul>
                            <li>
                                <Link to={'/?cons=4000&prod=888&v=1'}>
                                    <span>Existing</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/new?cons=4000&prod=888&v=1'}>
                                    <span>New</span>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
        )
    }
}

export default Header;
