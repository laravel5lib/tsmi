import {Controller} from "stimulus"

export default class extends Controller {

    /**
     *
     */
    connect() {

        let controller = this;


        $(window).scroll(function () {
            if ($(window).scrollTop() >= $(document).height() - $(window).height() - 300) {
                controller.loadMore();
            }
        });


/*
        $(window).on('scroll', function () {
            if (($(document).height() - $(window).scrollTop() + $(window).height()) < ($(document).height() + $(document).innerHeight()) * 0.30) {
                controller.loadMore();
            }
        });
        */
    }

    /**
     *
     */
    loadMore() {

        if (parseInt(this.data.get("load"))) {
            return;
        }
        this.data.set("load", 1);

        let paginate = parseInt(this.data.get("paginate"));
        let type = this.data.get("type");
        let controller = this;

        axios.get('/load/' + type + '/' + this.data.get("created"), {
            params: {
                page: paginate
            }
        })
            .then(function (response) {
                $('.' + type + '-news').append(response.data);
                controller.data.set("paginate", paginate + 1);
                controller.data.set("load", 0);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
}