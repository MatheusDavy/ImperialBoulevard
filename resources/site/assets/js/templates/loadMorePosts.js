export default function loadMoreData(){
    $('#load-more').click(function() {
        var page = $(this).data('paginate');
        loadMoreData(page);
        $(this).data('paginate', page+1);
    });
    function loadMoreData(paginate) {
        $.ajax({
            url: '?page=' + paginate,
            type: 'get',
            datatype: 'html',
            beforeSend: function() {
                $('#load-more').text('carregando...');
            }
        })
        .done(function(data) {
            if(data.length == 0) {
                $('.invisible').removeClass('invisible');
                $('#load-more').hide();
                return;
              } else {
                $('#load-more').text('carregar mais posts');
                $('#post').append(data);
              }
        })
           .fail(function(jqXHR, ajaxOptions, thrownError) {
              alert('Algo deu errado.');
           });
    }
}
