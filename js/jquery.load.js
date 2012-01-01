/* 
Title: Photo Tagging
Author: Neill Horsman
URL: http://www.neillh.com.au
Credits: jQuery, imgAreaSelect 
*/

$(window).ready(function() {

  //Set up imgAreaSelect
	$('.start-tagging').click(function() {
		$('.start-tagging').toggle("hide");
		$('.finish-tagging').toggle("hide");
		//load imgAreaSelect (#imageid must equal the id or class of your image.
		//$('img#imageid').imgAreaSelect({ handles: true, onSelectChange: selectChange, keys: { arrows: 15, shift: 5 }, aspectRatio: '4:3', maxWidth: 150, maxHeight: 100 });
		$('img#imageid').imgAreaSelect({
			disable: false, //enable/disable tagging
			handles: true, //grab handels when selecting the area
			keys: { arrows: 15, shift: 5 }, //keyboard support
			aspectRatio: '1:1',
			maxWidth: 62, //adjust the max tag width
			maxHeight: 62, //adjust the max tag height
			fadeSpeed: 200,
			onSelectEnd: function(img, selection){ //after you have selected an area, show the form and insert tag location values into a form
				$('input#x1').val(selection.x1);
				$('input#y1').val(selection.y1);
				$('input#x2').val(selection.x2);
				$('input#y2').val(selection.y2);
				$('input#w').val(selection.width);
				$('input#h').val(selection.height);
				$('#title_container').css('left', selection.x1);
				$('#title_container').css('top', selection.y2);
				$('#title_container').removeClass("hide");
				if (selection.width == 0 && selection.height == 0) { $('#title_container').addClass("hide"); } //if there is no selection, hide the form
		   },
		   onSelectStart: function(img, selection){
				$('#title_container').addClass("hide"); //if reselecting, hide the form
		   },
		});
	});
	$('.finish-tagging').click(function(){
		$('.start-tagging').toggle("hide");
		$('.finish-tagging').toggle("hide");
		$('#title_container').addClass("hide");
		$('img#imageid').imgAreaSelect({ disable: true, hide: true }); //disable imgareaselect, this along with start/finish-tagging can be removed if needed
	});

  //Tag list hovers ( when hovering the list of tags show the titles.
  $('#titles a.title').hover(function() {
    $('.map li').find('a.' + $(this).attr('id')).addClass('hover');
    $('.map li').find('a.' + $(this).attr('id')).find('span').show().addClass('selected');
  }, function() {
    $('.map li').find('a.' + $(this).attr('id')).removeClass('hover');
    $('.map li').find('a.' + $(this).attr('id')).find('span').hide().removeClass('selected');
  });

  //when hovering the tagged areas show the title
  $('.map li a').hover(function() {
    $(this).find('span').show();
  }, function() {
    $(this).find('span').hide();  
  });

	//Close the error box for form pages
	$('a#error-link').click(function() {
		$('#error-box').slideUp('slow');
		return false;
	});
	$('a#warning-link').click(function() {
		$('#warning-box').slideUp('slow');
		return false;
	});
});
