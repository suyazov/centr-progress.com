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
  console.log('sendFos');
  let err=0;
  let n=$('#kont_name').val();
  let t=$('#kont_tel').val();
  let str=$('#usl_str').val();

    if (n){
        $('#kont_name').removeClass('err');
    }
    else{
        err=1;
        $('#kont_name').addClass('err');
    } 
  
    if (t){
        $('#kont_tel').removeClass('err');
    }
    else{
        err=1;
        $('#kont_tel').addClass('err');
    } 

    if (err==0){
      $.ajax({
        type: "POST",
        data: {
          "n": n,
          "t": t,
        },
        dataType: "html",
        url: "/ajax/sendFosCont.php",
        beforeSend: function() {
        //$result.html('<div>Секунду...</div>');
        },
        success: function(data) {
            console.log(data);
            $('.fos_kont_c').html(data);
        },
      });       
    }

}