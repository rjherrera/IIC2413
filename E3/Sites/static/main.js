// SEMANTIC UI JS
$('.ui.menu .item').tab();
$('.dropdown').dropdown();
$('.ui.checkbox').checkbox();
$('.ui.progress').progress();
// END OF SEMANTIC UI JS


function consulta_1(){
  var data = $('#form_consulta_1').form('get values');
  $('#button_consulta_1').addClass('loading');
  $.ajax({
    type: 'POST',
    url: 'consultas.php',
    data: data,
    dataType: 'json',
    success: function(data){
      $('#cards_consulta_1').empty();
      $('#cards_consulta_1').append(data);
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_consulta_1').removeClass('loading');
    }
  });
  return false
}

function consulta_2(){
  var data = $('#form_consulta_2').form('get values');
  $('#button_consulta_2').addClass('loading');
  $.ajax({
    type: 'POST',
    url: 'consultas.php',
    data: data,
    dataType: 'json',
    success: function(data){
      $('#resultado_consulta_2').empty();
      $('#resultado_consulta_2').append(data);
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_consulta_2').removeClass('loading');
    }
  });
  return false
}


function consulta_3(){
  var data = $('#form_consulta_3').form('get values');
  $('#button_consulta_3').addClass('loading');
  $.ajax({
    type: 'POST',
    url: 'consultas.php',
    data: data,
    dataType: 'json',
    success: function(data){
      $('#resultado_consulta_3').empty();
      $('#resultado_consulta_3').append(data);
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_consulta_3').removeClass('loading');
    }
  });
  return false
}


function consulta_4(){
  var data = $('#form_consulta_4').form('get values');
  $('#button_consulta_4').addClass('loading');
  $.ajax({
    type: 'POST',
    url: 'consultas.php',
    data: data,
    dataType: 'json',
    success: function(data){
      $('#resultado_consulta_4').empty();
      $('#resultado_consulta_4').append(data);
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_consulta_4').removeClass('loading');
    }
  });
  return false
}


function consulta_5(){
  var data = $('#form_consulta_5').form('get values');
  $('#button_consulta_5').addClass('loading');
  $.ajax({
    type: 'POST',
    url: 'consultas.php',
    data: data,
    dataType: 'json',
    success: function(data){
      $('#resultado_consulta_5').empty();
      $('#resultado_consulta_5').append(data);
    },
    error: function(data){
      console.log('error 500');
    },
    complete: function(data){
      console.log('complete');
      $('#button_consulta_5').removeClass('loading');
    }
  });
  return false
}


$('#form_consulta_1')
  .form({
    fields: {
      name: {
        identifier: 'user',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor seleccione un usuario'
          }
        ]
      },
    },
    inline: true,
    onSuccess: function (){
      consulta_1();
    },
  })
;


$('#form_consulta_2')
  .form({
    fields: {
      name: {
        identifier: 'user',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor seleccione un usuario'
          }
        ]
      },
    },
    inline: true,
    onSuccess: function (){
      consulta_2();
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


$('#form_consulta_3')
  .form({
    fields: {
      genero: {
        identifier: 'genero',
        rules: [
          {
              type: "isAllEmpty[fecha]",
              prompt: 'Por favor ingrese genero y/o fecha'
          }
        ]
      },
      fecha: {
        identifier: 'fecha',
        rules: [
          {
            type: "isAllEmpty[genero]",
            prompt: 'Por favor ingrese genero y/o fecha'
          },
          {
            type: "regExp[/^$|^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/]",
            prompt: 'Ingrese una fecha válida'
          }
        ]
      }
    },
    inline: true,
    onSuccess: function (){
      consulta_3();
    },
  })
;


$('#form_consulta_4')
  .form({
    fields: {
      name: {
        identifier: 'actor',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor seleccione un actor'
          }
        ]
      },
    },
    inline: true,
    onSuccess: function (){
      consulta_4();
    },
  })
;


$('#form_consulta_5')
  .form({
    fields: {
      name: {
        identifier: 'serie',
        rules: [
          {
            type   : 'empty',
            prompt : 'Por favor seleccione una serie'
          }
        ]
      },
    },
    inline: true,
    onSuccess: function (){
      consulta_5();
    },
  })
;