// SEMANTIC UI JS
$('.ui.menu .item').tab();
$('.dropdown').dropdown();
$('.ui.checkbox').checkbox();
$('.ui.progress').progress();
$('.ui.accordion').accordion({onChange: function(){$('.ui.modal').modal('refresh')}});
$('#container_mostrar').hide();

// END OF SEMANTIC UI JS

function enable_daterangepicker() {
  $('#input-fecha').daterangepicker({
    format: 'YYYY-MM-DD',
    singleDatePicker: true,
    locale: {
      daysOfWeek: [
        'Do',
        'Lu',
        'Ma',
        'Mi',
        'Ju',
        'Vi',
        'Sa'
      ],
      monthNames: [
        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
      ],
      firstDay: 1
    }
  });
}

$('#search-inputs .input').keyup(function(event) {
  if (event.keyCode == 13) {
    $('#search-content-type .button').click();
  }
});

$('#search-type .dropdown').dropdown({
  onChange: function(value, text, $choice) {
    $input_container = $('#search-inputs');
    $input_container.empty();
    if (value == 'nombre') {
      $input_container.append('<div class="ui icon fluid input"><input type="text" id="nombre_busqueda" placeholder="Nombre..."><i class="search icon"></i></div>');
    }
    else if (value == 'genero') {
      $input_container.append('<div class="ui icon fluid input"><input type="text" placeholder="Género..."><i class="search icon"></i></div>');
    }
    else if (value == 'fecha') {
      $input_container.append('<div class="ui icon fluid input"><input id="input-fecha" type="text" placeholder="Fecha..."><i class="search icon"></i></div>');
      enable_daterangepicker();
    }
    else if (value == 'nombre-fecha') {
      $input_container.append('<div class="ui grid"><div class="eight wide column"><div class="ui icon fluid input"><input type="text" placeholder="Nombre..."><i class="search icon"></i></div></div><div class="eight wide column"><div class="ui icon fluid input"><input id="input-fecha" type="text" placeholder="Fecha..."><i class="search icon"></i></div></div></div>');
      enable_daterangepicker();
    }
    else if (value == 'genero-fecha') {
      $input_container.append('<div class="ui grid"><div class="eight wide column"><div class="ui icon fluid input"><input type="text" placeholder="Género..."><i class="search icon"></i></div></div><div class="eight wide column"><div class="ui icon fluid input"><input id="input-fecha" type="text" placeholder="Fecha..."><i class="search icon"></i></div></div></div>');
      enable_daterangepicker();
    }

    $('#search-inputs .input').keyup(function(event) {
      if (event.keyCode == 13) {
        $('#search-content-type .button').click();
      }
    });

  }
});

$('#search-content-type .button').click(function() {
  var search_type = $('#search-type .dropdown').dropdown('get value');
  var content_type = $('#search-content-type .dropdown.selection').dropdown('get value');
  console.log(typeof(search_type));
  console.log(content_type);
  if (typeof(search_type) == 'object' || content_type == '') {
    $('#search-content-type .button').popup({
      on: 'manual',
      content: 'Falta un campo'
    }).popup('show');
    setTimeout(function() {
      $('#search-content-type .button').popup('hide');
    }, 1500);
  }
  else {
    $(this).addClass('loading');
    var input_values = $('#search-inputs input').map(function() {
      return $(this).val();
    }).get();
    $.ajax({
      method: 'GET',
      url: 'search.php',
      data: {
        search_type: search_type,
        input_values: input_values,
        content_type: content_type
      }
    }).done(function(msg) {
      $('#search-content-type .button').removeClass('loading');
      console.log(msg);
      $('#search-results .cards').empty().append(msg);
      $('#search-results').removeClass('hidden');
    });
  }
});


// $('#search-container ').click(function(event){
//   var data = $('#nombre_busqueda').val();
//
//   $.ajax({
//     type: 'POST',
//     url:'search.php',
//     data: data,
//     dataType:'json',
//     success: function(data){
//       console.log('search');
//       window.location = 'search.php';
//       if (data){
//         window.location = 'search.php';
//       }
//       else {
//         $('#error_search').show();
//         $('#error_search ul li').html('La busqueda no tiene resultados');
//       }
//     },
//     error: function(data){
//       console.log('error 500');
//     },
//     complete: function(data){
//       console.log('complete');
//     }
//   });
// });


$('#overlay_button').on("click", function(event){
  $('#overlay_button').addClass('loading');
  var data = {'username': username, // son variables que fueron definidas en
              'entretenimiento': id_e}; // ver_pelicula.php al fondo en un js inline
  $.ajax({
    type: 'POST',
    url: 'agregar_visto.php',
    data: data,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if (data == true){
        $('#overlay_button').hide(); // si tiene restantes lo dejamos
        $('#video').embed();
      }
      else {
        $('#overlay_button').text('No tiene suficientes "vistos" restantes para ver este contenido.');
        $('#overlay_button').addClass('negative');
      }
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#overlay_button').removeClass('loading');
    }
  });
  return false
});

$('#plan_basico').on("click", function(event){
  var data = {'username': username, // son variables que fueron definidas en
              'plan_escogido': 1}; // ver_pelicula.php al fondo en un js inline
  $.ajax({
    type: 'POST',
    url: 'consultas_planes.php',
    data: data,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if (data == true){
        $('#container_mostrar').show();
        $('#mostrar').text('Ha contratado el plan básico satisfactoriamente. El cobro se ha añadido a su tarjeta.');
        $('#actual').text('Plan actual contratado: Básico');
        $('#n_plan').text('10');
      }
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
    }
  });
  return false
});


$('#plan_medio').on("click", function(event){
  $('#plan_medio').addClass('loading');
  var data = {'username': username, // son variables que fueron definidas en
              'plan_escogido': 2}; // ver_pelicula.php al fondo en un js inline
  $.ajax({
    type: 'POST',
    url: 'consultas_planes.php',
    data: data,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if (data == true){
        $('#container_mostrar').show();
        $('#mostrar').text('Ha contratado el plan medio satisfactoriamente. El cobro se ha añadido a su tarjeta.');
        $('#actual').text('Plan actual contratado: Medio');
        $('#n_plan').text('20');
      }
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
    }
  });
  return false
});


$('#plan_premium').on("click", function(event){
  $('#plan_premium').addClass('loading');
  var data = {'username': username, // son variables que fueron definidas en
              'plan_escogido': 3}; // ver_pelicula.php al fondo en un js inline
  $.ajax({
    type: 'POST',
    url: 'consultas_planes.php',
    data: data,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if (data == true){
        $('#container_mostrar').show();
        $('#mostrar').text('Ha contratado el plan premium satisfactoriamente. El cobro se ha añadido a su tarjeta.');
        $('#actual').text('Plan actual contratado: Premium');
        $('#n_plan').text('30');
      }
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
    }
  });
  return false
});





function login(){
  var data = $('#form_login').form('get values');
  $('#button_login').addClass('loading');
  $('#error_login').hide()
  $.ajax({
    type: 'POST',
    url: 'login.php',
    data: data,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if (data == true){
        window.location='home.php';
      }
      else if (data == false){
        $('#error_login').show();
        $('#error_login ul li').html('Usuario o contraseña incorrectas.');
      }
      else {
        $('#error_login').show();
        $('#error_login ul li').html('Usted no tiene usuario en QuiPasa.');
      }
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_login').removeClass('loading');
    }
  });
  return false
}


function register(){
  var data = $('#form_register').form('get values');
  $('#button_register').addClass('loading');
  $('#error_register').hide();
  $.ajax({
    type: 'POST',
    url: 'register.php',
    data: data,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if (data == true){
        window.location='home.php';
      }
      else {
        $('#error_register').show();
        $('#error_register ul li').text(data['error']);
        $('html, body').animate({scrollTop: 0}, 100);
      }
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_register').removeClass('loading');
    }
  });
  return false
}


$('#form_login')
  .form({
    fields: {
      username: {
        identifier: 'username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor ingrese su usuario.'
          },
        ]
      },
      password: {
        identifier: 'password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor ingrese su password.'
          },
        ]
      },
    },
    inline: true,
    onSuccess: function (){
      login();
    },
  })
;


$('#form_login')
  .form({
    fields: {
      username: {
        identifier: 'username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor ingrese su usuario.'
          },
        ]
      },
      password: {
        identifier: 'password',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor ingrese su password.'
          },
        ]
      },
    },
    inline: true,
    onSuccess: function (){
      login();
    },
  })
;


$('#form_register')
  .form({
    fields: {
      sexo: {
        identifier: 'sexo',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor ingrese su sexo.'
          },
          {
            type   : 'regExp[/^[^MF]*(M|F){1}[^MF]*$/]',
            prompt : 'Por favor ingrese M o F.'
          }
        ]
      },
      edad: {
        identifier: 'edad',
        rules: [
          {
            type   : 'integer[1..130]',
            prompt : 'Por favor ingrese un entero positivo menor a 130.'
          },
        ]
      },
      username: {
        identifier: 'username',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor ingrese un usuario.'
          },
        ]
      },
      nombre: {
        identifier: 'nombre',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor ingrese su nombre.'
          },
        ]
      },
      email: {
        identifier: 'email',
        rules: [
          {
            type   : 'email',
            prompt : 'Por favor ingrese un email válido.'
          },
        ]
      },
      password: {
        identifier: 'password',
        rules: [
          {
            type   : 'minLength[2]',
            prompt : 'Por favor ingrese una password de al menos 2 carácteres.'
          },
        ]
      },
    },
    inline: true,
    onSuccess: function (){
      register();
    },
  })
;


$.fn.form.settings.rules.isAllEmpty = function(text,csv){
    if (text)
        return true;
    var array = csv.split(',');
    var isValid = false;

    $.each(array,function(index,elem){
        var element = $("input[name='"+elem+"']");
        if (element && element.val())
            isValid = true;
    });
    return isValid;
};


$('#form_message')
  .form({
    fields: {
      to_user: {
        identifier: 'to_user',
        rules: [
          {
              type: "isAllEmpty[to_group]",
              prompt: 'Por favor ingrese usuario o grupo de destino'
          }
        ]
      },
      to_group: {
        identifier: 'to_group',
        rules: [
          {
            type: "isAllEmpty[to_user]",
            prompt: 'Por favor ingrese usuario o grupo de destino'
          },
        ]
      },
      mensaje: {
        identifier: 'mensaje',
        rules: [
          {
            type: 'maxLength[140]',
            prompt: 'Su mensaje se pasa de los 140 carácteres.'
          },
          {
            type: 'empty',
            prompt: 'Por favor ingrese un mensaje.'
          }
        ]
      }
    },
    inline: true,
    onSuccess: function (){
      message();
    },
  })
;


function message(){
  var data = $('#form_message').form('get values');
  $('#button_message').addClass('loading');
  $('#error_message').hide();
  $.ajax({
    type: 'POST',
    url: 'message.php',
    data: data,
    dataType: 'json',
    success: function(data){
      console.log(data);
      if (data == true){
        $('#error_message ul li').text('Mensaje enviado!');
        $('#error_message').addClass('positive').removeClass('error').show();
      }
      else {
        $('#error_message').addClass('error').removeClass('positive').show();
        $('#error_message ul li').text(data['error']);
        // $('html, body').animate({scrollTop: 0}, 100);
      }
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_message').removeClass('loading');
    }
  });
  return false
}