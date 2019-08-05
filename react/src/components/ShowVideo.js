import React from 'react';
import {withRouter} from 'react-router-dom';
import {videoDeleteAction} from "../actions/VideoAction";
import {connect} from "react-redux";
import {apiServer} from "../common/constants";

class ShowVideo extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            video: null,
            show: false
        };

        this.refVideo = React.createRef();
        this.refContainer = window.container = React.createRef();
    }

    componentDidMount() {
        this.setState({video: this.props.video});
    }

    componentWillReceiveProps(nextProps, nextContext) {
        this.setState({video: nextProps.video});
    }

    render() {
        let {video} = this.state;
        return (
            <div style={styles.container}>
                <a onClick={(e) => this.props.close(e)} href='#' style={styles.close}>
                    <i className="far fa-times-circle"></i>
                </a>
                <div style={{display: 'block'}}>
                    <video style={{width: '100%'}} ref={this.refVideo} autoPlay={!!video} controls
                           src={video && apiServer + video.video}></video>
                </div>
            </div>
        )
    }
}

/**
 * Get data from store
 * @param state
 */
const mapStateToProps = state => ({
    posts: state.posts,
    videos: state.videos,
});

/**
 * Import action from dir action above - but must be passed to connect method in order to trigger reducer in store
 * @type {{UserUpdate: UserUpdateAction}}
 */
const mapActionsToProps = {
    videoDeleteAction
};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(ShowVideo));

const styles = {
    container: {
        position: 'fixed',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center',
        backgroundColor: 'black',
        top: '25%',
        zIndex: 100,
        border: '5px solid #013352',
        borderRadius: '3px',
        width: '50%',
        height: '50%'
    },
    close: {
        color: 'white',
        fontSize: '30px',
        position: 'absolute',
        left: '15px',
        top: '5px'
    }
};