import moment from 'moment';

moment.relativeTimeThreshold('m', 60);
moment.relativeTimeThreshold('d', 3000);
moment.relativeTimeThreshold('h', 24);

if (locale === undefined) {
    locale = 'en';
}
moment.locale(locale);

$('.moment-date').each(function() {
    let $this = $(this);
    $this.html(moment($this.data('date')).fromNow());
});

jQuery('.teammatches').click(function() {
    let team = $(this).parent();
    let teamid = team.data('id');
    let $modal = $('#teammatchesModal');
    $.get('/' + teamid, function(data) {
        $modal.find('.modal-title').html(team.html());
        $modal.find('.modal-body').html(data);
        $modal.find('.moment-date').each(function() {
            let $this = $(this);
            $this.html(moment($this.data('date')).fromNow());
        });

        const modal = document.getElementById('teammatchesModal');
        const closebtn = document.getElementsByClassName("close")[0];
        modal.style.display = "block";
        closebtn.onclick = function() {
            modal.style.display = "none";
        };
        window.onclick = function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };
    });
});

jQuery('.team--name span').hover(
    function() {
        let id = $(this).parent().data('id');
        $('.team--name[data-id="' + id + '"]').addClass('team--name--hover');
    },
    function() {
        let id = $(this).parent().data('id');
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
