(function($){$.fn.extend({confirmModal:function(options){var html='<div class="modal" id="confirmContainer"><div class="modal-header"><a class="close" data-dismiss="modal">×</a>'+'<h3>#Heading#</h3></div><div class="modal-body">'+'#Body#</div><div class="modal-footer">'+'<a href="javascript: void(0);" class="btn btn-primary" id="confirmYesBtn">#Confirm#</a>'+'<a href="javascript: void(0);" class="btn" data-dismiss="modal">#Close#</a></div></div>';var defaults={heading:'Please confirm',body:'Body contents',confirmButton:'Да',closeButton:'Нет',callback:null};var options=$.extend(defaults,options);html=html.replace('#Heading#',options.heading).replace('#Body#',options.body).replace('#Confirm#',options.confirmButton).replace('#Close#',options.closeButton);$(this).html(html);$(this).modal('show');var context=$(this);$('#confirmYesBtn',this).click(function(){if(options.callback!=null)
options.callback();$(context).modal('hide');});}});})(jQuery);

jQuery(function($) {
	$('#selectedIds-form').on('click','input[type=button]',function() {
		if($('#selectedItems').val() != 'delete'){
			processSelectedAction();
		} else {
			$('#confirmDiv').confirmModal({
				heading: 'Запрос на подтверждение',
				body: 'Вы уверены?',
				confirmButton: 'Да',
				closeButton: 'Отмена',
				callback: function () {
					processSelectedAction();
				}
			});
		}
		return false;
	});

	$('body').on('click','#cbcwr_clear',function(){
		window.location.href=$('#cleared_url').val();
	});

	$('body').on('click','.delete-cat',function(){
		var $this=$(this);
		$('#confirmDiv').confirmModal({
			heading: 'Запрос на подтверждение',
			body: 'Вы уверены?',
			confirmButton: 'Да',
			closeButton: 'Отмена',
			callback: function () {
				processSelectedAction();
				window.location.href=$this.attr('href');
			}
		});
		return false;
	});

	if($('#grid_keys').length) $('#grid .keys').attr('title',$('#grid_keys').val());
	/*
	 *
	 * @returns {undefined}
	 * $('.matter').on('click','table.table.items tbody a',function(){
			if(!$(this).hasClass('delete')){
				if($(this).attr('href').indexOf('?return')==-1){
					$(this).attr('href',$(this).attr('href')+'?return='+$('#grid').yiiGridView('getUrl'));
				}
			}
		});
	 */

	$('body').on('click','.not-menu',function(){
		saveMenuState('hide');
		$('#main').animate({'width':$('.span12').css('width')},{duration: 400, complete: function() {
			$('#main').removeClass('span9').addClass('span12');
			$('.not-menu-active').css({'display':'block'});
		}});
		$('.sidebar-block').animate({'width':0},{duration: 300, complete: function() {
			$('.sidebar-block').css({'display':'none'});
		}});
		return false;
	});

	$('body').on('click','.not-menu-active',function(){
		saveMenuState('show');
		$('#main').animate({'width':$('.span9').css('width')},{duration: 400, complete: function() {
			$('#main').removeClass('span12').addClass('span9');
			$('.not-menu-active').hide();
		}});
		$('.sidebar-block').animate({'width':$('.span3').css('width')},{duration: 300, complete: function() {
			$('.sidebar-block').css({'display':'block'});
		}});
		return false;
	});

	$('body').on('click','.delete-jqupload', function(){
		var $this=$(this),$parent=$(this).closest('.img-jqupload-body');
		if(confirm('Удалить?')) {
			$this.closest('.preview').after('<input type=hidden name='+$parent.attr('data-model')+'[updatedimage]['+$this.attr('data-id')+']  value=1>');
			$this.closest('.preview').remove();
			rebuildImagesJQUpload($parent.attr('data-model'),$parent.attr('data-field'));
		}
		return false;
	});

	if($(".img-jqupload-body").length){
		$(".img-jqupload-body").sortable({
			placeholder: "ui-state-highlight",
			scrollSpeed: 0,
			cursor: "move",
			delay: 0,
			cancel: "a,label,.item-td,button",
			//handle: ".icon-move",
			stop : function(){
				rebuildImagesJQUpload($(this).attr('data-model'),$(this).attr('data-field'));
			}
		});
	}
});

function saveMenuState(action){
	$.ajax({
		type: 'post',
		url: '/admin/admin/savestate',
		data: {
			action: action
		}
	});
}

function processGrid(){
	/*$('.matter #grid table.table.items tbody a').each(function(){
		if(!$(this).hasClass('delete')){
			if($(this).attr('href').indexOf('?return')==-1){
				var url=$('#grid').yiiGridView('getUrl');
						//.replace("?ajax=grid", '').replace("&ajax=grid", '').replace("/ajax/grid", '/').replace("//", '/');//.replace("?","&")
				$(this).attr('href',$(this).attr('href')+'?return='+encodeURIComponent(url));
			}
		}
	});
	$('.create-btn').attr('href',$('.create-btn').attr('href')+'?return='+encodeURIComponent($('#grid').yiiGridView('getUrl')));*/
}

function processSelectedAction(){
	$('#selectedIds-form input[name="selectedIds[]"]').remove();
	$('#grid input[name="selectedIds[]"]:checked').each(function(){
		$('#selectedIds-form').append('<input type="hidden" name="selectedIds[]" value="' + $(this).val() + '" />');
	});
	$.ajax({
		type: 'post',
		url: $('#selectedIds-form').attr('action'),
		data: $('#selectedIds-form').serialize(),
		success: function (html) {
			$.fn.yiiGridView.update('grid');
		},
	});
}

function rebuildImagesJQUpload(model,field){
	var s=[];
	$(".ijb-"+field+" .preview .panel .delete-jqupload").each(function(indx, element){
		s.push($(element).attr("data-id"));
	});
	$('#yt'+model+'_'+field).val(s.join(";"));
}