(function(){
var $target = $('.anime'),
animationClass = 'anime__start'; //classe que vai dar vida a animação vai ser inserida
offset = $(window).height() * 3/4;

function animeScroll(){
    var documentTop = $(document).scrollTop();//calcula a distancia entre o topo e o documento pelo scroll
    
    //pegar cada item e não tudo de uma vez
    $target.each(function(){

        //Pega distancia entre o item e o topo
        var itemTop = $(this).offset().top;
        if(documentTop > itemTop - offset){
            $(this).addClass(animationClass);
        }else{
            $(this).removeClass(animationClass);
        }
    })

}

animeScroll();//ativa a função

$(document).scroll(function(){
    animeScroll();
})

}());//()invoca a função function, com isso deixamos ela encapsulada