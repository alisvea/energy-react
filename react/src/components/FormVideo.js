import React from 'react';
import {withRouter} from 'react-router-dom';
import {videoReadAction, videoAddAction, videoUpdateAction, videoSearchAction} from "../actions/VideoAction";
import {connect} from "react-redux";
import ListVideo from './ListVideo';
import Autocomplete from './Autocomplete';
import Dropdown from 'react-dropdown'
import '../dropdown.css';
import Sidebar from "./Sidebar";

const options = [
    {value: 'Pop', label: 'Pop'},
    {value: 'Jazz', label: 'Jazz'},
    {value: 'Rock', label: 'Rock'},
    {value: 'disco', label: 'Disco'},
    {value: 'classical', label: 'Classical'},
    {value: 'techno', label: 'Techno'},
];

const techCompanies = [
    {label: "Apple", value: 1},
    {label: "Facebook", value: 2},
    {label: "Netflix", value: 3},
    {label: "Tesla", value: 4},
    {label: "Amazon", value: 5},
    {label: "Alphabet", value: 6},
];

class FormVideo extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            updating: false,
            genre: null,
            show: {
                title: '',
                description: '',
                show: '',
                season: '',
                episode: '',
                genre: '',
            },
            display: 'none',
            items: [
                {show: 'Label 1', value: 'Value 1'},
                {show: 'Label 2', value: 'Value 2'},
                {show: 'Label 3', value: 'Value 3'},
            ]
        };
        this.refImage = React.createRef();
        this.refVideo = React.createRef();
        this.submitForm = this.submitForm.bind(this);
        this.onChange = this.onChange.bind(this);
        this.handleGenreChange = this.handleGenreChange.bind(this);
        this.setShowValue = this.setShowValue.bind(this);
    }

    componentDidMount() {
        const {id} = this.props.match.params;
        console.log('Match', id, this.props.match);

        if (id) {
            const {videos} = this.props;
            const show = videos && videos.find(song => {
                return song._id === id;
            });
            this.setState({show, updating: true});
        }
    }

    componentWillReceiveProps(nextProps, nextContext) {
        const {id} = nextProps.match.params;

        const {videos} = this.props;
        const show = videos && videos.find(song => {
            return song._id === id;
        });
        if (show) {
            this.setState({show, updating: true});
        }
        console.log('Match', id, show);

        const {search} = nextProps;
        if (search && search.length > 0) {
            this.setState({items: search});
        }
    }

    handleGenreChange(genre) {
        console.log('handleGenreChange', genre);
        const {show} = this.state;
        show.genre = genre.value;
        this.setState({show});
    }

    submitForm(e) {
        e.preventDefault();
        const image = this.refImage.current.files;
        const video = this.refVideo.current.files;
        const {show} = this.state;
        show.image = image[0];
        show.video = video[0];

        const formData = new FormData();

        Object.keys(show).map(key => {
            formData.append(key, show[key]);
        });

        console.log('onSubmit: ', formData);

        if (this.props.match.params.id) {
            console.log('Updating in component: ', show);
            this.props.videoUpdateAction({id: show._id, formData});
            setTimeout(() => {
                this.props.videoReadAction();
            }, 5000, this)
        } else {
            this.props.videoAddAction(formData);
        }

        this.refImage.current.value = '';
        this.refVideo.current.value = '';
    }

    onChange(e) {
        /* console.log('Genre: ', genre);
        this.setState({genre: genre.value}); */
        e.preventDefault();
        const {show} = this.state;
        show[e.target.id] = e.target.value;
        this.setState({show});
        if (e.target.id === 'show') {
            this.searchShows(e.target.value);
        }
    }

    searchShows(s) {
        if (s.length > 3) {
            console.log(s);
            this.props.videoSearchAction(s);
        }
    }


    setShowValue(newShow) {
        const {show} = this.state;
        show.show = newShow;
        this.setState({show, display: 'none'})
    }

    render() {
        const {show, items} = this.state;

        return (
            <div>
                <div className="row" style={{marginBottom: '0'}}>
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
                                            Upload video
                                        </h2>
                                    </div>

                                    <div className="form__group">
                                        <input id="title" className="form__input" id="title" placeholder="Title"
                                               required
                                               type="text" value={show.title} onChange={e => this.onChange(e)}/>
                                        <label className="form__label" htmlFor="title">Title</label>
                                    </div>

                                    <div className="form__group">
                                        <input id="description" className="form__input" id="description"
                                               placeholder="Description" required type="text" value={show.description}
                                               onChange={e => this.onChange(e)}/>
                                        <label className="form__label" htmlFor="description">Description</label>
                                    </div>

                                    <div className="form__group">
                                        <input id="show" className="form__input" id="show" autoComplete="off"
                                               placeholder="Show" required type="text" value={show.show}
                                               onChange={e => this.onChange(e)}
                                               onClick={() => this.setState({display: 'block'})}/>
                                        <label className="form__label" htmlFor="show">Show</label>
                                        <Autocomplete display={this.state.display} onClick={this.setShowValue}
                                                      items={items}/>

                                    </div>

                                    <div className="form__group">
                                        <input id="season" className="form__input" id="season"
                                               placeholder="Season" required type="text" value={show.season}
                                               onChange={e => this.onChange(e)}/>
                                        <label className="form__label" htmlFor="season">Season</label>
                                    </div>

                                    <div className="form__group">
                                        <input id="episode" className="form__input" id="episode"
                                               placeholder="Episode" required type="text" value={show.episode}
                                               onChange={e => this.onChange(e)}/>
                                        <label className="form__label" htmlFor="episode">Episode</label>
                                    </div>

                                    <div className="form__group">
                                        <Dropdown options={options} value={show.genre}
                                                  placeholder="Select an option" onChange={this.handleGenreChange}/>
                                        <label className="form__label" htmlFor="genre">Genre</label>
                                    </div>

                                    <div className="form__group">
                                        {
                                            /* <Select className="select" options={techCompanies}/> */
                                        }

                                    </div>

                                    <div className="form__group">
                                        <input ref={this.refImage} name="image" className="form__input" id="image"
                                               placeholder="Image" required type="file" multiple/>
                                        <label className="form__label" htmlFor="image">Image</label>
                                    </div>

                                    <div className="form__group">
                                        <input ref={this.refVideo} name="video" className="form__input" id="video"
                                               placeholder="Video" required type="file" multiple/>
                                        <label className="form__label" htmlFor="video">Video</label>
                                    </div>

                                    <div className="u-margin-top-small">
                                        <button className="btn btn--black" onClick={(e) => this.submitForm(e)}>
                                            <i className="fas fa-cloud-upload-alt"></i> &nbsp; Upload
                                        </button>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>

                <div className="row">
                    <div className="col-1-of-1" style={{padding: '5rem'}}>
                        <ListVideo/>
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
    videos: state.videos,
    search: state.search
});

/**
 * Import action from dir action above - but must be passed to connect method in order to trigger reducer in store
 * @type {{UserUpdate: UserUpdateAction}}
 */
const mapActionsToProps = {
    videoAddAction,
    videoUpdateAction,
    videoReadAction,
    videoSearchAction
};

export default withRouter(connect(mapStateToProps, mapActionsToProps)(FormVideo));
