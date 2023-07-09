import api from "../api.js";

window.fetch_user_info = api.fetch_user_info();
window.domain_name = window.location.origin;
window.$app_name = $.trim( $('#app_name').attr('content') );
window.csrf_token = $('#csrf_token').attr('content');
window.main_party = $('#main_party').attr('content');

require('./files.js');

window.count_down = ( date, div_element_id = "count_down" ) => {
  // Set the date we're counting down to
  var countDownDate = new Date( date ).getTime();
 
 // Update the count down every 02 second
 var x = setInterval(function() {
 
   // Get todays date and time
   var now = new Date().getTime();
 
   // Find the distance between now an the count down date 
   var distance = countDownDate - now;

   // Time calculations for days, hours, minutes and seconds
   var days    = Math.floor(distance / (1000 * 60 * 60 * 24));
   var hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
   var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
   var seconds = Math.floor((distance % (1000 * 60)) / 1000);
 
   // Display the result in the element with id="count_down"
   document.getElementById(div_element_id).innerHTML = ``````````````````
             days + "<font color='green'> Days,</font> " + 
             hours + "<font color='green'>  Hours,</font> " + 
             minutes + "<font color='green'> Mins,</font> " + 
             seconds + "<font color='green'> Secs <br></font>";
 
   // If the count down is finished, write some text 
   if( distance < 0) {
        clearInterval(x);
        document.getElementById(div_element_id).innerHTML = "Time Elapsed";
      }
 }, 1000);
}

window._user_confirmation = (handler,
                                  msg_body = 'Please, Confirm this Activity...', 
                                  msg_title = 'Confirmation Required !', 
                                  action_btn = "Alright, continue", 
                                  cancel_btn = "Cancel") => {
  
    $(`
      <div class="modal text-dark" id="confirmation__modal" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-dialog-centered">
              
              <div class="modal-content switch_theme_">
                  <div class="modal-header">
          <h5> ${msg_title} </h5>

                  </div>
  
                  <div class="modal-body modal-body-sub_agile">
                      
            <h6 class="modal-title lead" id="modal_title__"></h6>
                      <section class="modal_body_left modal_body_left1">
                   <h6 id="modal_body__" class="text-center">${msg_body}</h6>
                          <div class="clearfix"></div>
                      </section>
            
                      <div class="clearfix"></div>
                  </div>
  
            <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success btn-xs" id="confirmation_modal_btn__"> ${action_btn} </button>
                    <button type="button" class="btn btn-outline-danger btn-xs" id="confimation_cancel_btn__"> ${cancel_btn} </button>
                  </div>
              </div>
              
          </div>
      </div>
       `)
       .appendTo('body');
   var $div = $("#confirmation__modal");
       $div.modal('show');
       $("#confirmation_modal_btn__").on('click', () => {
           handler(true);
           $div.modal('hide');
         });
         
       $("#confimation_cancel_btn__").on('click', () => {
           handler(false);
           $div.modal('hide');
         });
        $div.on('hidden.bs.modal', () => {
              $div.remove();
          });
  };

window.$clear_form = () => {
  $('.form-control').val(''); 
};
window.$short_text = ($content, $max_number = 25) => {
  return (  $content.length > $max_number ) ? $content.substr( 0, ($max_number - 1) )+'...' : $content ;
};
Vue.prototype.$short_text = ($content, $max_number = 25) => {
  $content = $.trim( $content );
  if(! isNaN($content) ){
    if( $content.length < 4){
      return $content;
    }
     else if( $content.length > 3 && $content.length < 7){
        return $content.substr( 0, ($content.length - 3) ) + "K+";
     }
     else if( $content.length > 6 && $content.length < 10){
      return $content.substr( 0, ($content.length - 6) )  + "M+";
     }  
     else{
      return $content.substr( 0, ($content.length - 9) )  + "B+";
     }
  }
  return (  $content.length > $max_number ) ? $content.substr( 0, ($max_number - 1) )+'...' : $content ;
};
Vue.prototype.$acronym = ($word) => {
        var $text = "";
        var $words = $word.split(" ");
        $words.forEach(($value) => {
            $text += $value[0];
        });
        return $text;
};

window.change_page_title = ( text = '' ) => {
  return document.title = `${text} - ${$app_name}`;
};
window.change_page_meta_description = ( description = '' ) => {
  return $('.meta_description').attr('content', `${description} - ${$app_name}`);
};

Vue.prototype.number_format = ( value, step = 2 ) => {
  var number_ = parseFloat( value );
      number_.toFixed(2);
      return number_.toLocaleString( number_, step);  
};

window.number_format = ( value, step = 2 ) => {
  var number_ = parseFloat( value );
      number_.toFixed(2);
      return number_.toLocaleString( number_, step);  
};
