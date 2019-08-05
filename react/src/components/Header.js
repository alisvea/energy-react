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
                                <Link to={'/'}>
                                    <span>Home</span>
                                </Link>
                            </li>
                            <li>
                                <Link to={'/new'}>
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
