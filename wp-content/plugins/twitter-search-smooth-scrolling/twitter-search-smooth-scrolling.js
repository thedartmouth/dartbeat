var SmoothTwitter = SmoothTwitter || {};

SmoothTwitter.TwitterControl = function (o) {
    var self = this;
    var element;
    var searchQuery;
    var refreshInterval;
    var tweetInterval;
    var renderer;
    var tweets = [];
    var index = 0;

    var init = function () {
        element = jQuery(".tweetContainer", o);
        searchQuery = jQuery(element).attr("search-query");

        // How many milliseconds between collecting new sets of tweets from twitter?
        refreshInterval = parseInt(jQuery(element).attr("refresh-interval"));

        // How many milliseconds between rendering of individual tweets?
        tweetInterval = parseInt(jQuery(element).attr("tweet-interval"));

        // How many milliseconds before tweet is fully faded in?
        tweetAnimationDuration = parseInt(jQuery(element).attr("tweet-animation-duration"));

        if (isNaN(tweetInterval) || tweetInterval == 0) {
            tweetInterval = 3000;  // Default 3 seconds between rendering of individual tweets
        }

        self.getTweets();
        if (refreshInterval !== undefined && refreshInterval > 0) {
            refreshInterval = setInterval(self.getTweets, refreshInterval);
        }
    };

    this.getTweets = function () {
        var uri = "http://search.twitter.com/search.json?q=" + encodeURIComponent(searchQuery) + "&callback=?";
        jQuery.getJSON(uri, function (data) {
            tweets = data.results;

            if (tweets === undefined || tweets.length == 0) {
                return;
            }

            index = 0;
            renderTweet();

            if (renderer === undefined) {
                renderer = setInterval(renderTweet, tweetInterval);
            }
        });
    };

    var wrap = function (value, lbound, ubound) {
        if (value < lbound) {
            return ubound;
        }
        else if (value > ubound) {
            return lbound;
        }
        return value;
    };

    var renderTweet = function () {
        var currentTweet = tweets[index];

        if (jQuery(element).children().size() == 5) {
            jQuery(element).children().last().remove();
        }

        if (currentTweet.text.charAt(0) != '@') {
            var tweet = jQuery("<li></li>").html(currentTweet.text);

            // analyse our tweet text and turn urls into working links, hash tags into search links, and @replies into profile links.
            tweet.html(
                tweet.html()
                    .replace(/((ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?)/gi, '<a href="$1">$1</a>')
                    .replace(/(^|\s)#(\w+)/g, '$1<a href="http://search.twitter.com/search?q=%23$2">#$2</a>')
                    .replace(/(^|\s)@(\w+)/g, '$1<a href="http://twitter.com/$2">@$2</a>'))
            .prepend('<a class="autorName" href="http://www.twitter.com/' + currentTweet.from_user + '">' + currentTweet.from_user + '</a>')
            .prependTo(element)
            .css('opacity', 0.0);

            var height = tweet.height();
            tweet.css({'list-style-type' : 'none', 'background' : 'none', 'height' : 0.0}).animate({ opacity: 1.0, height: height }, tweetAnimationDuration);
        }

        index = wrap(index + 1, 0, tweets.length - 1);
    };

    init();
};

