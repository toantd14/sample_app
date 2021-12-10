$(document).ready(function () {
    $('.file-input-videos1').on('change', function (event) {
        getThumbnailVideo('.file-input-thumbnail1', event);
    });
    $('.file-input-videos2').on('change', function (event) {
        getThumbnailVideo('.file-input-thumbnail2', event);
    });
    $('.file-input-videos3').on('change', function (event) {
        getThumbnailVideo('.file-input-thumbnail3', event);
    });
    $('.file-input-videos4').on('change', function (event) {
        getThumbnailVideo('.file-input-thumbnail4', event);
    });


    function getThumbnailVideo(inputThumbnail, event) {
        var file = event.target.files[0];
        var fileReader = new FileReader();
        fileReader.onload = function () {
            var blob = new Blob([fileReader.result], { type: file.type });
            var url = URL.createObjectURL(blob);
            var video = document.createElement('video');
            var timeupdate = function () {
                if (snapImage()) {
                    video.removeEventListener('timeupdate', timeupdate);
                    video.pause();
                }
            };
            var snapImage = function () {
                var canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var image = canvas.toDataURL();
                var success = image.length > 100000;
                if (success) {
                    var img = document.createElement('img');
                    img.src = image;
                    $(inputThumbnail).val(image)
                }
                return success;
            };
            video.addEventListener('timeupdate', timeupdate);
            video.preload = 'metadata';
            video.src = url;
            // Load video in Safari / IE11
            video.muted = true;
            video.playsInline = true;
            video.play();
        };
        fileReader.readAsArrayBuffer(file);
    }
})

window.postMessageToNative = function (msg) {
    if (getMobileOperatingSystem() == "Android") {
        Webview.postMessage(msg);

        return;
    }

    if (getMobileOperatingSystem() == "iOS") {
        window.webkit.messageHandlers.Webview.postMessage(msg);

        return;
    }
}

window.postObjectToNative = function (msg) {
    if (getMobileOperatingSystem() == "Android") {
        Webview.postMessage(JSON.stringify(msg));

        return;
    }

    if (getMobileOperatingSystem() == "iOS") {
        window.webkit.messageHandlers.Webview.postMessage(msg);

        return;
    }
}

window.getMobileOperatingSystem = function () {
    var userAgent = navigator.userAgent || navigator.vendor || window.opera;

    if (/android/i.test(userAgent)) {
        return "Android";
    }

    if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
        return "iOS";
    }

    return "unknown";
}

$('.datepicker').datepicker({
    format: 'yyyy/mm/dd',
    language: "ja",
});

$(".date_picker_only_year").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    language: "ja",
});

$(".date_picker_only_month").datepicker({
    format: "mm",
    viewMode: "months",
    minViewMode: "months",
    language: "ja",
});
