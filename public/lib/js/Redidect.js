const getIframeRedidect = () => {
    window.addEventListener('message', function (event) {
        if (event.origin === window.location.protocol + '//' + window.location.host + (window.location.port ? ':' + window.location.port : '')) {
            window.location.href = event.data;
            console.log(event)
        }
    });
}

const iframeRedidect = rute => {
    window.parent.postMessage(rute, window.location.protocol + '//' + window.location.host + (window.location.port ? ':' + window.location.port : ''));
}

const redirectTo = rute => {
    window.location.href = rute;
}

export { getIframeRedidect, iframeRedidect, redirectTo }