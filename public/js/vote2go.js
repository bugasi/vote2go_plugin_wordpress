(function(document) {
    const el =  document.getElementsByClassName('vote2go_wrapper');
    for (var i = 0; i < el.length ; i++) {
        const e = el[i];
        const iframe = document.createElement('iframe');
        iframe.height = e.dataset.v2gFrameHeight;
        iframe.width = e.dataset.v2gFrameWidth;
        var params = "display=embedded";
        if (e.dataset.v2gCriteria) {
            params += "&criteria=" + e.dataset.v2gCriteria;
        }
        iframe.src = encodeURI("https://public.vote2go.de/vote/" + e.dataset.v2gVoteId + "?" + params);
        iframe.seamless=true;
        e.appendChild(iframe);
    }
}(document));