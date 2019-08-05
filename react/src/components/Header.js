import React from 'react';
import { Link } from 'react-router-dom';

class Header extends React.Component {
    render() {
        return (
            <header>
                <nav id="main-nav">
                    <div className="wrapper">
                        <ul>
                            <li>
                                <Link to={'/'}>
                                    <span>Home</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/news'}>
                                    <span>News</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/interesting'}>
                                    <span>Interesting</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/mazahia'}>
                                    <span>Fun</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/international'}>
                                    <span>International</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/science'}>
                                    <span>Science</span>
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
