import React, {Component} from 'react';
import {Route, Switch} from 'react-router-dom';


import Ni from './components/Ni';
import FormVideo from './components/FormVideo';
import FormPost from './components/FormPost';
import Index from './components/Index';
import New from './components/New';

class App extends Component {

    render() {
        return (
            <Switch>
                <Route exact path={`/index`} component={Index}/>
                <Route exact path={`/`} component={Index}/>

                <Route exact path={`/new`} component={New}/>

                <Route component={Ni}/>
            </Switch>
        );
    }
}

export default App;

