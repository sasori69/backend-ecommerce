$('.idr-currency').on('change', function(){
    var number = $(this).val();
    number = number.replace(/\./g,''); number = number.replace(/\,/g,'.');
    if(parseFloat(number)){
        number = parseFloat(number);
    }else{
        number = parseFloat("0");
    }
    if(number == '0'){ 
        number = ''; 
    }else{
        number = number.toLocaleString('id-ID')
    }
    $(this).val(number);
});

$('.input-number').on('change', function(){
    var number = $(this).val();
    if(parseInt(number)){
        number = parseInt(number);
        if(number < 1 ){ number = ''; }
    }else{
        number = '';
    }
    $(this).val(number);
});