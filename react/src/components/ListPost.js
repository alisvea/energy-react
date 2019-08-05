import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";
import {postsDeleteAction} from "../actions/PostsAction";

const Li = ({post, postsDeleteAction}) => {
    const handleDelete = (e) => {
        e.preventDefault();
        postsDeleteAction({_id: post._id});
    };
    return (
        <li className="list-group-item" style={{padding: '1.3rem'}}>
            <div style={{display: 'flex'}}>
                <div style={{flex: 4}} href="#">{post.title}</div>
                <div style={{flex: 8}}>{post.description}</div>
                <div style={{flex: 1}}>
                    <button className="btn btn--green">Edit</button>
                </div>
                <div style={{flex: 1}}>
                    <button onClick={(e) => handleDelete(e)} className="btn btn--black">Delete</button>
                </div>
            </div>
        </li>
    );
};

class ListPost extends React.Component {
    render() {
        const {posts, postsDeleteAction} = this.props;
        return (
            <ul className="list-group u-margin-top-big">
                {
                    posts.map((post, i) => <Li postsDeleteAction={postsDeleteAction} key={i} post={post}></Li>)
                }
            </ul>
        )
    }
}

/**
 * Get data from store
 * @param state
 */
const mapStateToProps = state => ({
    posts: state.posts,
});

/**
 * Import action from dir action above - but must be passed to connect method in order to trigger reducer in store
 * @type {{UserUpdate: UserUpdateAction}}
 */
const mapActionsToProps = {
    postsDeleteAction
};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(ListPost));
