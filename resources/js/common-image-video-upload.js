
function readURL(input, positionImage) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#btnInputUpload' + positionImage).css('display', 'none');
            $('.file-label-images' + positionImage).css('display', 'none');
            $('#filePreview' + positionImage).css('display', 'block');
            $('.img-upload-preview' + positionImage).attr('src', e.target.result);
            $('.img-upload-name-preview' + positionImage).text(input.files[0].name);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function readURLVideo(input, positionVideo) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        var fileSize = input.files[0].size / 1024 / 1024;
        if (fileSize <= maxVideoSize) {
            reader.onload = function () {
                $('#btnVideoUpload' + positionVideo).css('display', 'none');
                $('.file-label-videos' + positionVideo).css('display', 'none');
                $('#videoPreview' + positionVideo).css('display', 'block');
                $('.video-upload-preview' + positionVideo + ' source').attr('src', URL.createObjectURL(input.files[0])).parent()[0].load();
                $('.video-upload-name-preview' + positionVideo).text(input.files[0].name);
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            alert("大きすぎるファイルはアップロードできません !");
        }
    }
}

function readURLImageEdit(input, positionImage) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#btnEditInputUpload' + positionImage).css('display', 'none');
            $('.file-label-images' + positionImage).css('display', 'none');
            $('#filePreviewEdit' + positionImage).css('display', 'block');
            $('.img-upload-preview' + positionImage).attr('src', e.target.result);
            $('.img-upload-name-preview' + positionImage).text(input.files[0].name);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#btnVideoUpload1").change(function () {
    readURLVideo(this, 1);
});

readURLVideo($('input[name="video1"]'), 1)

$("#btnVideoUpload2").change(function () {
    readURLVideo(this, 2);
});
$("#btnVideoUpload3").change(function () {
    readURLVideo(this, 3);
});
$("#btnVideoUpload4").change(function () {
    readURLVideo(this, 4);
});

$("#btnInputUpload1").change(function () {
    readURL(this, 1);
});
$("#btnInputUpload2").change(function () {
    readURL(this, 2);
});
$("#btnInputUpload3").change(function () {
    readURL(this, 3);
});
$("#btnInputUpload4").change(function () {
    readURL(this, 4);
});

//edit
$("#btnEditInputUpload1").change(function () {
    readURLImageEdit(this, 1);
});
$("#btnEditInputUpload2").change(function () {
    readURLImageEdit(this, 2);
});
$("#btnEditInputUpload3").change(function () {
    readURLImageEdit(this, 3);
});
$("#btnEditInputUpload4").change(function () {
    readURLImageEdit(this, 4);
});

$(document).on('click', '.delete-btn', function () {
    let thisElement = $(this);
    $('#isUpdateImage' + thisElement.attr('image')).attr('value', 1);
    $('#filePreviewEdit' + thisElement.attr('image')).css('display', 'none');
    $('#div-input-image' + thisElement.attr('image')).css('display', 'block');
    $('#file-label-images' + thisElement.attr('image')).css('display', 'block');
    $('#btnEditInputUpload' + thisElement.attr('image')).css('display', 'block').val('');
})

$(document).on('change', '.file-input-images', function () {
    $('#isUpdateImage' + $(this).attr('image')).attr('value', 1);
})

$(document).on('click', '.btn-delete-video', function () {
    let thisElement = $(this);
    $('#isUpdateVideo' + thisElement.attr('video')).attr('value', 1);
    $('#videoPreview' + thisElement.attr('video')).css('display', 'none');
    $('#div-input-video' + thisElement.attr('video')).css('display', 'block');
    $('.file-label-videos' + thisElement.attr('video')).css('display', 'block');
    $('#btnVideoUpload' + thisElement.attr('video')).css('display', 'block').val('');
})

$(document).on('change', '.file-input-videos', function () {
    $('#isUpdateVideo' + $(this).attr('video')).attr('value', 1);
})
