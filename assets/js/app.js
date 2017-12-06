import moment from 'moment';

$('.moment-date').each(function() {
    let $this = $(this);
    $this.html(moment($this.data('date')).fromNow());
});

jQuery('.team--name').hover(
    function() {
        let id = $(this).data('id');
        $('.team--name[data-id="' + id + '"]').addClass('team--name--hover');
    },
    function() {
        let id = $(this).data('id');
        $('.team--name[data-id="' + id + '"]').removeClass('team--name--hover');
    }
);

jQuery('.close').click(function() {
    let $this = jQuery(this);
    let $elem = $this.next();
    if ($elem.is(':hidden')) {
        $elem.slideDown(500);
        $this.removeClass('close--plus');
        $this.addClass('close--close');
    } else {
        $elem.slideUp(500);
        $this.removeClass('close--close');
        $this.addClass('close--plus');
    }
});
