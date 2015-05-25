$(document)
  .ready(function() {
	  $('.ui.dropdown')
      .dropdown({
        on: 'click'
      })
    ;
	  $('.masthead .information')
      .transition('scale in')
    ;
  });