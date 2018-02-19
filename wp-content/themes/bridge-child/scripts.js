(function($){
  var queries = {};
  if(document.location.search){
	  $.each(document.location.search.substr(1).split('&'),function(c,q){
		var i = q.split('=');
		queries[i[0].toString()] = i[1].toString();
	  });
	  var link = $('li.menu-item a[href*="page_id=' + queries.page_id + '"]');
	  link.closest('.second').css('display', 'block');
	  link.closest('.has_sub').addClass('open');
  }
})(jQuery);