/*
 $(document).ready(function() {}); 

 */

$(function() {
    
    // hide all the book category divs' blockquote's when the page first loads
    $('div.bookGenre > blockquote').hide();
    
    // display first div's blockquote by default
    $('div.bookGenre:first > blockquote').show();
    
    $('div.bookGenre h3:first-child').css('cursor', 'crosshair')
            .click(function() {
                
                $(this).next().slideToggle('slow', 'easeOutBounce');
                
            });
    
});