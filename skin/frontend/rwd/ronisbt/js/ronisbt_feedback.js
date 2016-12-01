jQuery(function($) {

    var subject = $("#feedback-subject .subject");
    var other_subject = $("#feedback-subject .other-subject");
    var other_subject_box = $("#feedback-subject .other-subject-box");

    function checkCheck() {
        if (subject.val() == "other") {
            other_subject_box.show(300);
            other_subject.addClass("required-entry");
        } else {
            other_subject_box.hide(300);
            other_subject.removeClass("required-entry");
        }
    }
    checkCheck();

    subject.on('change', function () {
        checkCheck();
    });

});
