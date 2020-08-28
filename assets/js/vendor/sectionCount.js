function SectionCount(){
    const section = $(document).find('section');
    section.eq(0).addClass('main-section');
    let counter = 1;
    section.each(function(){
            name = 'section-' + counter;
            $(this).attr('data-id', name );
            counter++;
    });
    try{
        Revealator.effects_padding = '-700';
        section.eq(0).addClass('main-section');
        section.not('.main-section').filter(':odd').addClass('odd revealator-slideup revealator-once revealator-delay1');
        section.not('.main-section').filter(':even').addClass('even revealator-zoomin revealator-once revealator-delay1');   
    }
    catch(e){
        console.log('Revealator not included');
    }
}
