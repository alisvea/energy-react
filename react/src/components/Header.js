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
                                <Link to={'/byt-elavtal/?cons=4000&prod=888&v=1'}>
                                    <span>byt-elavtal</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/erbjudande20?cons=4000&prod=888&v=1'}>
                                    <span>erbjudande20</span>
                                </Link>
                            </li>

                            <li>
                                <Link to={'/employee-discount?cons=4000&prod=888&v=1'}>
                                    <span>employee-discount</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/erbjudande19?cons=4000&prod=888&v=1'}>
                                    <span>erbjudande19</span>
                                </Link>
                            </li>

                        </ul>

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
