<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$curUser = currentuser_session();
$feeling = $curUser['feeling'];
?>

<!--Content-->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="profile inspiration">
                        <!--left menu-->
                        <?php load_view('includes/left-menu.php'); ?>
                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <div class="profile-cont">
                                    <div class="profile-header">
                                        <h3>Michael Alli</h3>
                                       <?php render_view('feeling'); ?>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="creat-post">
                                        <h2>Upload Media</h2>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="new-posts">
                                        <!--                                        <div class="new-title col-sm-4 col-sm-offset-4">
                                                                                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title"/>
                                                                                </div>-->
                                        <div class="clearfix"></div>

                                        <div class="media-icons marginTop10">
                                            <div class="col-sm-3 col-xs-6">
                                                <a href="javascript:void(0)" id="image-post-btn"><img src="<?php echo base_url(); ?>assets/images/camera-img.png" alt="" title=""></a>
                                            </div>

                                            <div class="col-sm-3 col-xs-6">
                                                <a href="javascript:void(0)" id="text-post-btn"><img src="<?php echo base_url(); ?>assets/images/txt-img.png" alt="" title=""></a>
                                            </div>
                                            <div class="clear"></div>
                                        </div>

                                        <div class="new-title col-sm-4 ">
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title"/>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="editor">
                                            <div class="col-sm-8 text-container hidden">
                                                <div class="">
                                                    <textarea class=" form-control" rows="6" id="text-content" name="text-content" placeholder="Write your text here"></textarea>
                                                </div>
                                                <div>
                                                    <div class="post-btns">
                                                        <a href="javascript:void(0)" id="post-text">post</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 image-container">
                                                <div class="edit-order">
                                                    <div class="order-numbers col-sm-12">

                                                        <div class="container">


                                                            <!-- The fileinput-button span is used to style the file input field as button -->
                                                            <span class="btn btn-success fileinput-button">
                                                                <i class="glyphicon glyphicon-plus"></i>
                                                                <span>Add files...</span>
                                                                <!-- The file input field used as target for the file upload widget -->
                                                                <input id="fileupload" type="file" name="files[]" multiple>
                                                            </span>

                                                            <br>

                                                            <!-- The container for the uploaded files -->
                                                            <div id="files" class="files"></div>
                                                            <br>
                                                            <div id="progress" class="progress col-sm-3" style="padding:0px;">
                                                                <div class="progress-bar progress-bar-success"></div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="clear"></div>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="post-btns">
                                                    <a href="#" id="post-all">post</a>
                                                </div>
                                            </div>

                                            <div class="clear"></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>	
<script type="text/javascript">
    $(document).ready(function () {
//        tag a friend
        $('#title').on('keyup', function (e) {
            var input = $(this).val();
//            console.log(input.substr(input.indexOf("@") + 1));
            if ($('#title').val().indexOf('@') > -1) {
                $("#title").autocomplete({
                    source: function (request, response) {

                        $.ajax({
                            url: window.base_url + 'Users/search_user',
                            dataType: "json",
                            data: {
                                value: input.substr(input.indexOf("@") + 1)
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        var inputVal = input.substr(0, input.indexOf('@'));
                        var temp = '<input type="hidden" value="' + ui.item.id + '" name="tag-user[]"/>';
                        $(temp).appendTo($('#title'));
//                        console.log(inputVal);
                        $('#title').val(inputVal.concat(ui.item.name));
                    }
                });
            }
        });




        $('#post-text').on('click', function () {
            var content = $('#text-content').val();
            var title = $('#title').val();

            var values = [];
            $('input[name="tag-user[]"]').each(function () {
                values.push($(this).val());
            });
            if (title.length == 0 || content.length == 0) {
                return false;
            }
            var data = 'content=' + content + '&title=' + title + '&tagUser=' + values;

            $.ajax({
                url: window.base_url + 'Profile/post_text',
                data: data,
                type: 'POST',
                success: function (postBack) {
                    var result = $.parseJSON(postBack);
//                    console.log(result);return;
                    if (result.msg == 1) {
                        window.location.href = window.base_url + 'Profile/my_reell';
                    } else {
                        var error = '<span class="error">Error: please try again.</span>';
                        $(error).appendTo('#text-content');
                    }
                }
            });
        });

        $('#text-post-btn').click(function () {
            $('.text-container').removeClass('hidden');
            $('.image-container').addClass('hidden');
        });

        $('#image-post-btn').click(function () {
            $('.image-container').removeClass('hidden');
            $('.text-container').addClass('hidden');
        });
    }
    );

    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url(); ?>assets/jQuery-File-Upload/server/php/',
                allData = [],
                uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .text('Processing...')
                .on('click', function () {
                    var $this = $(this),
                            data = $this.data();

                    $this.off('click')
                            .text('Abort')
                            .on('click', function () {
                                $this.remove();
                                data.abort();
                            });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true,

        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                        .append($('<span/>').text(file.name));
                if (!index) {
                    node
                            .append('<br>')
                            .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);



            });
//            $("#post-all").off('click').on('click', function (e) {
//                e.preventDefault();
//                data.title = $('#title').val();
//                data.submit();
//            });
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);
            if (file.preview) {
                node
                        .prepend('<br>')
                        .prepend(file.preview);
            }
            if (file.error) {
                node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button').remove();
//                        .text('Upload')
//                        .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                    );
        }).on('fileuploaddone', function (e, data) {

            $.each(data.result.files, function (index, file) {
                allData.push(file);
                if (file.url) {
                    var link = $('<a>')
                            .attr('target', '_blank')
                            .prop('href', file.url);
                    $(data.context.children()[index])
                            .wrap(link);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                }
            });
            //                console.log(file);
            $("#post-all").off('click').on('click', function (e) {
                e.preventDefault();
                var postData = [];
                postData['images'] = $.map(allData, function (el) {
                    return el.name;
                });
                var title = $('#title').val();
                var tagUser = $('input[name=tag-user]').val();
//                console.log(tagUser);
//                return;
//                console.log(postData);
//                return;
                var data = 'images=' + postData['images'] + '&title=' + title + '&type=1';
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>Profile/upload_post',
                    data: data,
                    success: function (callBack) {
//                        var data = $.parseJSON(callBack);
                        $("#post-all").remove();
                        $(".post-btns").html('<span class="alert alert-success marginTop10">Data uploaded successfully.</span>');
                        setTimeout(function () {
                            window.location.href = window.base_url + 'Main';
                        }, 2000);
                    }
                });
            });

        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>