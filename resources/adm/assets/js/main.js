"use strict";
var app;

function Main() {
	this.init();
};

Main.prototype.init = function(){
	var self = this;

	self.lists();
	self.forms();
    self.uploads();
    self.gallery();
    self.position();
	self.plugins();

	self.notyf = new Notyf();
}

Main.prototype.lists = function(){
	var self = this;

    if($.fn.DataTable && $('.main-table.data-table').length > 0){
        var columns = [];
        var orderCol = false
        $('.main-table.data-table th').each(function(index, el) {
            var i = columns.length
            columns[i] = {data: $(this).attr('data-name'), className: $(this).attr('data-classes')};
            if(orderCol === false){
                if($(this).attr('data-orderable')=='true'){
                    orderCol = i;
                }
            }
        });
        $('.main-table.data-table').DataTable({
            'ajax': {
                url: $('.main-table.data-table').attr('data-ajax-url'),
                dataSource: 'data'
            },
            'processing': true,
            'serverSide': true,
            'language': {
                'url': '//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json'
            },
            'columns': columns,
            'order': [[orderCol, 'asc']]
        }).on( 'draw.dt', function(a,b,c){
            if(columns[0].data == 'sort_order' && b.aLastSort[0].col == 0 && b.aLastSort[0].dir == 'asc' && b.oPreviousSearch.sSearch.length == 0){
                $('.main-table.data-table .sort-handle').removeClass('disabled');
            }
            $('.main-table.data-table [data-bs-toggle="tooltip"]').tooltip();
        });;
    }

	 $('.main-table tbody').sortable({
        handle: '.sort-handle:not(.disabled)',
        update: function(){
        	var data = [];
        	$('.main-table tbody .sort-handle [data-id]').each(function(index, el) {
        		data.push({id: $(el).attr('data-id'), order: $(el).attr('data-sort-order')});
        	});
        	$.ajax({
        		url: $('.main-table').attr('data-sort-url'),
        		type: 'POST',
        		dataType: 'json',
        		data: {data: data, '_token': $('meta[name="csrf-token"]').attr('content')},
        		error: function(){
        			console.error('sort error');
        		},
        		success: function(json){
        			if(json.status){
        				app.notyf.success(json.message);
        			} else{
        				if(json.message){
        					console.error(json.message);
        				}
        			}
        		}
        	});
        }
    });

    $('body').on('change', '.main-table .change-status', function(event) {
        var input = $(this), table = input.parents('.main-table');
        $.ajax({
            url: table.attr('data-status-url'),
            type: 'POST',
            dataType: 'json',
            data: {id: input.attr('data-id'), status: input.is(':checked'), '_token': $('meta[name="csrf-token"]').attr('content')},
            error: function(){
                console.error('status error');
            },
            success: function(json){
                if(json.status){
                    app.notyf.success(json.message);
                } else{
                    console.error('status error');
                }
            }
        });
    });

    $('body').on('click', '.confirm-delete', function(event) {
        event.preventDefault();
        var btn = $(this);


        $('.confirm-delete-modal').modal('show');

        $('.confirm-delete-modal .save').off().on('click', function(event) {
            event.preventDefault();

            $('.confirm-delete-modal').modal('hide');

            btn.parents('tr').fadeOut('300', function() {
                btn.parents('tr').remove();
            });

            $.ajax({
                url: btn.attr('href'),
                type: 'POST',
                dataType: 'json',
                data: {'_token': $('meta[name="csrf-token"]').attr('content')},
                error: function(){
                    console.error('delete error');
                },
                success: function(json){
                    if(json.status){
                        app.notyf.success(json.message);
                    } else{
                        app.notyf.error(json.message);
                    }
                }
            });
        });
    });

    $('body').on('click', '.open-modal-view', function(event) {
        event.preventDefault();
        var btn = $(this);

        $.ajax({
            url: btn.attr('href'),
            type: 'POST',
            dataType: 'json',
            data: {'_token': $('meta[name="csrf-token"]').attr('content')},
            error: function(){
                console.error('error view');
            },
            success: function(json){
                if(json.status){
                    $('.view-modal .modal-title').html(json.title);
                    $('.view-modal .modal-body').html(json.html);
                    $('.view-modal').modal('show');
                } else{
                    if(json.message){
                        app.notyf.error(json.message);
                    }
                }
            }
        });
    });
}

Main.prototype.forms = function(){
	var self = this;

	$('body').on('submit', '.common-form-send', function(e) {
		e.preventDefault();
		var form = $(this), btn = form.hasClass('main-form') ? $('.main-form-button') : form.find('button');
		if(!form.hasClass('sending')){
			if(self.validate(form)){

				form.addClass('sending');
				btn.addClass('loading');
				$.ajax({
					url: form.attr('action'),
					type: 'POST',
					dataType: 'json',
					data: form.serialize(),
					error: function(){
						app.notyf.error('Aconteceu um erro durante o envio, tente mais tarde.');
                    	form.removeClass('sending');
                    	btn.removeClass('loading');
					},
					success: function(json){
						if(!json.status){
	                        if(json.message){
	                            app.notyf.error(json.message);
	                        }
	                    }
	                    else{
	                        if(json.redirect && !json.timeout){
	                            location.href = json.redirect;
	                        } else{
	                            form.data('json', json);
	                            form.trigger('submited');

	                            if(json.message){
	                                app.notyf.success(json.message);
	                            }

	                            if(json.redirect){
	                                setTimeout(function() {location.href = json.redirect;}, json.timeout);
	                            }

	                            if(!form.hasClass('no-reset') && !json.redirect){
	                                form[0].reset();
	                            }
	                        }
	                    }
	                    if(!json.redirect){
	                        form.removeClass('sending');
	                        btn.removeClass('loading');
	                    }
					}
				});
			} else{
				app.notyf.error('Valide o formulário!');
			}
		}
	});
}

Main.prototype.validate = function(form){
	var self = this, valid = true;

	form.find('input.required, select.required, textarea.required').each(function(index, el) {
		var input = $(el);
		if(input.val() == null || input.val().length == 0){
			valid = false;
			input.parents('.column').addClass('error');
			input.on('keyup change', function(){
				input.parents('.column').removeClass('error');
			});
		}
	});

    //Valida campos de imagem e arquivo
    form.find('.image-input.required, .file-input.required, .gallery-input.required, .pick-position.required').each(function(index, el) {
        var input = $(el);
        if(!input.hasClass('filled')){
            valid = false;
            input.parents('.column').addClass('error');
            input.on('fchange', function(){
                input.parents('.column').removeClass('error');
            });
        }
    });

	return valid;
}

Main.prototype.uploads = function(){
    var self = this;

    $('body').on('change', '.image-input input[type="file"]', function(e) {

        var input = $(this), parent = input.parents('.image-input');
        var allowed = ['png','jpg','jpeg', 'webp', 'svg', 'gif'];
        let resolution = parent.children('[name=resolution]');
        let width = resolution.attr('width');
        let height = resolution.attr('height');
        $('.modal-image .modal-body').children().remove();
        $('.modal-crop .modal-body').children().remove();
        let cropConfig = localStorage.getItem('cropConfig');
        if (cropConfig == 'false') cropConfig = false;
        if (cropConfig == 'true') cropConfig = true;
        let widthSelected = 160;
        let heightSelected = 160;

        if(!parent.hasClass('loading') && input.val().length > 0 && e.target.files[0]){
            var ext = e.target.files[0].name;
            ext = ext.toLowerCase().split('.');
            ext = ext[ext.length - 1];

            if(allowed.indexOf(ext) != -1){
                if (cropConfig) {
                    showModalCrop(e, width, height, widthSelected, heightSelected);
                    getCropEvents();
                    cropImage(parent, input, e, width, height);
                } else {
                    noCropUpload(e, parent, width, height, input);
                }
            } else{
                app.notyf.error(`Extensão não permitida!`);
                input.val('');
            }
        }

    });

    $('body').on('click', '.modal-header .close', function(e) {
        closeModal();
    });

    $('body').on('click', '.modal-image-close', function(e) {
        closeModal();
    });

    // Salvar Imagem Galeria
    $('body').on('click', '[name="generalGallerySave"]', function(e) {
        e.preventDefault();
		var form = $(this);

        let name = form.data('name');
        let oldValue = form.data('value');
        let value = form.parent().parent().find(`[name="${name}"]`).val();
        let folder = form.data('folder');
        let table = form.data('table');
        let moduleId = form.data('id');
        let isGallery = form.data('gallery');
        let foreignKey = form.data('foreign');
        let language = form.data('language');
        let isLang = form.data('lang');

        var dataString = 'oldValue=' + oldValue + '&value=' + value + '&folder=' + folder + '&name=' + name + '&table=' + table +
        '&moduleId=' + moduleId + '&isGallery=' + isGallery + '&foreignKey=' + foreignKey + '&language=' + language +
        '&isLang=' + isLang;

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data: dataString,
            error: function(){
                app.notyf.error('Aconteceu um erro durante o envio, tente mais tarde.');
                form.removeClass('sending');
            },
            success: function(json){
                if(!json.status){
                    if(json.message){
                        app.notyf.error(json.message);
                    }
                }
                else{
                    if(json.redirect && !json.timeout){
                        location.href = json.redirect;
                    } else{
                        form.data('json', json);
                        form.trigger('submited');

                        if(json.message){
                            app.notyf.success(json.message);
                        }

                        if(json.redirect){
                            setTimeout(function() {location.href = json.redirect;}, json.timeout);
                        }

                        if(!form.hasClass('no-reset') && !json.redirect){
                            form[0].reset();
                        }
                    }
                }
                if(!json.redirect){
                    form.removeClass('sending');
                }
            }
        });
    });

    $('body').on('change', '.file-input input[type="file"]', function(e) {

        var input = $(this), parent = input.parents('.file-input');

        if(!parent.hasClass('loading') && input.val().length > 0 && e.target.files[0]){
            parent.addClass('loading');
            var formData = new FormData();
            formData.append('file', e.target.files[0]);
            formData.append('folder', parent.attr('data-folder'));
            formData.append('type', 'file');
            formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
            $.ajax({
                url: parent.attr('data-url'),
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                data: formData,
                error: function(){
                    app.notyf.error('Erro ao enviar arquivo!');
                    input.val('');
                    parent.removeClass('loading');
                },
                success: function(json){
                    let alertt = false;
                    if(json.status){
                        alertt = json.alert;
                        app.notyf.success(json.message);
                        parent.addClass('filled');
                        parent.find('label').find('span').html(json.file);
                        parent.find('input[type="hidden"]').remove();
                        parent.append('<input type="hidden" name="'+parent.attr('data-name')+'" value="' + json.file + '" >');
                        parent.find('.see').attr('href', json.file_url);
                        parent.trigger('fchange');
                    } else{
                        if(json.message){
                            app.notyf.error(json.message);
                        }
                    }
                    parent.removeClass('loading');
                    input.val('');
                    if (alertt) {
                        alert(alertt);
                    }
                }
            });
        }
    });

    $('body').on('click', '.image-input .remove', function(event) {
        event.preventDefault();
        var parent = $(this).parents('.image-input');

        parent.removeClass('filled').removeClass('loading');

        parent.find('input[type="hidden"], label img').remove();

        let isGalleryGeneral = $('[name="generalGallerySave"]');
        if (isGalleryGeneral !== undefined) {
            $('.ctrls').css({"display": "block"});
        }
    });

    $('body').on('click', '.file-input .remove', function(event) {
        event.preventDefault();
        var parent = $(this).parents('.file-input');

        parent.removeClass('filled').removeClass('loading');

        parent.find('input[type="hidden"]').remove();
        parent.find('label span').html('');
    });

    //Detalhe da imagem + inputs de alt e title
    $('body').on('click', '.image-input .see', function(event) {
        let name = $(this).attr('data-name');
        let nameAlt = $(this).attr('data-nameAlt');
        let nameTitle = $(this).attr('data-nameTitle');
        let alt = $(`[nameAttr="${nameAlt}"]`).val();
        let title = $(`[nameAttr="${nameTitle}"]`).val();
        let src = $(this).attr('data-href');
        $('.modal-image .modal-body').children().remove();
        $('.modal-image .modal-body').append(getImageDetailsModal(src, alt, title, name, nameAlt, nameTitle));
        $('.modal-image').modal('show');
    });
    
    $('body').on('click', '#sendImageAttributes', function(e) {
        let attributes = $(this).closest('#rowButtons').siblings("div#rowInputs.row").children("div.col-6");
        let alt = attributes.children("#imageAlt").val();
        let title = attributes.children("#imageTitle").val();
        let nameAlt = $(this).attr('nameAlt');
        let nameTitle = $(this).attr('nameTitle');
        $(`[nameAttr="${nameAlt}"]`).val(alt);
        $(`[nameAttr="${nameTitle}"]`).val(title);
        $(this).siblings('button.btn-secondary').click();
    });
}

Main.prototype.gallery = function(){
    var self = this;

    var allowed = ['png','jpg','jpeg', 'webp', 'svg', 'gif'];

    $('body').on('change', '.gallery-input input[type="file"]', function(e) {
        $('.modal-image .modal-body').children().remove();
        $('.modal-crop .modal-body').children().remove();
        $('#cropDiv').remove();
        var input = $(this), parent = input.parents('.gallery-input');
        let resolution = parent.children('[name=resolution]');
        let width = resolution.attr('width');
        let height = resolution.attr('height');
        let widthSelected = 160;
        let heightSelected = 160;
        let cropConfig = localStorage.getItem('cropConfig');
        if (cropConfig == 'false') cropConfig = false;
        if (cropConfig == 'true') cropConfig = true;

        if (cropConfig) {
            showModalCrop(e, width, height, widthSelected, heightSelected);
            getCropEvents();
            cropGallery(parent, input, e, width, height);
        } else {
            noCropUploadGallery(e, parent, width, height, input);
        }

    });

    $('body').on('click', '.modal-header .close', function(e) {
        closeModal();
    });

    $('body').on('change', '.gallery-checkbox', function(event) {
        var parent = $(this).parents('.gallery-input');

        var len = parent.find('.gallery-checkbox:checked').length;

        if(len == 0){
            parent.find('.remove-images').removeClass('show');
        } else{
            parent.find('.remove-images').addClass('show');
        }
    });

    $('body').on('click', '.gallery-input .favorite', function(event) {
        event.preventDefault();
        if($(this).hasClass('on')){
            $(this).removeClass('on').find('input').val('0');
        } else{
            $(this).addClass('on').find('input').val('1');
        }
    });

    $('.gallery-input .itens').sortable();

    $('body').on('click', '.gallery-input .itens .item .image', function(event) {
        $("#activeAlt").attr('id', '');
        $("#activeTitle").attr('id', '');
        let name = $(this).attr('data-name');
        let altEl = $(this).siblings(`[name="${name + '[imageAlt][]'}"]`);
        let titleEl = $(this).siblings(`[name="${name + '[imageTitle][]'}"]`);
        let nameAlt = $(this).attr('data-nameAlt');
        let nameTitle = $(this).attr('data-nameTitle');
        let src = $(this).attr('data-href');
        altEl.attr('id', 'activeAlt');
        titleEl.attr('id', 'activeTitle');
        let alt = altEl.val();
        let title = titleEl.val();
        // let thisImage = $(this);
        $('.modal-image .modal-body').children().remove();
        $('.modal-image .modal-body').append(getImageDetailsModal(src, alt, title, name, nameAlt, nameTitle));
        $('body').on('click', '#sendImageAttributes', function() {
            let attributes = $(this).closest('#rowButtons').siblings("div#rowInputs.row").children("div.col-6");
            let alt = attributes.children("#imageAlt").val();
            let title = attributes.children("#imageTitle").val();
            $("#activeAlt").val(alt);
            $("#activeTitle").val(title);
            $("#activeAlt").attr('id', '');
            $("#activeTitle").attr('id', '');
            $(this).siblings('button.btn-secondary').click();
        });
        $('.modal-image').modal('show');
    });



    $('body').on('click', '.gallery-input .remove-images', function(event) {
        var parent = $(this).parents('.gallery-input');

        parent.find('.gallery-checkbox:checked').each(function(index, el) {
            $(el).parents('.item').remove();
        });

        parent.find('.remove-images').removeClass('show');
    });
}

Main.prototype.position = function(){
    var self = this;

    $('.pick-position').each(function(index, el) {
        self.map($(el));
    });

    $('body').on('click', '.button-clear-position', function(e){
        var cnt = $(this).parents('.pick-position');
        if(cnt[0].marker){
            $(this).removeClass('show');
            cnt[0].marker.setMap(null);
            cnt.removeClass('filled').find('>input').remove();
        }
    });

}

Main.prototype.map = function(cnt){
    var self = this;

    var mapOptions = {
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    var map = new google.maps.Map(cnt.find('.map')[0], mapOptions);

    if(cnt.hasClass('filled')){
        var input = cnt.find('>input').val();
        input = input.split(',');
        var  center = new google.maps.LatLng(parseFloat(input[0]), parseFloat(input[1]));
    } else{
        var  center = new google.maps.LatLng(-29.168039, -51.182681);
    }

    map.setCenter(center);

    if(cnt.hasClass('filled')|| cnt.hasClass('required')){
        var marker = new google.maps.Marker({
            position: center,
            map: map,
            //icon: image,
            draggable: true
        });
        cnt[0].marker = marker;
        self.markerDrag(marker, cnt);
    }
    cnt[0].map = map;

    cnt.find('.input-search-position').keypress(function(e) {
        if(e.keyCode == 13){
            e.preventDefault();
            e.stopPropagation();
        }
    });

    var input = cnt.find('.input-search-position')[0];

    var autocomplete = new google.maps.places.Autocomplete(input,{
         componentRestrictions: {country: 'br'}
    });

    autocomplete.addListener('place_changed', function() {
        var place = autocomplete.getPlace();
        if(place.geometry){
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
            }
        }
    });

    google.maps.event.addListener(map, 'click', function(event) {
        if(cnt[0].marker){
            cnt[0].marker.setMap(null);
        }
        cnt.find('>input').remove();
        var marker = new google.maps.Marker({
            position: event.latLng,
            map: map,
            //icon: image,
            draggable: true
        });
        self.markerDrag(marker, cnt);
        cnt[0].marker = marker;
        cnt.append('<input type="hidden" name="' + cnt.attr('data-name') + '" value="' + event.latLng.lat() + ',' + event.latLng.lng() + '">');
        cnt.addClass('filled');
        cnt.trigger('fchange');
        cnt.find('.button-clear-position').addClass('show');
        var index = cnt.parents('.page').index();
        $('.common-top .guides .item:eq(' + index + ')').removeClass('error');
    });

}

Main.prototype.markerDrag = function(marker, cnt){
    google.maps.event.addListener(marker, 'dragend', function(e){
        cnt.find('>input').remove();
        cnt.append('<input type="hidden" name="' + cnt.attr('data-name') + '" value="' + e.latLng.lat() + ',' + e.latLng.lng() + '">');
    });
}

Main.prototype.plugins = function(){
    if($.fn.tooltip){
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    if($.fn.datepicker && $('.input-date').length > 0){
        $('.input-date').datepicker({language: 'pt-BR'});
    }

    if($.fn.select2 && $('.select-multiple, .select-plugin').length > 0){
        $('.select-multiple, .select-plugin').select2();
    }
}

/**Crop de imagens */

function showModalCrop(e, width, height, widthSelected, heightSelected) {

    var reader = new FileReader();
    reader.onload = function (event) {
        getCropModal(event.target.result, width, height, widthSelected, heightSelected);
    }

    reader.readAsDataURL(e.target.files[0]);
}

function noCropUpload(e, parent, width, height, input) {
    parent.addClass('loading');
    var formData = new FormData();
    formData.append('file', e.target.files[0]);
    formData.append('folder', parent.attr('data-folder'));
    formData.append('type', 'image');
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('image_width', `${width}`);
    formData.append('image_height', `${height}`);
    $.ajax({
        url: parent.attr('data-url'),
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: formData,
        error: function(){
            app.notyf.error('Erro ao enviar arquivo!');
            input.val('');
            parent.removeClass('loading');
        },
        success: function(json){
            let alertt = false;
            if(json.status){
                alertt = json.alert;
                if (alertt) {
                    alert(alertt);
                }
                app.notyf.success(json.message);
                parent.addClass('filled');
                parent.find('label').find('img').remove();
                parent.find('label').append('<img src="'+json.resized+'">');
                parent.find('input[type="hidden"]').remove();
                parent.append('<input type="hidden" name="'+parent.attr('data-name')+'" value="' + json.file + '" >');
                parent.append('<input type="hidden" name="'+parent.attr('data-nameAlt')+'" nameAttr="' + parent.attr('data-nameAlt') + '" value="" >');
                parent.append('<input type="hidden" name="'+parent.attr('data-nameTitle')+'" nameAttr="' + parent.attr('data-nameTitle') + '" value="" >');
                parent.find('.see').attr('data-href', json.file_url);
                parent.trigger('fchange');
            } else{
                if(json.message){
                    app.notyf.error(json.message);
                }
            }
            parent.removeClass('loading');
            input.val('');
        }
    }).done(() => {return showImageModalAfterSend(parent)});
                
}

function noCropUploadGallery(e, parent, width, height, input) {
    parent.addClass('loading');
    var formData = new FormData();
    formData.append('file', e.target.files[0]);
    formData.append('folder', parent.attr('data-folder'));
    formData.append('type', 'image');
    formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
    formData.append('image_width', `${width}`);
    formData.append('image_height', `${height}`);
    $.ajax({
        url: parent.attr('data-url'),
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        data: formData,
        error: function(){
            app.notyf.error('Erro ao enviar arquivo!');
            input.val('');
            parent.removeClass('loading');
        },
        success: function(json){
            let alertt = false;
            if(json.status){
                alertt = json.alert;
                if (alertt) {
                    alert(alertt);
                }
                app.notyf.success(json.message);
                var html = '<div class="item">\
                                <div class="image" data-name="'+parent.attr('data-name')+'" style="background-image: url(\''+json.croped+'\');" data-href="'+json.file_url+'"></div>\
                                <label class="checkbox"><input type="checkbox" class="gallery-checkbox"><span class="icon"></span></label>\
                                <div class="favorite">\
                                    <input type="hidden" name="'+parent.attr('data-name')+'[highlighted][]" value="0">\
                                    <div class="icon"><i class="far fa-star"></i><i class="fas fa-star"></i></div>\
                                </div>\
                                <input type="hidden" name="'+parent.attr('data-name')+'[image][]" value="'+json.file+'">\
                                <input type="hidden" name="'+parent.attr('data-name')+'[imageAlt][]">\
                                <input type="hidden" name="'+parent.attr('data-name')+'[imageTitle][]">\
                            </div>';
                parent.find('.itens').append(html);
                parent.addClass('filled');
                parent.trigger('fchange');
                $('.modal-image').modal('hide');
                $('#getCrop').remove();
                $('#cropDiv').remove();
                var image = $('#cropThis');
                var cropper = image.data('cropper');
                if (cropper !== undefined) {
                    cropper.destroy();
                }
            } else{
                if(json.message){
                    app.notyf.error(json.message);
                }
            }
            parent.removeClass('loading');
            input.val('');
        }
    });
                
}

function zoomEvent() {
    let valueRange = 1;
    $("body").on('click', "#buttonZoomMore", function () {
        let image = $('#cropThis');
        let cropper = image.data('cropper');
        cropper.zoom(0.1);
        //aumenta no slider
        valueRange = valueRange + 0.1;
        $(".cr-slider").val(valueRange);
    });

    $("body").on('click', "#buttonZoomLess", function () {
        let image = $('#cropThis');
        let cropper = image.data('cropper');
        cropper.zoom(-0.1);
        //diminui no slider
        valueRange = valueRange - 0.1;
        $(".cr-slider").val(valueRange);
    });

    $("body").on('input', ".cr-slider",  function (event) {
        let image = $('#cropThis');
        let cropper = image.data('cropper');
        let data = cropper.getCropBoxData();
        cropper.zoomTo($(this).val(), {'x': data.width, 'y': data.length});
    });
}

function getCropModal(src, width, height, widthSelected, heightSelected) {
    $.ajax({
        type: 'POST',
        url: $(".modal-crop").attr('crop-modal-url'),
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
        },
        data: "?src=" + src,
        dataType: 'html',
        success: function (data) {
            $('.modal-crop').html(data);
            $(".imageDiv").append(`<img id="cropThis" src="${src}" class='img-fluid'>`);
            $('.modal-crop').modal({backdrop: 'static', keyboard: false});
            $('.modal-crop').modal('show');
            var image = $('#cropThis');
            let widthRecomm = parseInt(width);
            let heightRecomm = parseInt(height);
            setCropRecommended(widthRecomm, heightRecomm);
            image.cropper({
                aspectRatio: NaN,
                restore: false,
                guides: false,
                center: false,
                highlight: false,
                dragMode: 'move',
                cropBoxMovable: true,
                cropBoxResizable: false,
                toggleDragModeOnDblclick: false,
                data: {width: widthRecomm, height: heightRecomm},
                viewMode: 1,
                crop: function(event) {
                    widthSelected = event.detail.width;
                    heightSelected = event.detail.height;
                    $("#widthCounter").val(Math.floor(event.detail.width) + 'px');
                    $("#heightCounter").val(Math.floor(event.detail.height) + 'px');
                    checkDimensions();
                }
            });
        },
    });
}

function setCropRecommended(width, height) {
    if (width && height) {
        $("#widthRecommended").val(width + 'px');
        $("#heightRecommended").val(height + 'px');
        $("#dimensionW").val(width);
        $("#dimensionH").val(height);
    } else {
        $("#dimensionW").val(200);
        $("#dimensionH").val(200);
    }
}

function changeDimension() {
    var dimensionW = parseInt($('#dimensionW').val());
    var dimensionH = parseInt($('#dimensionH').val());
    var image = $('#cropThis');
    var cropper = image.data('cropper');
    let data = {"width":dimensionW,"height":dimensionH};
    cropper.setData(data);
}

function checkDimensions() {
    let currentWidth = $("#widthCounter").val();
    let currentHeight = $("#heightCounter").val();

    let recommendedWidth = $("#widthRecommended").val();
    let recommendedHeight = $("#heightRecommended").val();

    if (!recommendedWidth && !recommendedHeight) {
        return;
    }

    if (currentWidth !== recommendedWidth) {
        $("#widthCounter").addClass("is-invalid");
    } else {
        $("#widthCounter").removeClass("is-invalid");
    }

    if (currentHeight !== recommendedHeight) {
        $("#heightCounter").addClass("is-invalid");
    } else {
        $("#heightCounter").removeClass("is-invalid");
    }
}

function closeModal() {
    $('#getCrop').remove();
    $('#cropDiv').remove();
    var image = $('#cropThis');
    var cropper = image.data('cropper');
    if (cropper !== undefined) {
        cropper.destroy();
    }
    $('.modal-crop').modal('hide');
    $('.modal-image').modal('hide');
}

function cropImage(parent, input, event, width, height) {
    $('body').on('click', '#getCrop', function() {
        var image = $('#cropThis');
        var cropper = image.data('cropper');
        let imageData = cropper.getData(true);

        let canvas = cropper.getCroppedCanvas({
            width: imageData.width,
            height: imageData.height,
        });
        canvas.toDataURL();
        if(!parent.hasClass('loading') && input.val().length > 0 && event.target.files[0]){
            parent.addClass('loading');
            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('file', blob, event.target.files[0].name);
                formData.append('folder', parent.attr('data-folder'));
                formData.append('type', 'image');
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('image_width', `${width}`);
                formData.append('image_height', `${height}`);
                $.ajax({
                    url: parent.attr('data-url'),
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: formData,
                    error: function(){
                        app.notyf.error('Erro ao enviar arquivo!');
                        input.val('');
                        parent.removeClass('loading');
                    },
                    success: function(json){
                        let alertt = false;
                        if(json.status){
                            alertt = json.alert;
                            if (alertt) {
                                alert(alertt);
                            }
                            app.notyf.success(json.message);
                            parent.addClass('filled');
                            parent.find('label').find('img').remove();
                            parent.find('label').append('<img src="'+json.resized+'">');
                            parent.find('input[type="hidden"]').remove();
                            //
                            parent.append('<input type="hidden" name="'+parent.attr('data-name')+'" value="' + json.file + '" >');
                            parent.append('<input type="hidden" name="'+parent.attr('data-nameAlt')+'" nameAttr="' + parent.attr('data-nameAlt') + '" value="" >');
                            parent.append('<input type="hidden" name="'+parent.attr('data-nameTitle')+'" nameAttr="' + parent.attr('data-nameTitle') + '" value="" >');
                            parent.find('.see').attr('data-href', json.file_url);
                            parent.trigger('fchange');
                            $('.modal-crop').modal('hide');
                            $('#getCrop').remove();
                            $('#cropDiv').remove();
                            var image = $('#cropThis');
                            var cropper = image.data('cropper');
                            if (cropper !== undefined) {
                                cropper.destroy();
                            }
                        } else{
                            if(json.message){
                                app.notyf.error(json.message);
                            }
                        }
                        parent.removeClass('loading');
                        input.val('');
                    }
                }).done(() => {return showImageModalAfterSend(parent)});
            });
        }

    });
}

function cropGallery(parent, input, event, width, height) {
$('body').on('click', '#getCrop', function() {
        var image = $('#cropThis');
        var cropper = image.data('cropper');
        let imageData = cropper.getData(true);

        let canvas = cropper.getCroppedCanvas({
            width: imageData.width,
            height: imageData.height,
        });
        canvas.toDataURL();
        if(!parent.hasClass('loading') && input.val().length > 0 && event.target.files[0]){
            parent.addClass('loading');
            canvas.toBlob(function (blob) {
                var formData = new FormData();
                formData.append('file', blob, event.target.files[0].name);
                formData.append('folder', parent.attr('data-folder'));
                formData.append('type', 'image');
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                formData.append('image_width', `${width}`);
                formData.append('image_height', `${height}`);
                $.ajax({
                    url: parent.attr('data-url'),
                    type: 'POST',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    data: formData,
                    error: function(){
                        app.notyf.error('Erro ao enviar arquivo!');
                        input.val('');
                        parent.removeClass('loading');
                    },
                    success: function(json){
                        let alertt = false;
                        if(json.status){
                            alertt = json.alert;
                            if (alertt) {
                                alert(alertt);
                            }
                            app.notyf.success(json.message);
                            var html = '<div class="item">\
                                            <div class="image" data-name="'+parent.attr('data-name')+'" style="background-image: url(\''+json.croped+'\');" data-href="'+json.file_url+'"></div>\
                                            <label class="checkbox"><input type="checkbox" class="gallery-checkbox"><span class="icon"></span></label>\
                                            <div class="favorite">\
                                                <input type="hidden" name="'+parent.attr('data-name')+'[highlighted][]" value="0">\
                                                <div class="icon"><i class="far fa-star"></i><i class="fas fa-star"></i></div>\
                                            </div>\
                                            <input type="hidden" name="'+parent.attr('data-name')+'[image][]" value="'+json.file+'">\
                                            <input type="hidden" name="'+parent.attr('data-name')+'[imageAlt][]">\
                                            <input type="hidden" name="'+parent.attr('data-name')+'[imageTitle][]">\
                                        </div>';
                            parent.find('.itens').append(html);
                            parent.addClass('filled');
                            parent.trigger('fchange');
                            $('.modal-image').modal('hide');
                            $('.modal-crop').modal('hide');
                            $('#getCrop').remove();
                            $('#cropDiv').remove();
                            var image = $('#cropThis');
                            var cropper = image.data('cropper');
                            if (cropper !== undefined) {
                                cropper.destroy();
                            }
                        } else{
                            if(json.message){
                                app.notyf.error(json.message);
                            }
                        }
                        parent.removeClass('loading');
                        input.val('');
                    }
                });
            });
        }

    });
}

function getCropEvents() {
    $('body').on('change', "[name='aspect']", function() {
        var image = $('#cropThis');
        var cropper = image.data('cropper');
        let aspect = $("[name='aspect']").val();
        let ratio = NaN;
        if (aspect !== "Livre") {
            aspect = aspect.split(":");
            ratio = parseInt(aspect[0]) / parseInt(aspect[1])
        }
        cropper.setAspectRatio(ratio);
    });

    $('body').on('keyup', "[dimensionInput]", function() {
        changeDimension();
    });

    $('body').on('click', "[dimensionInput]", function() {
        changeDimension();
    });

    $('body').on('click', ".cancel-btn-crop", function() {
        closeModal();
    });

    zoomEvent();
}

//Crop de imagens
/**
 * Mostra o modal da imagem com inputs de alt e title
 * @param {*} parent 
 */
function showImageModalAfterSend(parent) {
    $(parent).children('div.ctrls').children('.see').click()
}

function getImageDetailsModal(src, alt, title, name, nameAlt, nameTitle) {
    let html = `
        <img src="${src}" alt="${alt}" title="${title}" class="img-fluid">
        <div class="row" id="rowTitle">
            <div class="col-6 mt-2 d-flex">
                <h5>Alt da Imagem:</h5>
            </div>
            <div class="col-6 mt-2 d-flex">
                <h5>Título da Imagem:</h5>
            </div>
        </div>
        <div class="row" id="rowInputs">
            <div class="col-6">
                <input type="text" style="width:inherit;" value="${alt}" id="imageAlt" placeholder="Alt da imagem">
            </div>
            <div class="col-6">
                <input type="text" style="width:inherit;" value="${title}" id="imageTitle" placeholder="Título da imagem">
            </div>
        </div>
        <div class="row" id="rowButtons">
            <div class="col-12 mt-2 d-flex" style="justify-content: flex-end;">
                <button type="button" class="btn btn-secondary btn-lg mr-2 modal-image-close" data-dismiss="modal" aria-label="Close">Fechar</button>
                <button name="${name}" nameAlt="${nameAlt}" nameTitle="${nameTitle}"
                    id="sendImageAttributes" type="button" class="btn btn-primary btn-lg">Inserir</button>
            </div>    
        </div>
    `;

    return html;
}

$(document).ready(function(){
	app = new Main();
});
