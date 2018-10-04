let errorsDiv;



$(document).ready(() => {

  if (window.location.href.search('000webhostapp') > -1) {
    document.getElementsByTagName("body")[0].children[1].remove()
  };

  errorsDiv = $("#errors");



  const signup_form = $("#signup_form");



  if (document.cookie.search("user") > -1) {

    window.location.href = "/pages/tasks.html";

  }



  signup_form.submit(e => {

    e.preventDefault();



    errorsDiv.empty();



    $.ajax({

      type: "POST",

      url: "/php/signup.php",

      data: signup_form.serialize(),

      success: function(response) {

        alert("Вы успешно зарегестрировались");

        signup_form.each(function() {

          this.reset();

        });

      },

      error: showWarning

    });

  });



  const login_form = $("#login_form");



  login_form.submit(e => {

    e.preventDefault();



    errorsDiv.empty();



    $.ajax({

      type: "POST",

      url: "/php/login.php",

      data: login_form.serialize(),

      success(response) {

        alert("Добро пожаловать");

        window.location.href = "pages/tasks.html";

      },

      error: showWarning

    });

  });

});



function showWarning(response) {

  try {

    const responseError = JSON.parse(response.responseText);



    let errorHtml = "";

    responseError.forEach(textError => {

      errorHtml += `<h5>${textError}</h5><br>`;

    });

    errorsDiv.append(errorHtml);

  } finally {

    alert("Данные введены не верно");

  }

}

