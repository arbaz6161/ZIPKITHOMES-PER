$(function () {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on("click", function () {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on(
        "click",
        function () {
            $(".app-search").toggle(200);
            $(".app-search input").focus();
        }
    );

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();

    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //****************************
    var setsidebartype = function () {
        var width =
            window.innerWidth > 0 ? window.innerWidth : this.screen.width;
        if (width < 1170) {
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
    };
    $(window).ready(setsidebartype);
    $(window).on("resize", setsidebartype);

    $("#tenant_name").keypress(function () {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/^[a-z]+$/);
        return pattern.test(value);
    });

    var BasicDatatablesDataSourceHtml = (function () {
        var superadminBasicDatatable = function () {
            var table = $("#superadmin_basic_datatable");
            table.DataTable({
                responsive: true,
                order: [[3, "desc"]],
                columnDefs: [{ width: 150, targets: 3 }],
            });
        };
        return {
            init: function () {
                superadminBasicDatatable();
            },
        };
    })();

    jQuery(document).ready(function () {
        BasicDatatablesDataSourceHtml.init();
    });
});

$(document).ready(function () {
    $(document).on("change", ".custom-file-input", function () {
        var fd = new FormData();
        var input = $(this);
        var files = input[0].files[0];
        fd.append("file", files);
        var div = input.parents(".custom-file");


        $.ajax({
            url: "/file",
            type: "post",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 0) {
                    input.siblings("[type='hidden']").val(response);
                    input
                        .siblings(".custom-file-label")
                        .addClass("selected")
                        .html("File attached");
                    if (div.next("div[class='preview-image']").length)
                        div.siblings("div[class='preview-image']")
                            .find("img")
                            .attr("src", response);
                    else
                        div.after(
                            $(
                                `<div class="preview-image">
                                    <img class="img-thumbnail" src=${response}>
                                </div>
                                `
                            )
                        );
                    if (div.hasClass("logo-file")) {
                        var formGroup = div.parent();
                        formGroup.removeClass("col-12");
                        formGroup.addClass("col-11");
                        formGroup.after(`<div class='col-1'>
                            <button type='button' class='btn btn-sm btn-clean btn-icon logo-delete'><i class='icon-xl la la-trash-o'></i></button>
                        </div>`);
                    }
                } else {
                    alert("file not uploaded");
                }
            },
        });
    });
    
    $(document).on("change", ".custom-file-input-video", function () {
        var fd = new FormData();
        var input = $(this);
        var files = input[0].files[0];
        fd.append("file", files);
        var div = input.parents(".custom-file");

        $.ajax({
            url: "/file",
            type: "post",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: fd,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response != 0) {
                    input.siblings("[type='hidden']").val(response);
                    input
                        .siblings(".custom-file-label")
                        .addClass("selected")
                        .html("File attached");
                    if (div.next("div[class='preview-video']").length)
                            div.siblings("div[class='preview-video']")
                                .find("video")
                                .attr("src", response);
                    else
                        div.after(
                            $(
                                `<div class="preview-video" >
                                <video class="video-thumbnail" style="width:200px" controls>
                                        <source src=${response} type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                            </div>
                                `
                            )
                        );
                    if (div.hasClass("logo-file")) {
                        var formGroup = div.parent();
                        formGroup.removeClass("col-12");
                        formGroup.addClass("col-11");
                        formGroup.after(`<div class='col-1'>
                            <button type='button' class='btn btn-sm btn-clean btn-icon logo-delete'><i class='icon-xl la la-trash-o'></i></button>
                        </div>`);
                    }
                } else {
                    alert("file not uploaded");
                }
            },
        });
    });

    $("body").on("click", ".delete", function (event) {
        event.preventDefault();
        event.stopPropagation();

        var button = $(this);

        if (confirm("Are you sure?")) {
            var deleteForm = $("#delete-form");
            deleteForm.attr("action", button.attr("href"));
            deleteForm.submit();
        }
    });

    $("body").on("click", ".logout-btn", function (event) {
        event.preventDefault();
        event.stopPropagation();

        var button = $(this);
        var logoutForm = $("#logout-form");

        logoutForm.attr("action", button.attr("href"));

        logoutForm.submit();
    });

    $("body").on("click", ".open-more-modal", function (event) {
        var button = $(this);

        var name = button.data("name");
        var title = button.data("title");
        var description = button.data("description");

        var moreModal = $("#more-modal");

        moreModal.find(".modal-title").text(name);

        var content = `<h6>${title}</h6><br><p>${description}</p>`;
        moreModal.find(".modal-body").html(content);

        moreModal.modal();
    });

    $("body").on("click", ".select-item", function (event) {
        event.preventDefault();
        event.stopPropagation();

        var button = $(this);
        var form = $("#select-item-form");
        var statusInput = form.find("input[name='status']");

        form.attr("action", button.data("url"));

        statusInput.val(button.data("status"));

        form.submit();
    });

    $("body").on("click", ".add-more-image", function () {
        var button = $(this);
        var imageCnt = button.siblings("input[name='image_cnt']");
        var newImageNumber = parseInt(imageCnt.val()) + 1;

        imageCnt.val(newImageNumber);

        button.parent().before(
            $(`<div class="row align-items-start image-row" tabindex="${newImageNumber}">
        <div class="form-group col-md-6 col-sm-12">
            <label for="pic_name${newImageNumber}">Pic ${newImageNumber} Name :</label>
            <input id="pic_name${newImageNumber}" name="images[${newImageNumber}][pic_name]" class="form-control form-control-solid" placeholder="Enter picture ${newImageNumber} name">
        </div>
        <div class="form-group col-md-5 col-11">
            <label for="">&nbsp;</label>
            <div class="custom-file">
                <input type="hidden" name="images[${newImageNumber}][pic_url]">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Drag picture here</label>
            </div>
        </div>
        <div class="form-group col-1">
            <button type="button" class="btn btn-sm btn-clean btn-icon image-delete"><i class="icon-xl la la-trash-o"></i></button>
        </div>
    </div>`)
        );
    });

    $("body").on("click", ".image-delete", function () {
        var button = $(this);
        var row = button.parents(".image-row");
        var form = button.parents("form");
        var afterSiblings = row.nextAll().filter(".image-row");

        row.remove();

        afterSiblings.each(function () {
            var afterEachRow = $(this);
            var rowCurrentIndex = parseInt(afterEachRow.attr("tabindex"));
            var picNameLabel = afterEachRow.find("label[for^='pic_name']");
            var picNameInput = afterEachRow.find("input[id^='pic_name']");
            var picUrlInput = afterEachRow.find("input[type='hidden']");

            afterEachRow.attr("tabindex", rowCurrentIndex - 1);
            picNameLabel.attr("for", `pic_name${rowCurrentIndex - 1}`);
            picNameLabel.text(`Pic ${rowCurrentIndex - 1} Name :`);
            picNameInput.attr("id", `pic_name${rowCurrentIndex - 1}`);
            picNameInput.attr(
                "name",
                `images[${rowCurrentIndex - 1}][pic_name]`
            );
            picNameInput.attr(
                "placeholder",
                `Enter picture ${rowCurrentIndex - 1} name`
            );
            picUrlInput.attr("name", `images[${rowCurrentIndex - 1}][pic_url]`);
        });

        var imageCnt = form.find("input[name='image_cnt']");
        imageCnt.val(imageCnt.val() - 1);
    });

    $("body").on("click", ".add-more-video", function () {
        var button = $(this);
        var videoCnt = button.siblings("input[name='video_cnt']");
        var newVideoNumber = parseInt(videoCnt.val()) + 1;

        videoCnt.val(newVideoNumber);

        button.parent().before(
            $(`<div class="row align-items-start video-row" tabindex="${newVideoNumber}">
                <div class="form-group col-md-6 col-sm-12">
                    <label for="vid_name${newVideoNumber}">${newVideoNumber == 1 ? "Key Video Name" : "Video" + newVideoNumber + " Name"} :</label>
                    <input id="vid_name${newVideoNumber}" name="media[${newVideoNumber}][vid_name]" class="form-control form-control-solid" placeholder="${newVideoNumber == 1 ? 'Enter key video name' : 'Enter video' + newVideoNumber + ' name'}">
                </div>
                <div class="form-group col-md-5 col-11">
                    <label for="">&nbsp;</label>
                    <div class="custom-file d-flex">
                        <input type="text" class="form-control form-control-solid" placeholder="Please enter the video file link or upload a video file" style="border-color: #E4E6EF; border-radius: 0.42rem 0 0 0.42rem;" id="mediaURL${newVideoNumber}" name="media[${newVideoNumber}][custom_vid_url]">
                    </div>
                    <div class="preview-media"></div>
                </div>
                ${newVideoNumber > 1 ? `<div class="form-group col-1">
                    <button type="button" class="btn btn-sm btn-clean btn-icon media-delete"><i class="icon-xl la la-trash-o"></i></button>
                </div>` : ''}
            </div>`)
        );
    });

    $("body").on("click", ".media-delete", function () {
        var button = $(this);
        var row = button.parents(".video-row");
        var form = button.parents("form");
        var afterSiblings = row.nextAll().filter(".video-row");
        row.remove();

        afterSiblings.each(function () {
            var afterEachRow = $(this);
            var rowCurrentIndex = parseInt(afterEachRow.attr("tabindex"));
            var mediaNameLabel = afterEachRow.find("label[for^='vid_name']");
            var mediaNameInput = afterEachRow.find("input[id^='vid_name']");
            var mediaUrlInput = afterEachRow.find("input[type='hidden']");

            afterEachRow.attr("tabindex", rowCurrentIndex - 1);
            mediaNameLabel.attr("for", `vid_name${rowCurrentIndex - 1}`);
            mediaNameLabel.text(`Media ${rowCurrentIndex - 1} Name :`);
            mediaNameInput.attr("id", `vid_name${rowCurrentIndex - 1}`);
            mediaNameInput.attr(
                "name",
                `media[${rowCurrentIndex - 1}][vid_name]`
            );
            mediaNameInput.attr(
                "placeholder",
                `Enter media ${rowCurrentIndex - 1} name`
            );
            mediaUrlInput.attr("name", `media[${rowCurrentIndex - 1}][vid_url]`);
        });

        var mediaCnt = form.find("input[name='media_cnt']");
        mediaCnt.val(mediaCnt.val() - 1);

        // Check if there are no more media rows, then hide the "Add Media" button
        if (mediaCnt.val() === "0") {
            form.find(".add-more-media").hide();
        }
    });

    $("body").on("click", ".logo-delete", function () {
        var button = $(this);
        var formGroup = button.parent().prev();

        formGroup.find("input[name='logo']").val("");
        formGroup.find("label").text("Drag Picture Here");
        formGroup.find(".preview-image").remove();
        button.remove();
        formGroup.removeClass("col-11");
        formGroup.addClass("col-12");
    });

    $("body").on("click", ".open-select-modal", function () {

        var button = $(this);
        var id = button.data("id");

        $.ajax({
            url: '/admin/floorplans/get_data',
            type: 'POST',
            data: { id: id },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token for POST requests
            },
            success: function(response) {
                console.log("Success:", response);

                var modal = $("#floor-plan-select-setting-modal");
                var form = modal.find("form");

                form.attr("action", button.data("url"));

                if (button.data("keepname") == "1")
                    form.find("input[name='is_keep_same_name']:first").prop(
                        "checked",
                        true
                    );
                if (button.data("keepname") == "0")
                    form.find("input[name='is_keep_same_name']:eq(1)").prop(
                        "checked",
                        true
                    );

                form.find("input[name='floor_plan_rename']").val(button.data("rename"));

                if (response['is_not_display_price'] == "1")
                    form.find("[id='not-display-price']").prop(
                        "checked",
                        true
                    );

                if (response['is_not_display_price'] == "0")
                    form.find("[id='allowprice']").prop(
                        "checked",
                        true
                    );

                form.find("input[name='floor_plan_price']").val(button.data("price"));

                if (button.data("price") !== "")
                    form.find("input[name='enter_price']").prop("checked", true);

                // form.find("textarea[name='floor_plan_additional_text']").val(response['floor_plan_additional_text']);
                tinymce.get('floor_plan_additional_text').setContent(response['floor_plan_additional_text']);

                modal.find(".modal-title").text(response['title']);

                modal.modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });

    $("#floor-plan-select-setting-modal").on("hidden.bs.modal", function (e) {
        var modal = $(this);

        var keepnameOn = modal.find("input[name='is_keep_same_name']:first");
        var keepnameOff = modal.find("input[name='is_keep_same_name']:eq(1)");
        var rename = modal.find("input[name='floor_plan_rename']");
        var notdisplayprice = modal.find("input[name='is_not_display_price']");
        var price = modal.find("input[name='floor_plan_price']");
        var enterprice = modal.find("input[name='enter_price']");
        var additionaldesc = modal.find("textarea[name='floor_plan_additional_text']");

        keepnameOff.prop("checked", false);
        keepnameOff.removeClass("is-invalid");
        keepnameOn.prop("checked", false);
        keepnameOn.removeClass("is-invalid");
        rename.val("");
        rename.removeClass("is-invalid");
        notdisplayprice.prop("checked", false);
        notdisplayprice.removeClass("is-invalid");
        price.val("");
        price.removeClass("is-invalid");
        enterprice.prop("checked", false);
        enterprice.removeClass("is-invalid");
        additionaldesc.val("");
        additionaldesc.removeClass("is-invalid");
    });

    $("body").on("click", ".open-select-product-modal", function () {
        var button = $(this);
        var modal = $("#product-select-setting-modal");
        var form = modal.find("form");

        form.attr("action", button.data("url"));

        if (button.data("notdisplayprice") == "1")
            form.find("input[name='is_not_display_price']").prop(
                "checked",
                true
            );

        form.find("input[name='product_price']").val(button.data("price"));

        if (button.data("isenterprice") == "1")
            form.find("input[name='is_enter_price']").prop("checked", true);

        modal.find(".modal-title").text(button.data("title"));

        modal.modal();
    });

    $("#product-select-setting-modal").on("hidden.bs.modal", function (e) {
        var modal = $(this);

        var notdisplayprice = modal.find("input[name='is_not_display_price']");
        var price = modal.find("input[name='product_price']");
        var isEnterprice = modal.find("input[name='is_enter_price']");

        notdisplayprice.prop("checked", false);
        notdisplayprice.removeClass("is-invalid");
        price.val("");
        price.removeClass("is-invalid");
        isEnterprice.prop("checked", false);
        isEnterprice.removeClass("is-invalid");
    });

    // $("body").on("click", ".select-product", function (event) {
    //     event.preventDefault();

    //     var button = $(this);
    //     var form = $("#product-form");

    //     var productId = button.data("product-id");
    //     var productQuantity = $("#product_quantity").val();
    //     console.log(productQuantity);
    //     exit();
    //     form.find("input[name='product_id']").val(productId);
    //     form.find("input[name='product_quantity']").val(productQuantity);

    //     form.submit();
    // });

    $("body").on("keypress", ".customer-comment", function (event) {
        var input = $(this);

        if (event.keyCode != "13") return;

        var form = $("#product-form");

        var productId = form.find("input[name='product_id']");
        var color = form.find("input[name='color']");
        var comment = form.find("input[name='comment']");

        productId.val(input.data("product-id"));
        color.val(input.data("color"));
        comment.val(input.val());

        form.submit();
    });

    $("body").on("click", ".floorplan-image", function (event) {
        var image = $(this);
        var zoomModal = $("#floorplan-zoom-modal");

        zoomModal.find(".modal-title").text(image.data("alt"));
        zoomModal.find(".modal-body").html(
            `
            <div style="text-align: center;">
                <img src="${image.data('src')}" alt="${image.data('alt')}" 
                    style="height: 500px; object-fit: cover; display: inline-block;">
            </div>
            `
        );

        zoomModal.modal();
    });
    
    $("body").on("click", ".floorplan-video", function (event) {
        var image = $(this);

        var zoomModal = $("#floorplan-zoom-modal");

        var videoId = '';
        var urlParts = image.data("src").split('=');
        if (urlParts.length > 1) {
            videoId = urlParts[1];
        }

        zoomModal.find(".modal-title").text(image.data("alt"));
        zoomModal.find(".modal-body").html(
            `<div class="preview-video">
                <iframe
                    width="100%" height="720"
                    src="https:\/\/www.youtube.com\/embed\/${videoId}"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen>
                </iframe>
            </div>
            `
        );

        // zoomModal.find(".modal-body").html(
        //     `
        //     <div class="">
        //     <video style="width:100% !important; height: auto !important; object-fit: cover;"controls>
        //     <source src="${image.data("src")}">
        //     </video>
        //     </div>
        //     `
        // );

        zoomModal.modal();
    });

    $("body").on("click", ".product-image", function (event) {
        var image = $(this);
        var imageTag = image.find("img");
        imageList = image.data('image-list');

        var singleImage = '';
        for(var i = 0; i < imageList.length; i++ ){
            singleImage += `<div class="swiper-slide" style="border-radius: 8px; border: 1px solid #DBDBDB; margin-right: 0 !important margin: auto !important; width: auto !important;"><img src="${image.data("image-list")[i]["pic_url"]}" alt="${image.data("alt")}"></div>`;
        }
        var zoomModal = $("#product-zoom-modal");

        zoomModal.find(".modal-title").text(image.data("name"));
        zoomModal.find(".modal-body").html(
            `<div class="row">
                <input type="hidden" name="product_id" value="${image.data("product-id")}">

                <div class="item-large-image col-6">
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper quick_view_img">
                            ${singleImage}
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>

                <div class="col-6 m-auto">
                    <div>
                        <div class="card-title text-truncate" style="font-weight: bold; font-size: 20px; margin-bottom: 5px !important;">
                            ${image.data("name")}
                        </div>

                        <div class="card-title" style="text-align: left; font: normal normal normal 18px;"> ${image.data("description")}</div>

                        <!-- Pricing and Quantity Section -->
                        <!--<div class="mb-3">
                            <div>
                                <h5 class="mb-0" style="color: #007AFF">
                                    $${image.data("price")}
                                </h5>
                            </div>
                            <hr>
                            <div class="col-md-4 d-flex align-items-center p-0 m-0">
                                <span class="decrease-btn btn btn-link"><i class="fas fa-minus"></i></span>
                                <input type="number" name="product_quantity" class="quantity form-control form-control-sm mx-2" style="width: 50px;" value="1" min="1">
                                <span class="increase-btn btn btn-link"><i class="fas fa-plus"></i></span>
                            </div>
                        </div> -->

                        <!-- Buttons Section -->
                        <button type="submit" class="btn-selects" style="font-weight: 600; width: -webkit-fill-available;">
                            Select
                        </button>
                    </div>
                </div>
                <p class="opacity-75 hover-opacity-100"></p>
            </div>`
        );

        var swiperModal = new Swiper(".mySwiper", {
            slidesPerView: 2,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
              },
        });

        zoomModal.modal();
    });

    //select-model
    $("body").on("click", ".btn-select", function () {
        var button = $(this);
        var productId = button.data('product-id');

        // Simulate fetching product data based on ID
        var simulatedResponse = {
            name: 'Product Name',
            description: 'Product Description',
            additionalText: 'Additional Info',
            imageList: [
                { pic_url: '/path/to/image1.jpg' },
                { pic_url: '/path/to/image2.jpg' }
            ]
        };

        var singleImage = '';
        for (var i = 0; i < simulatedResponse.imageList.length; i++) {
            singleImage += `<div class="swiper-slide quick_view_img"><img src="${simulatedResponse.imageList[i].pic_url}" alt="${simulatedResponse.name}"></div>`;
        }

        var slideModal = $("#product-select");
        slideModal.find(".modal-title").text(simulatedResponse.name);
        slideModal.find(".modal-body").html(
            `<div class="item-large-image">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        ${singleImage}
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            <p class="my-5">${simulatedResponse.description}</p>
            <p class="opacity-75 hover-opacity-100">${simulatedResponse.additionalText}</p>`
        );

        // Initialize Swiper
        var swiperModal = new Swiper(".mySwiper", {
            slidesPerView: 2,
            spaceBetween: 30,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        // Show the modal
        slideModal.modal('show');
    });

    // Close modal function
    function closeSlideModal() {
        $('#product-slide-modal').removeClass('open');
    }

    // Optional: Close the modal when clicking outside of it
    $(window).on('click', function (event) {
        if ($(event.target).is('#product-slide-modal')) {
            closeSlideModal();
        }
    });

    // $("#color-modal").on("hidden.bs.modal", function (e) {
    //     var modal = $(this);

    //     var color = modal.find("input[name='color']");
    //     var productId = modal.find("input[name='product_id']");

    //     color.val("");
    //     productId.val("");
    // });

    $("body").on("click", ".paint-color-btn", function () {
        var modal = $("#color-list-modal");

        modal.modal();
    });

    $("body").on("click", ".registration", function () {
        var zoomModal = $("#registration-model");
        zoomModal.modal();
    });

    // Increase button click event
    $("body").on("click", ".increase-btn", function () {
        var $quantityInput = $(this).prev('.quantity');
        var currentValue = parseInt($quantityInput.val());
        $quantityInput.val(currentValue + 1);
    });

    // Decrease button click event
    $("body").on("click", ".decrease-btn", function () {
        var $quantityInput = $(this).next('.quantity');
        var currentValue = parseInt($quantityInput.val());
        if (currentValue > 0) {
            $quantityInput.val(currentValue - 1);
        }
    });

    $.ajax({
        url: '/selection-session',
        method: 'GET',
        success: function(response) {
            if (response) {
                $('#selectionsModal').modal('show');

                $.ajax({
                    url: '/selection-session-remove',
                    method: 'GET',
                    success: function(response) {
                        if (response) {
                            console.log('session value remove');
                        } else {
                            console.log('session value not removed');
                        }
                    },
                    error: function() {
                        console.log('session value expired');
                    }
                });
            } else {
                console.log('session value expires');
            }
        },
        error: function() {
            console.log('session value expired');
        }
    });
});

$(window).on("load", function () {
    if (window.showModal) {
        var floorplanSettingModal = $("#floor-plan-select-setting-modal");
        var productSettingModal = $("#product-select-setting-modal");

        if (floorplanSettingModal.length) floorplanSettingModal.modal("show");

        if (productSettingModal.length) productSettingModal.modal("show");
    }

    // if (window.showColorModal) {
    //     var colorModal = $("#color-modal");
    //     colorModal.modal("show");
    // }

    if (window.showColorListModal) {
        var colorModal = $("#color-list-modal");
        colorModal.modal("show");
    }

    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
        { value: 'First.Name', title: 'First Name' },
        { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant")),
    });
});
