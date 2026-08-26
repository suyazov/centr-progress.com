function sendFos(){
	console.log('sendFos');
	let err=0;
  let n=$('#main_name').val();
  let t=$('#main_tel').val();

    if (n){
        $('#main_name').removeClass('err');
    }
    else{
        err=1;
        $('#main_name').addClass('err');
    } 
  
    if (t){
        $('#main_tel').removeClass('err');
    }
    else{
        err=1;
        $('#main_tel').addClass('err');
    } 

    if (err==0){
      $.ajax({
        type: "POST",
        data: {
          "n": n,
          "t": t,
        },
        dataType: "html",
        url: "/ajax/sendFos.php",
        beforeSend: function() {
        //$result.html('<div>Секунду...</div>');
        },
        success: function(data) {
            console.log(data);
            $('.main_form_rez').html(data);
        },
      });       
    }

}

function sendFosUsl(){
  console.log('sendFos');
  let err=0;
  let n=$('#usl_name').val();
  let t=$('#usl_tel').val();
  let str=$('#usl_str').val();

    if (n){
        $('#usl_name').removeClass('err');
    }
    else{
        err=1;
        $('#usl_name').addClass('err');
    } 
  
    if (t){
        $('#usl_tel').removeClass('err');
    }
    else{
        err=1;
        $('#usl_tel').addClass('err');
    } 

    if (err==0){
      $.ajax({
        type: "POST",
        data: {
          "n": n,
          "t": t,
          "str": str,
        },
        dataType: "html",
        url: "/ajax/sendFosUsl.php",
        beforeSend: function() {
        //$result.html('<div>Секунду...</div>');
        },
        success: function(data) {
            console.log(data);
            $('.main_form_rez').html(data);
        },
      });       
    }

}


function sendFosCont(){
  let $container=$('.fos_kont_c').first();
  let $button=$container.find('.main_form_rez_btn').first();
  let $result=$('.fos_kont_result').first();
  let $consent=$('#check_status1');
  let n=$.trim($('#kont_name').val());
  let t=$.trim($('#kont_tel').val());
  let digits=t.replace(/\D/g, '');

  if (!$result.length){
    $result=$('<div class="fos_kont_result CpCallbackResult" role="status" aria-live="polite"></div>');
    $result.insertAfter($container);
  }

  $('#kont_name').toggleClass('err', n.length < 2);
  $('#kont_tel').toggleClass('err', digits.length < 10);
  $('.fos_kont_polit').toggleClass('err', !$consent.prop('checked'));

  $result.removeClass('CpCallbackResultSuccess').addClass('CpCallbackResultError');
  if (n.length < 2){
    $result.text('Укажите имя.');
    $('#kont_name').focus();
    return;
  }
  if (digits.length < 10){
    $result.text('Укажите корректный телефон.');
    $('#kont_tel').focus();
    return;
  }
  if (!$consent.prop('checked')){
    $result.text('Подтвердите согласие на обработку персональных данных.');
    $consent.focus();
    return;
  }
  if (!window.CP_QUIZ || !window.CP_QUIZ.endpoint || !window.CP_QUIZ.token){
    $result.text('Форма временно недоступна. Позвоните нам по номеру в шапке сайта.');
    return;
  }
  if ($button.data('sending')) return;

  $button.data('sending', true).attr('aria-disabled', 'true');
  $result.text('Отправляем заявку…');
  $.ajax({
    type: 'POST',
    url: window.CP_QUIZ.endpoint,
    dataType: 'json',
    data: {
      name: n,
      phone: t,
      email: '',
      company: '',
      token: window.CP_QUIZ.token,
      page: window.location.href,
      answers: {'Тип заявки': 'Обратный звонок — страница Контакты'}
    }
  }).done(function(response){
    if (!response || !response.success){
      $result.text((response && response.error) || 'Не удалось отправить заявку.');
      return;
    }
    $result.removeClass('CpCallbackResultError').addClass('CpCallbackResultSuccess');
    $result.text('Спасибо! Заявка зарегистрирована, мы скоро перезвоним.');
    $('#kont_name, #kont_tel').val('');
    $consent.prop('checked', false);
    if (window.ym && window.CP_QUIZ.metrikaId){
      try { window.ym(window.CP_QUIZ.metrikaId, 'reachGoal', 'callback_success'); } catch (e) {}
    }
  }).fail(function(xhr){
    let message=xhr.responseJSON && xhr.responseJSON.error;
    $result.text(message || 'Не удалось отправить заявку. Позвоните нам по номеру в шапке сайта.');
  }).always(function(){
    $button.data('sending', false).removeAttr('aria-disabled');
  });
}
