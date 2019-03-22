CourseStaff = {
    email: function(){
        return "<a href=\"http://www.google.com/recaptcha/mailhide/d?k=01lwbtCEOC5rJLykXHmYVj1Q==&amp;c=BY0cGtGpUZiTQRbeRJkusw==\" "+
               "onclick=\"window.open('http://www.google.com/recaptcha/mailhide/d?k\07501lwbtCEOC5rJLykXHmYVj1Q\75\75\46c\75BY0cGtG"+
               "pUZiTQRbeRJkusw\75\075', '', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=500,height="+
               "300'); return false;\" title=\"Reveal this e-mail address\">bl...</a>@cs.uw.edu";
    }
}

$(document).ready(function () {
   $('.staff-uwnetid').each(function(_, uwid) {
       var $uwid = $(uwid);
       $uwid.html("<a href='mailto:" + $uwid.text() + "@uw.edu" + "'>" + $uwid.text() + "@uw</a>");
   });
    $('.staff-csid').each(function(_, csid) {
       var $csid = $(csid);
       $csid.html("<a href='mailto:" + $csid.text() + "@cs.washington.edu" + "'>" + $csid.text() + "@cs</a>");
   });

});
