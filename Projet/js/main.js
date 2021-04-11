(function() {
    "use strict";
    const URL_IS_CONNECTED = "php/connexion.php";
    const URL_LOGIN = "php/login.php";
    const URL_LOGOUT = "php/logout.php";

	
    let showMessage = (message) => {
        $("#message").html(message).fadeIn();
    };

    let listeCocktails = (nom/*, tab, i*/) => {
        $("#liste").append(
            $("<button />")
                .append(nom)
                .click(function () {
                    $("#liste")
                        .append("<div />")
							.append("Ingrédients : " + tab[i*3] +", "+ tab[i*3+1] +", "+ tab[i*3+2])

                })
        )

    };


    $(() => {
        $.ajax({
            url: URL_IS_CONNECTED,
            method: "get",
            dataType: "json"
        })
            .done(function (data) {
                if (data.hasOwnProperty("result")) {
                    if (data.result) {
                        let $login_logout = $("#login-logout");
                        $login_logout.empty();
                        if (data.hasOwnProperty("is_connected")) {
                            if (data.is_connected) {

                                $login_logout.append(
                                    $("<button />")
                                        .append("logout")
                                        .click(function () {
                                            $.ajax({
                                                url: URL_LOGOUT,
                                                method: "get",
                                                dataType: "json"
                                            })
                                                .done(() => window.location.reload(true))
                                                .error(function () {

                                                })
                                        })
                                );
                                
                                $.ajax({
                                    url: "php/affiche_cocktails.php",
                                    method: "get",
                                    dataType: "json"
                                })
                                    .done (function (data) {
                                        
                                        if (data.hasOwnProperty("tableau")) {
											
                                            if (data.hasOwnProperty("ing")) {
												
                                                for (let i = 0; i < data.tableau.length; i++) {
													console.log("23")
                                                    listeCocktails(data.tableau[i],ing,i);
                                                }
                                            }
											else {  }
                                        }
										else { }

                                    })
                                    .fail (function (data) {  } )


                            } else {
                               
                                $login_logout.append(
                                    $("<form />")
                                        .attr("action", URL_LOGIN)
                                        .attr("method", "post")
                                        .append(
                                            $("<input />")
                                                .attr("type", "text")
                                                .attr("name", "username"),
                                            $("<input />")
                                                .attr("type", "password")
                                                .attr("name", "password"),
                                            $("<button />")
                                                .append("Login")
                                                .attr("type", "submit")
                                        )
                                        .submit(function () {
 
                                            let $data = $(this).serialize();
                                            let $self = $(this);
                                            $self.hide();
                                            $("#message").hide();
                                            $.ajax({
                                                url: URL_LOGIN,
                                                method: $(this).attr("method"),
                                                data: $data,
                                                dataType: "json"
                                            })
                                                .done(function (data) {
                                                    
                                                    if (data.hasOwnProperty("result")) {
                                                        if (data.result) {
                                                            window.location.reload(true);
                                                        } else {
                                                            showMessage(data.message);
                                                            $self.show();
                                                        }
                                                    }

                                                })
                                                .fail(function (data) { console.log("Erreur"); })
                                            return false;
                                        })
                                );
                                console.log("PostDOne");
                            }
                        }
                        $login_logout.fadeIn(2000);
                    } else {

                        console.log("Erreur");
                    }
                } else {
                    console.log("qdcqddc");
                }
            })
            .fail(function () {

            });
    });
}) ();