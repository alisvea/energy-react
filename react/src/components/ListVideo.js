import React from 'react';
import {Link, withRouter} from 'react-router-dom';
import {videoDeleteAction} from "../actions/VideoAction";
import {connect} from "react-redux";
import ShowVideo from "./ShowVideo";
import {apiServer} from "../common/constants";


const Li = ({video, videoDeleteAction, setPlayingVideo, open, push}) => {
    const handleDelete = (e) => {
        e.preventDefault();
        videoDeleteAction({_id: video._id});
    };

    const handleOnClick = (path) => {
        push(path);
    };

    return (
        <li className="list-group-item" style={{padding: '10px'}}>
            <div style={{display: 'flex'}}>
                <div style={styles.medium} href="#">{video.title}</div>
                <div style={styles.large}>{video.description}</div>
                <div style={styles.medium}>{video.show}</div>
                <div style={styles.small}>{video.season}</div>
                <div style={styles.small}>{video.episode}</div>
                <div style={styles.small}>{video.genre}</div>
                <div style={styles.large}><img onClick={() => open(video)} style={{height: '90px', cursor: 'pointer'}}
                                            src={apiServer + video.image + '?' + Date.now()}/></div>
                <div style={styles.small}>
                    <button onClick={() => handleOnClick('/shows/' + video._id)} className="btn btn--black">Edit</button>
                </div>
                <div style={styles.small}>
                    <button onClick={(e) => handleDelete(e)} className="btn btn--black">Delete</button>
                </div>
            </div>
        </li>
    );
};

class ListVideo extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            playingVideo: null,
            show: false
        };

        this.setPlayingVideo = this.setPlayingVideo.bind(this);
        this.open = this.open.bind(this);
        this.close = this.close.bind(this);
    }

    open(playingVideo) {
        this.setState({show: true, playingVideo});
    }

    close(e) {
        e.preventDefault();
        this.setState({show: false});
        return false;
    }

    setPlayingVideo(playingVideo) {
        this.setState({playingVideo})
    }

    render() {
        const {videos, videoDeleteAction} = this.props;
        return (
            <div className="darkula">
                {
                    this.state.show && <ShowVideo close={this.close} video={this.state.playingVideo}/>
                }
                <ul className="list-group u-margin-top-big">
                    <li className="list-group-item" style={{padding: '10px'}}>
                        <div style={{display: 'flex'}}>
                            <div className="btn-text" style={styles.medium} href="#">Title</div>
                            <div className="btn-text" style={styles.large}>Description</div>
                            <div className="btn-text" style={styles.medium}>Show</div>
                            <div className="btn-text" style={styles.small}>Season</div>
                            <div className="btn-text" style={styles.small}>Episode</div>
                            <div className="btn-text" style={styles.small}>Genre</div>
                            <div className="btn-text" style={styles.large}>Image</div>
                            <div className="btn-text" style={styles.small}>
                                E
                            </div>
                            <div className="btn-text" style={styles.small}>
                                D
                            </div>
                        </div>
                    </li>
                    {
                        videos.map((video, i) => <Li push={this.props.history.push} open={this.open} setPlayingVideo={this.setPlayingVideo}
                                                     videoDeleteAction={videoDeleteAction} key={i} video={video}></Li>)
                    }
                </ul>
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

export default withRouter(connect(mapStateToProps, mapActionsToProps)(ListVideo));

const styles = {
    large : {
        flex: 8,
        backgroundColor: 'transparent',
    },
    medium: {
        flex: 6,
        backgroundColor: 'transparent',
    },
    small: {
        flex: 4,
        backgroundColor: 'transparent',
        flexShrink: 1
    },
    mini: {
        flex: 2,
        backgroundColor: 'transparent',
    }
};
