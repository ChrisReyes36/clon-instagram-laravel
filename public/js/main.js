const url = "http://localhost/master-php/proyecto-laravel/public";

document.addEventListener("DOMContentLoaded", function () {
    $(".btn-like").css("cursor", "pointer");
    $(".btn-dislike").css("cursor", "pointer");

    // Boton like
    function like() {
        $(".btn-like")
            .unbind("click")
            .click(function () {
                $(this).addClass("btn-dislike").removeClass("btn-like");
                $(this).attr("src", url + "/img/heart-red.png");
                const id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: url + "/like/" + id,
                    success: function (response) {
                        if (response.like) {
                            $(".number_likes_" + id).text(response.counter);
                        } else {
                            alert(response.message);
                        }
                    },
                });
                dislike();
            });
    }

    like();

    // Boton dislike
    function dislike() {
        $(".btn-dislike")
            .unbind("click")
            .click(function () {
                $(this).addClass("btn-like").removeClass("btn-dislike");
                $(this).attr("src", url + "/img/heart-black.png");
                const id = $(this).data("id");
                $.ajax({
                    type: "GET",
                    url: url + "/dislike/" + id,
                    success: function (response) {
                        if (response.like) {
                            $(".number_likes_" + id).text(response.counter);
                        } else {
                            alert(response.message);
                        }
                    },
                });
                like();
            });
    }

    dislike();

    // BUSCAR
    $("#buscador").submit(function (e) {
        $(this).attr("action", url + "/users/" + $("#buscador #search").val());
    });
});
