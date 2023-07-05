export default function scrollBlog(){
    var currentscrollHeight = 0;
    let paginate = $("#blogContent").attr('data-paginate');
    let active = true;

    $(window).on("scroll", function () {
        const scrollHeight = Math.floor($(".newslleter-component").height() * 2) + currentscrollHeight;
        const scrollPos = Math.floor($(window).height() + $(window).scrollTop());
        let isBottom = scrollHeight < scrollPos;

        if (isBottom && active) {
            // alert('calling...');
            callData(paginate);
            paginate++
            $('html, body').animate({
                scrollTop: currentscrollHeight + 80
            }, 100);
            $("#blogContent").attr('data-paginate', parseInt(paginate)+1);
            currentscrollHeight = currentscrollHeight + 80;
        }
    });

    function callData(page) {
        $.ajax({
            type: "GET",
            url: '?page=' + page,
            datatype: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                let json = JSON.parse(data);
                if (json.content.length == 0) {
                    active = false;
                } else {
                    $.each(json.content, function (index, el) {
                        $(`<div class='col-md-4 col-12'>
                            <div class='card__blog'>
                                <div class="img__description">
                                    <span>${el.image_description}</span>
                                </div>
                                <div class='card__img'>
                                    <img src="${el.image}" alt=''>
                                    <div class="gradient"></div>
                                </div>
                                <div class='note'>
                                        <img src="${el.nota}" alt=''>
                                        <!--Date-->
                                        <span class='date'>${el.date}</span>
                                        </div>
                                <div class="title">
                                    <h1>${el.title}</h1>
                                </div>
                                <p>
                                    ${el.text}
                                </p>
                                <div class='links'>
                                    <div class='continue__reading'>
                                        <a href="${el.slug}">
                                            <span>${el.read}</span>
                                            <span></span>
                                        </a>
                                    </div>
                                    <div class='see__all'>

                                    </div>
                                </div>
                            </div>
                        </div>`).appendTo('#blogContent');
                    });
                }

                // content.appendTo('#content');
            },
            error: function (result) {
                alert("error");
                $('<div class="card my-4 py-3"><h4 class="card-title">Erro/h4><p>' + '</p></div>').appendTo('#blogContent');
            }
        });
    }

}
