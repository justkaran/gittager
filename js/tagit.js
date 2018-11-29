$(document).ready(function(){
    // save tag to database
    $(document).on('click', '#btn_add', function(){
        var tags = $('#tags').val();
        var user = $(this).data( "usr" );
        var url = $(this).data( "url" );
        var notes = $('#notes').val();
        $.ajax({
            url: 'tagit-ajax.php',
            type: 'POST',
            data: {
                'create': 1,
                'tags': tags,
                'user': user,
                'url': url,
                'notes': notes,
            },
            success: function(response){
                document.getElementById('maincontent').innerHTML = "<i class=\"fas fa-check\"></i> TAGs successfully saved <a href='javascript:window.close();'>close window</a>";
                //location.reload();
            }
        });
    });

    $(document).on('click', '.btn_del', function(){
        var item = $(this).data( "id" );
        $.ajax({
            url: 'tagit-ajax.php',
            type: 'POST',
            data: {
                'delete': 1,
                'item': item,
            },
            success: function(response){
                location.reload();
            }
        });

    });

});