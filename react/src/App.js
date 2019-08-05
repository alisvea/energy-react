import React, {Component} from 'react';
import {Route, Switch} from 'react-router-dom';


import Ni from './components/Ni';
import Sidebar from './components/Sidebar';
import FormVideo from './components/FormVideo';
import FormPost from './components/FormPost';

class App extends Component {

    render() {
        return (
            <Switch>
                <Route exact path={`/posts`} component={FormPost}/>
                <Route exact path={`/shows`} component={FormVideo}/>
                <Route exact path={`/`} component={FormVideo}/>
                <Route exact path={`/shows/:id`} component={FormVideo}/>
                <Route component={Ni}/>
            </Switch>
        );
    }
}

export default App;

