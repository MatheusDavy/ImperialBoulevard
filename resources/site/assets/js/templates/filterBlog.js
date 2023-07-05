export default function filterBlog(){
let url = $("#blogLoad").val();
$("#blogSelect").on('change', function () {
    let id = $("#blogSelect").val();
    let dataString = 'id=' + id;
    $("#ajax").val("");
    if (id == 0) {
        $("#ajax").val("ativado");
    }
    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-Token': $('input[name="_token"]').val()
        },
        data: dataString,
        dataType: 'json',
        success: function (data) {
            let json = data;
            let content = '';
            if (json.status == true) {
                $.each(json.content, function (index, el) {
                    content += `<div class='col-md-4 col-12'>
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
                </div>`;
                });
                $("#blogContent").html('');
                $("#blogContent").html(content);
            } else {

            }
        }

    });

});
}
