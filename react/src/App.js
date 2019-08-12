import React, {Component} from 'react';
import {Route, Switch, BrowserRouter} from 'react-router-dom';


import Ni from './components/Ni';
import Index from './components/Index';
import New from './components/New';

class App extends Component {

    render() {
        return (
            <BrowserRouter basename="/">
                <Switch>
                    <Route exact path={`/index`} component={Index}/>

                    <Route exact path={`/byt-elavtal/`} component={Index}/>
                    <Route exact path={`/erbjudande20/`} component={Index}/>
                    <Route exact path={`/employee-discount/`} component={Index}/>
                    <Route exact path={`/erbjudande19/`} component={Index}/>

                    <Route exact path={`/`} component={Index}/>

                    <Route exact path={`/new`} component={New}/>

                    <Route component={Ni}/>
                </Switch>
            </BrowserRouter>
        );
    }
}

export default App;

