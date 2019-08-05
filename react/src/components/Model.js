let Parser = require("rss-parser");
let fetch = require('node-fetch');
const parseString = require('xml2js').parseString;

class Model {
    constructor(url) {
        console.log('Inti' + url);
        this.url = url;
        this.fetchUrl = this.fetchUrl.bind(this);
    }

    fetchUrl() {
        const proxyurl = "https://cors-anywhere.herokuapp.com/";
        console.log('Fetching url : ' + proxyurl + this.url);
        fetch(this.url) // https://cors-anywhere.herokuapp.com/https://example.com
            .then(response => response.text())
            .then(contents => {
                const parser = new Parser({
                    customFields: {
                        item: ['image'],
                    }
                });

                const feed = parser.parseString(contents).then(contents => {
                    const items = contents.items;
                    items.map( item => {
                        console.log(item.title);
                        console.log(item.image);
                    })
                });
            })
            .catch((err) => console.log("Can’t access " + this.url + " response. Blocked by browser?" + err.toString()))
    }
}

const m = new Model('http://urdu.news18.com/rss/eye-catcher.xml');
m.fetchUrl();
