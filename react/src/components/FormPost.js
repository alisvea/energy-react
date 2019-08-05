import React from 'react';
import {connect} from "react-redux";
import {withRouter} from "react-router-dom";
import ListPost from './ListPost';
import {postsAddAction} from "../actions/PostsAction";
import Sidebar from "./Sidebar";

class FormPost extends React.Component {
    constructor(props) {
        super(props);
        this.refTitle = React.createRef();
        this.refDescription = React.createRef();
        this.submitForm = this.submitForm.bind(this);
    }

    submitForm(e) {
        e.preventDefault();
        const title = this.refTitle.current.value;
        const description = this.refDescription.current.value;
        console.log(title, description);
        this.props.postsAddAction({title, description, author_id: 1});
        this.refTitle.current.value = '';
        this.refDescription.current.value = '';
    }

    render() {
        return (
            <div className="row">
                <div className="col-1-of-4" style={{minHeight: '100%'}}>
                    <Sidebar/>
                </div>
                <div className="col-3-of-4">
                    <div className="container">
                        <div className="book__form">
                            <form className="form"
                                  action="/upload"
                                  method="post"
                                  encType="multipart/form-data"
                            >
                                <div className="u-margin-bottom-small">
                                    <h2 className="heading-secondary">
                                        Create post
                                    </h2>
                                </div>

                                <div className="form__group">
                                    <input ref={this.refTitle} className="form__input" id="title" placeholder="Title"
                                           required type="text"/>
                                    <label className="form__label" htmlFor="title">Title</label>
                                </div>

                                <div className="form__group">
                                    <input ref={this.refDescription} className="form__input" id="description"
                                           placeholder="Description" required type="text"/>
                                    <label className="form__label" htmlFor="description">Description</label>
                                </div>

                                <div className="u-margin-top-small">
                                    <button className="btn btn--black" href="#" onClick={(e) => this.submitForm(e)}>
                                        <i className="fas fa-save"></i> &nbsp; Save
                                    </button>
                                </div>

                            </form>
                        </div>

                        <div className="darkula">
                            <ListPost/>
                        </div>

                    </div>
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
});

/**
 * Import action from dir action above - but must be passed to connect method in order to trigger reducer in store
 * @type {{UserUpdate: UserUpdateAction}}
 */
const mapActionsToProps = {
    postsAddAction
};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(FormPost));
