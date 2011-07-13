function edit_entry(date)
{
    window.location = './entry.php?date='+date;
}

// Safe format for date: YYYY-MM-DD
function save_entry()
{
    var date = $('#input_date').attr('value');
    var text = $('#textarea_text').attr('value');

    $.ajax({
        type: 'POST',
        data: 'date='+date+'&text='+text,
        url: './scripts/save_entry.php',
        success: function(msg) { $('#save_status').text(msg); }
    });
}

$(function() {
    $('table#cal td.date').click(function() {
        var date = $(this).attr('date');
        edit_entry(date);
    });

    $('table#cal td.date').hover(function() {
        $(this).addClass('hover');
    },function() {
        $(this).removeClass('hover');
    });

    $('table#list td').click(function() {
        $(this).toggleClass('selected');
    });

    $('table.zebra tr:even td').addClass('even');
    $('table.zebra tr:odd td').addClass('odd');
});
